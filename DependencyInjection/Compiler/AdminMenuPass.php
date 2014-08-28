<?php

namespace Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * AdminMenuPass.
 *
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class AdminMenuPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('ekyna_admin.menu.pool')) {
            return;
        }

        $pool = $container->getDefinition('ekyna_admin.menu.pool');

        $pool->addMethodCall('createGroup', array(array(
            'name'     => 'configuration',
            'label'    => 'ekyna_admin.configuration',
            'icon'     => 'cogs',
            'position' => 99,
        )));
        $pool->addMethodCall('createEntry', array('configuration', array(
            'name'     => 'settings',
            'route'    => 'ekyna_setting_admin_show',
            'label'    => 'ekyna_setting.parameter.label.plural',
            'position' => 99,
        )));
    }
}
