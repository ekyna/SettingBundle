<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class BuildRedirectionEvent
 * @package Ekyna\Bundle\SettingBundle\Event
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
final class BuildRedirectionEvent extends Event
{
    private string $from;
    private string $to;
    private bool   $permanent;

    public function __construct(string $from, string $to, bool $permanent)
    {
        $this->from = $from;
        $this->to = $to;
        $this->permanent = $permanent;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function isPermanent(): bool
    {
        return $this->permanent;
    }
}
