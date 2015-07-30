<?php

namespace Ekyna\Bundle\SettingBundle\Table\Type;

use Ekyna\Bundle\AdminBundle\Table\Type\ResourceTableType;
use Ekyna\Component\Table\TableBuilderInterface;

/**
 * Class RedirectionType
 * @package Ekyna\Bundle\SettingBundle\Table\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class RedirectionType extends ResourceTableType
{
    /**
     * {@inheritdoc}
     */
    public function buildTable(TableBuilderInterface $builder, array $options)
    {
        $builder
            ->addColumn('fromPath', 'anchor', array(
                'label' => 'ekyna_setting.redirection.field.from_path',
                'sortable' => true,
                'route_name' => 'ekyna_setting_redirection_admin_show',
                'route_parameters_map' => array(
                    'redirectionId' => 'id'
                ),
            ))
            ->addColumn('toPath', 'text', array(
                'label' => 'ekyna_setting.redirection.field.to_path',
            ))
            ->addColumn('permanent', 'boolean', array(
                'label' => 'ekyna_setting.redirection.field.permanent',
                'route_name' => 'ekyna_setting_redirection_admin_toggle',
                'route_parameters' => array('field' => 'permanent'),
                'route_parameters_map' => array('redirectionId' => 'id'),
            ))
            ->addColumn('enabled', 'boolean', array(
                'label' => 'ekyna_core.field.enabled',
                'route_name' => 'ekyna_setting_redirection_admin_toggle',
                'route_parameters' => array('field' => 'enabled'),
                'route_parameters_map' => array(
                    'redirectionId' => 'id',
                ),
            ))
            ->addColumn('actions', 'admin_actions', array(
                'buttons' => array(
                    array(
                        'label' => 'ekyna_core.button.edit',
                        'class' => 'warning',
                        'route_name' => 'ekyna_setting_redirection_admin_edit',
                        'route_parameters_map' => array(
                            'redirectionId' => 'id'
                        ),
                        'permission' => 'edit',
                    ),
                    array(
                        'label' => 'ekyna_core.button.remove',
                        'class' => 'danger',
                        'route_name' => 'ekyna_setting_redirection_admin_remove',
                        'route_parameters_map' => array(
                            'redirectionId' => 'id'
                        ),
                        'permission' => 'delete',
                    ),
                ),
            ))
            ->addFilter('fromPath', 'text', array(
                'label' => 'ekyna_setting.redirection.field.from_path',
            ))
            ->addFilter('toPath', 'text', array(
                'label' => 'ekyna_setting.redirection.field.to_path',
            ))
            ->addFilter('enabled', 'boolean', array(
                'label' => 'ekyna_core.field.enabled',
            ))
            ->addFilter('permanent', 'boolean', array(
                'label' => 'ekyna_setting.redirection.field.permanent',
            ))
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
