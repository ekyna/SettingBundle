<?php

namespace Ekyna\Bundle\SettingBundle\Table\Type;

use Ekyna\Bundle\AdminBundle\Table\Type\ResourceTableType;
use Ekyna\Bundle\TableBundle\Extension\Type as BType;
use Ekyna\Component\Table\Extension\Core\Type as CType;
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
            ->addColumn('name', BType\Column\AnchorType::class, [
                'label'                => 'ekyna_core.field.name',
                'route_name'           => 'ekyna_setting_helper_admin_show',
                'route_parameters_map' => [
                    'helperId' => 'id',
                ],
                'position'             => 10,
            ])
            ->addColumn('reference', CType\Column\TextType::class, [
                'label'    => 'ekyna_core.field.reference',
                'position' => 20,
            ])
            ->addColumn('enabled', CType\Column\BooleanType::class, [
                'label'    => 'ekyna_core.field.enabled',
                'position' => 30,
            ])
            ->addColumn('actions', BType\Column\ActionsType::class, [
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
            ->addFilter('name', CType\Filter\TextType::class, [
                'label'    => 'ekyna_core.field.name',
                'position' => 10,
            ])
            ->addFilter('reference', CType\Filter\TextType::class, [
                'label'    => 'ekyna_core.field.reference',
                'position' => 20,
            ])
            ->addFilter('enabled', CType\Filter\BooleanType::class, [
                'label'    => 'ekyna_core.field.enabled',
                'position' => 30,
            ]);
    }
}
