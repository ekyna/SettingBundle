<?php

namespace Ekyna\Bundle\SettingBundle\Table\Type;

use Ekyna\Bundle\AdminBundle\Table\Type\ResourceTableType;
use Ekyna\Bundle\TableBundle\Extension\Type as BType;
use Ekyna\Component\Table\Extension\Core\Type as CType;
use Ekyna\Component\Table\TableBuilderInterface;

/**
 * Class RedirectionType
 * @package Ekyna\Bundle\SettingBundle\Table\Type
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class RedirectionType extends ResourceTableType
{
    /**
     * @inheritdoc
     */
    public function buildTable(TableBuilderInterface $builder, array $options)
    {
        $builder
            ->addColumn('fromPath', BType\Column\AnchorType::class, [
                'label'                => 'ekyna_setting.redirection.field.from_path',
                'route_name'           => 'ekyna_setting_redirection_admin_show',
                'route_parameters_map' => ['redirectionId' => 'id'],
                'position'             => 10,
            ])
            ->addColumn('toPath', CType\Column\TextType::class, [
                'label'    => 'ekyna_setting.redirection.field.to_path',
                'position' => 20,
            ])
            ->addColumn('count', CType\Column\NumberType::class, [
                'label'    => 'ekyna_setting.redirection.field.count',
                'position' => 30,
            ])
            ->addColumn('usedAt', CType\Column\DateTimeType::class, [
                'label'       => 'ekyna_setting.redirection.field.used_at',
                'time_format' => 'none',
                'position'    => 40,
            ])
            ->addColumn('permanent', CType\Column\BooleanType::class, [
                'label'                => 'ekyna_setting.redirection.field.permanent',
                'route_name'           => 'ekyna_setting_redirection_admin_toggle',
                'route_parameters'     => ['field' => 'permanent'],
                'route_parameters_map' => ['redirectionId' => 'id'],
                'position'             => 50,
            ])
            ->addColumn('enabled', CType\Column\BooleanType::class, [
                'label'                => 'ekyna_core.field.enabled',
                'route_name'           => 'ekyna_setting_redirection_admin_toggle',
                'route_parameters'     => ['field' => 'enabled'],
                'route_parameters_map' => ['redirectionId' => 'id'],
                'position'             => 60,
            ])
            ->addColumn('actions', BType\Column\ActionsType::class, [
                'buttons' => [
                    [
                        'label'                => 'ekyna_core.button.edit',
                        'class'                => 'warning',
                        'route_name'           => 'ekyna_setting_redirection_admin_edit',
                        'route_parameters_map' => ['redirectionId' => 'id'],
                        'permission'           => 'edit',
                    ],
                    [
                        'label'                => 'ekyna_core.button.remove',
                        'class'                => 'danger',
                        'route_name'           => 'ekyna_setting_redirection_admin_remove',
                        'route_parameters_map' => ['redirectionId' => 'id'],
                        'permission'           => 'delete',
                    ],
                ],
            ])
            ->addFilter('fromPath', CType\Filter\TextType::class, [
                'label'    => 'ekyna_setting.redirection.field.from_path',
                'position' => 10,
            ])
            ->addFilter('toPath', CType\Filter\TextType::class, [
                'label'    => 'ekyna_setting.redirection.field.to_path',
                'position' => 20,
            ])
            ->addFilter('enabled', CType\Filter\BooleanType::class, [
                'label'    => 'ekyna_core.field.enabled',
                'position' => 30,
            ])
            ->addFilter('permanent', CType\Filter\BooleanType::class, [
                'label'    => 'ekyna_setting.redirection.field.permanent',
                'position' => 40,
            ]);
    }
}
