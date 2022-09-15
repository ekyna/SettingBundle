<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler;

use Ekyna\Bundle\AdminBundle\Service\Menu\PoolHelper;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class AdminMenuPass
 * @package Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class AdminMenuPass implements CompilerPassInterface
{
    public const GROUP = [
        'name'     => 'setting',
        'label'    => 'setting',
        'domain'   => 'EkynaSetting',
        'icon'     => 'cogs',
        'position' => 100,
    ];

    public function process(ContainerBuilder $container): void
    {
        $helper = new PoolHelper(
            $container->getDefinition('ekyna_admin.menu.pool')
        );

        $helper
            ->addGroup(self::GROUP)
            ->addEntry([
                'name'     => 'parameters',
                'route'    => 'admin_ekyna_setting_parameter_read',
                'resource' => 'ekyna_setting.parameter',
                'position' => 100,
            ])
            ->addEntry([
                'name'     => 'redirections',
                'resource' => 'ekyna_setting.redirection',
                'position' => 998,
            ])
            ->addEntry([
                'name'     => 'helpers',
                'resource' => 'ekyna_setting.helper',
                'position' => 999,
            ]);
    }
}
