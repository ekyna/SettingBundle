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
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('ekyna_admin.menu.pool')) {
            return;
        }

        $pool = $container->getDefinition('ekyna_admin.menu.pool');

        $pool->addMethodCall('createGroup', [[
            'name'     => 'setting',
            'label'    => 'ekyna_setting.label',
            'icon'     => 'cogs',
            'position' => 100,
        ]]);
        $pool->addMethodCall('createEntry', ['setting', [
            'name'     => 'redirection',
            'route'    => 'ekyna_setting_redirection_admin_home',
            'label'    => 'ekyna_setting.redirection.label.plural',
            'resource' => 'ekyna_setting_redirection',
            'position' => 97,
        ]]);
        $pool->addMethodCall('createEntry', ['setting', [
            'name'     => 'helper',
            'route'    => 'ekyna_setting_helper_admin_home',
            'label'    => 'ekyna_setting.helper.label.plural',
            'resource' => 'ekyna_setting_helper',
            'position' => 98,
        ]]);
        $pool->addMethodCall('createEntry', ['setting', [
            'name'     => 'parameter',
            'route'    => 'ekyna_setting_parameter_admin_show',
            'label'    => 'ekyna_setting.parameter.label.plural',
            'resource' => 'ekyna_setting_parameter',
            'position' => 99,
        ]]);
    }
}
