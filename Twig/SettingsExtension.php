<?php

namespace Ekyna\Bundle\SettingBundle\Twig;

use Ekyna\Bundle\SettingBundle\Manager\SettingsManagerInterface;

/**
 * SettingExtension
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 * @see https://github.com/Sylius/Sylius/blob/master/src/Sylius/Bundle/SettingsBundle/Twig/SyliusSettingsExtension.php
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
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('get_settings', array($this, 'getSettings')),
            new \Twig_SimpleFunction('get_setting', array($this, 'getSettingsParameter')),
        );
    }

    /**
     * Load settings from given namespace
     *
     * @param string $namespace
     *
     * @return array
     */
    public function getSettings($namespace)
    {
        return $this->settingsManager->loadSettings($namespace);
    }

    /**
     * Load settings parameter for given namespace and name.
     *
     * @param string $name
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function getSettingsParameter($name)
    {
        if (false === strpos($name, '.')) {
            throw new \InvalidArgumentException(sprintf('Parameter must be in format "namespace.name", "%s" given', $name));
        }

        list($namespace, $name) = explode('.', $name);

        $settings = $this->settingsManager->loadSettings($namespace);

        return $settings->get($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_settings';
    }
}
