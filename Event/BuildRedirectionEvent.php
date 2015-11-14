<?php

namespace Ekyna\Bundle\SettingBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class BuildRedirectionEvent
 * @package Ekyna\Bundle\SettingBundle\Event
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class BuildRedirectionEvent extends Event
{
    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * @var boolean
     */
    private $permanent;


    /**
     * Constructor.
     *
     * @param string  $from
     * @param string  $to
     * @param boolean $permanent
     */
    public function __construct($from, $to, $permanent)
    {
        $this->from = $from;
        $this->to = $to;
        $this->permanent = $permanent;
    }

    /**
     * Returns the from.
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Returns the to.
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Returns the permanent.
     *
     * @return boolean
     */
    public function isPermanent()
    {
        return $this->permanent;
    }
}
