<?php

namespace Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * RegisterSchemasPass.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@sylius.pl>
 * @see https://github.com/Sylius/SyliusSettingsBundle/blob/master/DependencyInjection/Compiler/RegisterSchemasPass.php
 * @author Étienne Dauvergne <contact@ekyna.com>
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

        $schemas = array();

        foreach ($container->findTaggedServiceIds('ekyna_setting.schema') as $id => $attributes) {
            if (!array_key_exists('namespace', $attributes[0])) {
                throw new \InvalidArgumentException(sprintf('Service "%s" must define the "namespace" attribute on "ekyna_setting.schema" tags.', $id));
            }

            $namespace = $attributes[0]['namespace'];
            $position  = array_key_exists('position', $attributes[0]) ? $attributes[0]['position'] : 1;
            $schemas[] = array($position, $namespace, $id);
        }

        usort($schemas, function($a, $b) {
        	if ($a[0] == $b[0]) {
        	    return 0;
        	}
        	return ($a[0] < $b[0]) ? -1 : 1;
        });

        $schemaRegistry = $container->getDefinition('ekyna_setting.schema_registry');
        foreach($schemas as $schema) {
            $schemaRegistry->addMethodCall('registerSchema', array($schema[1], new Reference($schema[2])));
        }
    }
}
