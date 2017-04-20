<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\EventListener;

use Ekyna\Bundle\SettingBundle\Event\BuildRedirectionEvent;
use Ekyna\Bundle\SettingBundle\Event\DiscardRedirectionEvent;
use Ekyna\Bundle\SettingBundle\Event\RedirectionEvents;
use Ekyna\Bundle\SettingBundle\Service\Redirection\RedirectionBuilder;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

use function in_array;
use function strpos;

/**
 * Class RedirectionEventSubscriber
 * @package Ekyna\Bundle\SettingBundle\EventListener
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class RedirectionEventSubscriber implements EventSubscriberInterface
{
    private RedirectionBuilder $builder;
    /** @var BuildRedirectionEvent[] */
    private array $builtRedirections;
    /** @var string[] */
    private array $discardsRedirections;


    /**
     * Constructor.
     *
     * @param RedirectionBuilder $builder
     */
    public function __construct(RedirectionBuilder $builder)
    {
        $this->builder = $builder;

        $this->clear();
    }

    /**
     * Build redirection event handler.
     *
     * @param BuildRedirectionEvent $event
     */
    public function onBuildRedirection(BuildRedirectionEvent $event): void
    {
        if (0 !== strpos($event->getFrom(), '/') || 0 !== strpos($event->getTo(), '/')) {
            return;
        }

        if ($event->getFrom() === $event->getTo()) {
            return;
        }

        $updateRedirection = function (int $index, BuildRedirectionEvent $event): void {
            $this->builtRedirections[$index]['to'] = $event->getTo();

            if ($event->isPermanent()) {
                $this->builtRedirections[$index]['permanent'] = true;
            }
        };

        $found = false;

        foreach ($this->builtRedirections as $index => $data) {
            if ($data['to'] === $event->getFrom()) {
                $updateRedirection($index, $event);

                continue;
            }

            if ($data['from'] === $event->getFrom()) {
                $updateRedirection($index, $event);
                $found = true;
            }
        }

        if (!$found) {
            $this->builtRedirections[] = [
                'from'      => $event->getFrom(),
                'to'        => $event->getTo(),
                'permanent' => $event->isPermanent(),
            ];
        }
    }

    /**
     * Discard redirection event handler.
     *
     * @param DiscardRedirectionEvent $event
     */
    public function onDiscardRedirection(DiscardRedirectionEvent $event): void
    {
        if (!in_array($event->getPath(), $this->discardsRedirections, true)) {
            $this->discardsRedirections[] = $event->getPath();
        }
        // TODO remove built redirections whose "to" points to this event "path"
    }

    /**
     * Kernel terminate event handler.
     */
    public function onKernelTerminate(): void
    {
        if (!empty($this->builtRedirections)) {
            $this->builder->buildRedirections($this->builtRedirections);
        }

        if (!empty($this->discardsRedirections)) {
            $this->builder->discardRedirections($this->discardsRedirections);
        }

        $this->clear();
    }

    /**
     * Clears the redirection data.
     */
    private function clear(): void
    {
        $this->builtRedirections = [];
        $this->discardsRedirections = [];
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            RedirectionEvents::BUILD   => ['onBuildRedirection', 0],
            RedirectionEvents::DISCARD => ['onDiscardRedirection', 0],
            KernelEvents::TERMINATE    => ['onKernelTerminate', 0],
            ConsoleEvents::TERMINATE   => ['onKernelTerminate', 0],
        ];
    }
}
