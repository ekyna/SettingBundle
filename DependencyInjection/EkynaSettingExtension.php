<?php

namespace Ekyna\Bundle\SettingBundle\DependencyInjection;

use Ekyna\Bundle\ResourceBundle\DependencyInjection\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class EkynaSettingExtension
 * @package Ekyna\Bundle\SettingBundle\DependencyInjection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaSettingExtension extends \Ekyna\Bundle\ResourceBundle\DependencyInjection\AbstractExtension
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
        parent::prepend($container);

        $bundles = $container->getParameter('kernel.bundles');

        if (array_key_exists('StfalconTinymceBundle', $bundles)) {
            $this->configureStfalconTinymceBundle($container, $bundles);
        }
    }

    /**
     * Configures the StfalconTinymceBundle.
     *
     * @param ContainerBuilder $container
     * @param array            $bundles
     */
    protected function configureStfalconTinymceBundle(ContainerBuilder $container, array $bundles)
    {
        $tinymceConfig = new TinymceConfiguration();
        $container->prependExtensionConfig('stfalcon_tinymce', $tinymceConfig->build($bundles));
    }
}
