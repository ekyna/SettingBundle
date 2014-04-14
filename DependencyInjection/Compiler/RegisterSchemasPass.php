<?php

namespace Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * RegisterSchemasPass
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@sylius.pl>
 * @see https://github.com/Sylius/SyliusSettingsBundle/blob/master/DependencyInjection/Compiler/RegisterSchemasPass.php
 */
class RegisterSchemasPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('ekyna_setting.schema_registry')) {
            return;
        }

        $schemaRegistry = $container->getDefinition('ekyna_setting.schema_registry');

        foreach ($container->findTaggedServiceIds('ekyna_setting.schema') as $id => $attributes) {
            if (!array_key_exists('namespace', $attributes[0])) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must define the "namespace" attribute on "ekyna_setting.schema" tags.', $id));
            }

            $namespace = $attributes[0]['namespace'];

            $schemaRegistry->addMethodCall('registerSchema', array($namespace, new Reference($id)));
        }
    }
}
