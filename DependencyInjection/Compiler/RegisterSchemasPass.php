<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler;

use Ekyna\Component\Resource\Locale\LocaleProviderAwareInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\Reference;

use function array_key_exists;
use function is_subclass_of;
use function sprintf;
use function usort;

/**
 * Class RegisterSchemasPass
 * @package Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class RegisterSchemasPass implements CompilerPassInterface
{
    public const TAG = 'ekyna_setting.schema';

    public function process(ContainerBuilder $container): void
    {
        $schemas = [];

        foreach ($container->findTaggedServiceIds(self::TAG, true) as $id => $tags) {
            if (!array_key_exists('namespace', $tags[0])) {
                throw new RuntimeException(sprintf(
                    'Service "%s" must define the "namespace" attribute on "ekyna_setting.schema" tags.',
                    $id
                ));
            }

            $namespace = $tags[0]['namespace'];
            $position = array_key_exists('position', $tags[0]) ? $tags[0]['position'] : 1;
            $schemas[] = [$position, $namespace, $id];

            $definition = $container->getDefinition($id);
            if (is_subclass_of($definition->getClass(), LocaleProviderAwareInterface::class)) {
                $definition->addMethodCall('setLocaleProvider', [new Reference('ekyna_resource.provider.locale')]);
            }
        }

        usort($schemas, function ($a, $b) {
            if ($a[0] == $b[0]) {
                return 0;
            }

            return ($a[0] < $b[0]) ? -1 : 1;
        });

        $schemaRegistry = $container->getDefinition('ekyna_setting.registry');
        foreach ($schemas as $schema) {
            $schemaRegistry->addMethodCall('registerSchema', [$schema[1], new Reference($schema[2])]);
        }
    }
}
