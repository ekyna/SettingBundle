<?php

namespace Ekyna\Bundle\SettingBundle\EventListener;

use Ekyna\Bundle\SettingBundle\Event\BuildRedirectionEvent;
use Ekyna\Bundle\SettingBundle\Event\DiscardRedirectionEvent;
use Ekyna\Bundle\SettingBundle\Event\RedirectionEvents;
use Ekyna\Bundle\SettingBundle\Redirection\RedirectionBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class RedirectionEventSubscriber
 * @package Ekyna\Bundle\SettingBundle\EventListener
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class RedirectionEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var RedirectionBuilder
     */
    private $builder;

    /**
     * @var array
     */
    private $builtRedirections;

    /**
     * @var array
     */
    private $discardsRedirections;


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
    public function onBuildRedirection(BuildRedirectionEvent $event)
    {
        if ($event->getFrom() === $event->getTo()) {
            return;
            //throw new \InvalidArgumentException('Infinite redirection loop detected.');
        }

        $updateRedirection = function ($index, BuildRedirectionEvent $event) {
            $this->builtRedirections[$index]['to'] = $event->getTo();
            if ($event->isPermanent()) {
                $this->builtRedirections[$index]['permanent'] = true;
            }
        };

        $found = false;
        foreach ($this->builtRedirections as $index => $data) {
            if ($data['to'] == $event->getFrom()) {
                $updateRedirection($index, $event);
                continue;
            }
            if ($data['from'] == $event->getFrom()) {
                $updateRedirection($index, $event);
                $found = true;
            }
        }
        if (!$found) {
            $this->builtRedirections[] = array(
                'from'      => $event->getFrom(),
                'to'        => $event->getTo(),
                'permanent' => $event->isPermanent(),
            );
        }
    }
    /**
     * Discard redirection event handler.
     *
     * @param DiscardRedirectionEvent $event
     */
    public function onDiscardRedirection(DiscardRedirectionEvent $event)
    {
        if (!in_array($event->getPath(), $this->discardsRedirections)) {
            $this->discardsRedirections[] = $event->getPath();
        }
        // TODO remove built redirections whose "to" points to this event "path"
    }

    /**
     * Kernel terminate event handler.
     */
    public function onKernelTerminate()
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
    private function clear()
    {
        $this->builtRedirections = [];
        $this->discardsRedirections = [];
    }

    /**
     * {@inheritdoc}
     */
    static public function getSubscribedEvents()
    {
        return array(
            RedirectionEvents::BUILD   => array('onBuildRedirection', 0),
            RedirectionEvents::DISCARD => array('onDiscardRedirection', 0),
            KernelEvents::TERMINATE    => array('onKernelTerminate', 0),
        );
    }
}
