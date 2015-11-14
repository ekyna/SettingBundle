<?php

namespace Ekyna\Bundle\SettingBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class DiscardRedirectionEvent
 * @package Ekyna\Bundle\SettingBundle\Event
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class DiscardRedirectionEvent extends Event
{
    /**
     * @var string
     */
    private $path;


    /**
     * Constructor.
     *
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Returns the path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
