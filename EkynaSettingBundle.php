<?php

namespace Ekyna\Bundle\SettingBundle;

use Ekyna\Bundle\ResourceBundle\AbstractBundle;
use Ekyna\Bundle\SettingBundle\DependencyInjection\Compiler as Pass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * EkynaSettingBundle
 * @package Ekyna\Bundle\SettingBundle
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaSettingBundle extends AbstractBundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new Pass\AdminMenuPass());
        $container->addCompilerPass(new Pass\RegisterSchemasPass());
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelInterfaces()
    {
        return array(
            'Ekyna\Bundle\SettingBundle\Model\RedirectionInterface' => 'ekyna_setting.redirection.class',
        );
    }
}
