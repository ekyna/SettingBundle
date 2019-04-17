<?php

namespace Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler;

use Ekyna\Component\Resource\Locale\LocaleProviderAwareInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RegisterSchemasPass
 * @package Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class RegisterSchemasPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('ekyna_setting.schema_registry')) {
            return;
        }

        $schemas = [];

        foreach ($container->findTaggedServiceIds('ekyna_setting.schema') as $id => $attributes) {
            if (!array_key_exists('namespace', $attributes[0])) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must define the "namespace" attribute on "ekyna_setting.schema" tags.',
                    $id));
            }

            $namespace = $attributes[0]['namespace'];
            $position = array_key_exists('position', $attributes[0]) ? $attributes[0]['position'] : 1;
            $schemas[] = [$position, $namespace, $id];

            $definition = $container->getDefinition($id);
            if (is_subclass_of($definition->getClass(), LocaleProviderAwareInterface::class)) {
                $definition->addMethodCall('setLocaleProvider', [new Reference('ekyna_resource.locale_provider')]);
            }
        }

        usort($schemas, function ($a, $b) {
            if ($a[0] == $b[0]) {
                return 0;
            }

            return ($a[0] < $b[0]) ? -1 : 1;
        });

        $schemaRegistry = $container->getDefinition('ekyna_setting.schema_registry');
        foreach ($schemas as $schema) {
            $schemaRegistry->addMethodCall('registerSchema', [$schema[1], new Reference($schema[2])]);
        }
    }
}
