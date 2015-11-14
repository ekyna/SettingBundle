<?php

namespace Ekyna\Bundle\SettingBundle\Event;

/**
 * Class RedirectionEvents
 * @package Ekyna\Bundle\SettingBundle\Event
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
final class RedirectionEvents
{
    const BUILD   = 'ekyna_setting.redirection.build';
    const DISCARD = 'ekyna_setting.redirection.discard';
}
