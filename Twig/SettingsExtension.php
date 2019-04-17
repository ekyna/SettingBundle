<?php

namespace Ekyna\Bundle\SettingBundle\Twig;

use Ekyna\Bundle\SettingBundle\Manager\SettingsManagerInterface;

/**
 * Class SettingsExtension
 * @package Ekyna\Bundle\SettingBundle\Twig
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class SettingsExtension extends \Twig_Extension
{
    /**
     * Settings manager
     *
     * @var SettingsManagerInterface
     */
    private $settingsManager;


    /**
     * Constructor
     *
     * @param SettingsManagerInterface $settingsManager
     */
    public function __construct(SettingsManagerInterface $settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }

    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('get_settings', [$this->settingsManager, 'loadSettings']),
            new \Twig_SimpleFunction('get_setting', [$this->settingsManager, 'getParameter']),
        ];
    }
}
