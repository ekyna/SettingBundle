<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle;

use Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler\RegisterSchemasPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * EkynaSettingBundle
 * @package Ekyna\Bundle\SettingBundle
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaSettingBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterSchemasPass());
    }
}
