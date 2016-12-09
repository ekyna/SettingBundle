<?php

namespace Ekyna\Bundle\SettingBundle\Table\Type;

use Ekyna\Bundle\AdminBundle\Table\Type\ResourceTableType;
use Ekyna\Component\Table\TableBuilderInterface;

/**
 * Class HelperType
 * @package Ekyna\Bundle\SettingBundle\Table\Type
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class HelperType extends ResourceTableType
{
    /**
     * @inheritdoc
     */
    public function buildTable(TableBuilderInterface $builder, array $options)
    {
        $builder
            ->addColumn('name', 'anchor', [
                'label'                => 'ekyna_core.field.name',
                'route_name'           => 'ekyna_setting_helper_admin_show',
                'route_parameters_map' => [
                    'helperId' => 'id',
                ],
                'position'             => 10,
            ])
            ->addColumn('reference', 'text', [
                'label'    => 'ekyna_core.field.reference',
                'position' => 20,
            ])
            ->addColumn('enabled', 'boolean', [
                'label'    => 'ekyna_core.field.enabled',
                'position' => 30,
            ])
            ->addColumn('actions', 'admin_actions', [
                'buttons' => [
                    [
                        'label'                => 'ekyna_core.button.edit',
                        'class'                => 'warning',
                        'route_name'           => 'ekyna_setting_helper_admin_edit',
                        'route_parameters_map' => ['helperId' => 'id'],
                        'permission'           => 'edit',
                    ],
                    [
                        'label'                => 'ekyna_core.button.remove',
                        'class'                => 'danger',
                        'route_name'           => 'ekyna_setting_helper_admin_remove',
                        'route_parameters_map' => ['helperId' => 'id'],
                        'permission'           => 'delete',
                    ],
                ],
            ])
            ->addFilter('name', 'text', [
                'label'    => 'ekyna_core.field.name',
                'position' => 10,
            ])
            ->addFilter('reference', 'text', [
                'label'    => 'ekyna_core.field.reference',
                'position' => 20,
            ])
            ->addFilter('enabled', 'boolean', [
                'label'    => 'ekyna_core.field.enabled',
                'position' => 30,
            ]);
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'ekyna_setting_helper';
    }
}
