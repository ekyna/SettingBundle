<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class DiscardRedirectionEvent
 * @package Ekyna\Bundle\SettingBundle\Event
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
final class DiscardRedirectionEvent extends Event
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
