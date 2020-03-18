<?php

namespace Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler;

use Ekyna\Bundle\AdminBundle\Menu\MenuPool;
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
        if (!$container->hasDefinition(MenuPool::class)) {
            return;
        }

        $pool = $container->getDefinition(MenuPool::class);

        $pool->addMethodCall('createGroup', [[
            'name'     => 'setting',
            'label'    => 'ekyna_setting.label',
            'icon'     => 'cogs',
            'position' => 100,
        ]]);
        $pool->addMethodCall('createEntry', ['setting', [
            'name'     => 'redirection',
            'route'    => 'ekyna_setting_redirection_admin_list',
            'label'    => 'ekyna_setting.redirection.label.plural',
            'resource' => 'ekyna_setting_redirection',
            'position' => 999,
        ]]);
        $pool->addMethodCall('createEntry', ['setting', [
            'name'     => 'helper',
            'route'    => 'ekyna_setting_helper_admin_list',
            'label'    => 'ekyna_setting.helper.label.plural',
            'resource' => 'ekyna_setting_helper',
            'position' => 999,
        ]]);
        $pool->addMethodCall('createEntry', ['setting', [
            'name'     => 'parameter',
            'route'    => 'ekyna_setting_parameter_admin_show',
            'label'    => 'ekyna_setting.parameter.label.plural',
            'resource' => 'ekyna_setting_parameter',
            'position' => 100,
        ]]);
    }
}
