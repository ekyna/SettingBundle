<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\DependencyInjection;

use Ekyna\Bundle\ResourceBundle\DependencyInjection\PrependBundleConfigTrait;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

/**
 * Class EkynaSettingExtension
 * @package Ekyna\Bundle\SettingBundle\DependencyInjection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaSettingExtension extends Extension implements PrependExtensionInterface
{
    use PrependBundleConfigTrait;

    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');

        $this->configureTinymceTheme($container);

        $container
            ->getDefinition('ekyna_setting.controller.helper')
            ->replaceArgument(2, $config['helper_remotes']);
    }

    /**
     * @inheritDoc
     */
    public function prepend(ContainerBuilder $container): void
    {
        $this->prependBundleConfigFiles($container);
    }

    /**
     * Configures the tinymce theme.
     */
    private function configureTinymceTheme(ContainerBuilder $container): void
    {
        $bundles = $container->getParameter('kernel.bundles');

        $tinymceConfig = new TinymceConfiguration();
        $container->prependExtensionConfig('ekyna_ui', [
            'tinymce' => $tinymceConfig->build($bundles),
        ]);
    }
}
