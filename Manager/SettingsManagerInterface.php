<?php

namespace Ekyna\Bundle\SettingBundle\Manager;

use Ekyna\Bundle\SettingBundle\Model\Settings;

/**
 * Interface SettingsManagerInterface
 * @package Ekyna\Bundle\SettingBundle\Manager
 * @author  Etienne Dauvergne <contact@ekyna.com>
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
    public function loadSettings(string $namespace);

    /**
     * Save settings under given namespace.
     *
     * @param string   $namespace
     * @param Settings $settings
     */
    public function saveSettings(string $namespace, Settings $settings);

    /**
     * Returns settings parameter for given namespace and name.
     *
     * @param string $name
     * @param string $locale
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function getParameter(string $name, string $locale = null);

    /**
     * Returns namespaces labels.
     *
     * @return array
     */
    public function getLabels();

    /**
     * Returns namespaces show templates.
     *
     * @return array
     */
    public function getShowTemplates();

    /**
     * Returns namespaces form templates.
     *
     * @return array
     */
    public function getFormTemplates();
}
