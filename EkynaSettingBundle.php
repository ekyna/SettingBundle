<?php

namespace Ekyna\Bundle\SettingBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler\AdminMenuPass;
use Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler\RegisterSchemasPass;

/**
 * EkynaSettingBundle
 *
 * @author Étienne Dauvergne <contact@ekyna.com>
 * @see https://github.com/Sylius/SyliusSettingsBundle
 */
class EkynaSettingBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new AdminMenuPass());
        $container->addCompilerPass(new RegisterSchemasPass());
    }
}
