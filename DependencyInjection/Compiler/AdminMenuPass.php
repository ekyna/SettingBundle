<?php

namespace Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Class AdminMenuPass
 * @package Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler
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
            'name'     => 'setting',
            'label'    => 'ekyna_setting.label',
            'icon'     => 'cogs',
            'position' => 99,
        )));
        $pool->addMethodCall('createEntry', array('setting', array(
            'name'     => 'parameter',
            'route'    => 'ekyna_setting_parameter_admin_show',
            'label'    => 'ekyna_setting.parameter.label.plural',
            'resource' => 'ekyna_setting_parameter',
            'position' => 98,
        )));
        $pool->addMethodCall('createEntry', array('setting', array(
            'name'     => 'helper',
            'route'    => 'ekyna_setting_helper_admin_home',
            'label'    => 'ekyna_setting.helper.label.plural',
            'resource' => 'ekyna_setting_helper',
            'position' => 99,
        )));
    }
}
