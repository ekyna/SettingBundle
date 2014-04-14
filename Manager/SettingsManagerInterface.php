<?php

namespace Ekyna\Bundle\SettingBundle\Manager;

use Ekyna\Bundle\SettingBundle\Model\Settings;

/**
 * SettingsManagerInterface
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 * @see https://github.com/Sylius/SyliusSettingsBundle/blob/master/Manager/SettingsManagerInterface.php
 */
interface SettingsManagerInterface
{
    /**
     * Load settings from given namespace.
     *
     * @param string $namespace
     *
     * @return Settings
     */
    public function loadSettings($namespace);

    /**
     * Save settings under given namespace.
     *
     * @param string   $namespace
     * @param Settings $settings
     */
    public function saveSettings($namespace, Settings $settings);
}
