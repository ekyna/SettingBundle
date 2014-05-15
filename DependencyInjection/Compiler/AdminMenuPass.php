<?php

namespace Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class AdminMenuPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('ekyna_admin.menu.pool')) {
            return;
        }

        $pool = $container->getDefinition('ekyna_admin.menu.pool');

        $pool->addMethodCall('createGroupReference', array(
            'config', 'ekyna_core.field.config', 'cogs', null, 99
        ));
        $pool->addMethodCall('createEntryReference', array(
            'config', 'settings', 'ekyna_setting_admin_show', 'ekyna_setting.parameter.label.plural'
        ));
    }
}