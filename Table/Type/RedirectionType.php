<?php

namespace Ekyna\Bundle\SettingBundle\Table\Type;

use Ekyna\Bundle\AdminBundle\Table\Type\ResourceTableType;
use Ekyna\Component\Table\TableBuilderInterface;

/**
 * Class RedirectionType
 * @package Ekyna\Bundle\SettingBundle\Table\Type
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class RedirectionType extends ResourceTableType
{
    /**
     * {@inheritdoc}
     */
    public function buildTable(TableBuilderInterface $builder, array $options)
    {
        $builder
            ->addColumn('fromPath', 'anchor', [
                'label' => 'ekyna_setting.redirection.field.from_path',
                'sortable' => true,
                'route_name' => 'ekyna_setting_redirection_admin_show',
                'route_parameters_map' => [
                    'redirectionId' => 'id'
                ],
            ])
            ->addColumn('toPath', 'text', [
                'label' => 'ekyna_setting.redirection.field.to_path',
            ])
            ->addColumn('count', 'number', [
                'label' => 'ekyna_setting.redirection.field.count',
            ])
            ->addColumn('usedAt', 'datetime', [
                'label' => 'ekyna_setting.redirection.field.used_at',
                'time_format' => 'none',
            ])
            ->addColumn('permanent', 'boolean', [
                'label' => 'ekyna_setting.redirection.field.permanent',
                'route_name' => 'ekyna_setting_redirection_admin_toggle',
                'route_parameters' => ['field' => 'permanent'],
                'route_parameters_map' => ['redirectionId' => 'id'],
            ])
            ->addColumn('enabled', 'boolean', [
                'label' => 'ekyna_core.field.enabled',
                'route_name' => 'ekyna_setting_redirection_admin_toggle',
                'route_parameters' => ['field' => 'enabled'],
                'route_parameters_map' => [
                    'redirectionId' => 'id',
                ],
            ])
            ->addColumn('actions', 'admin_actions', [
                'buttons' => [
                    [
                        'label' => 'ekyna_core.button.edit',
                        'class' => 'warning',
                        'route_name' => 'ekyna_setting_redirection_admin_edit',
                        'route_parameters_map' => [
                            'redirectionId' => 'id'
                        ],
                        'permission' => 'edit',
                    ],
                    [
                        'label' => 'ekyna_core.button.remove',
                        'class' => 'danger',
                        'route_name' => 'ekyna_setting_redirection_admin_remove',
                        'route_parameters_map' => [
                            'redirectionId' => 'id'
                        ],
                        'permission' => 'delete',
                    ],
                ],
            ])
            ->addFilter('fromPath', 'text', [
                'label' => 'ekyna_setting.redirection.field.from_path',
            ])
            ->addFilter('toPath', 'text', [
                'label' => 'ekyna_setting.redirection.field.to_path',
            ])
            ->addFilter('enabled', 'boolean', [
                'label' => 'ekyna_core.field.enabled',
            ])
            ->addFilter('permanent', 'boolean', [
                'label' => 'ekyna_setting.redirection.field.permanent',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_setting_redirection';
    }
}
