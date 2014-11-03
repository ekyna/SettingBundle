<?php

namespace Ekyna\Bundle\SettingBundle\DependencyInjection;

use Ekyna\Bundle\AdminBundle\DependencyInjection\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class EkynaSettingExtension
 * @package Ekyna\Bundle\SettingBundle\DependencyInjection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaSettingExtension extends AbstractExtension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->configure($configs, 'ekyna_setting', new Configuration(), $container);

        $container->setParameter('ekyna_setting.helper_remotes', $config['helper_remotes']);
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        if (array_key_exists('AsseticBundle', $bundles)) {
            $this->configureAsseticBundle($container, $config);
        }
    }

    /**
     * Configures the assetic bundle.
     *
     * @param ContainerBuilder $container
     * @param array            $config
     */
    protected function configureAsseticBundle(ContainerBuilder $container, array $config)
    {
        $asseticConfig = new AsseticConfiguration();
        $container->prependExtensionConfig('assetic', array(
            'assets' => $asseticConfig->build($config),
            'bundles' => array('EkynaSettingBundle'),
        ));
    }

    /**
     * Configures the StfalconTinymceBundle.
     *
     * @param ContainerBuilder $container
     * @param array            $config
     */
    protected function configureStfalconTinymceBundle(ContainerBuilder $container, array $config)
    {
        $tinymceConfig = new TinymceConfiguration();
        $container->prependExtensionConfig('stfalcon_tinymce', $tinymceConfig->build($config));
    }
}
