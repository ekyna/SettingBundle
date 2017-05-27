<?php

namespace Ekyna\Bundle\SettingBundle\DependencyInjection;

use Ekyna\Bundle\ResourceBundle\DependencyInjection\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class EkynaSettingExtension
 * @package Ekyna\Bundle\SettingBundle\DependencyInjection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaSettingExtension extends AbstractExtension
{
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->configure($configs, 'ekyna_setting', new Configuration(), $container);

        $container->setParameter('ekyna_setting.helper_remotes', $config['helper_remotes']);
    }

    /**
     * @inheritdoc
     */
    public function prepend(ContainerBuilder $container)
    {
        parent::prepend($container);

        $bundles = $container->getParameter('kernel.bundles');

        // TODO
        /*if (array_key_exists('EkynaCoreBundle', $bundles)) {
            $this->configureTinymceTheme($container, $bundles);
        }*/
    }

    /**
     * Configures the tinymce theme.
     *
     * @param ContainerBuilder $container
     * @param array            $bundles
     */
    private function configureTinymceTheme(ContainerBuilder $container, array $bundles)
    {
        $tinymceConfig = new TinymceConfiguration();
        $container->prependExtensionConfig('ekyna_core', [
            'tinymce' => $tinymceConfig->build($bundles),
        ]);
    }
}
