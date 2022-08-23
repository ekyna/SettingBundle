<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Table\Type;

use Ekyna\Bundle\ResourceBundle\Table\Type\AbstractResourceType;
use Ekyna\Bundle\TableBundle\Extension\Type as BType;
use Ekyna\Component\Table\Extension\Core\Type as CType;
use Ekyna\Component\Table\TableBuilderInterface;

use function Symfony\Component\Translation\t;

/**
 * Class RedirectionType
 * @package Ekyna\Bundle\SettingBundle\Table\Type
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class RedirectionType extends AbstractResourceType
{
    public function buildTable(TableBuilderInterface $builder, array $options): void
    {
        $builder
            ->addColumn('fromPath', BType\Column\AnchorType::class, [
                'label'    => t('redirection.field.from_path', [], 'EkynaSetting'),
                'position' => 10,
            ])
            ->addColumn('toPath', CType\Column\TextType::class, [
                'label'    => t('redirection.field.to_path', [], 'EkynaSetting'),
                'position' => 20,
            ])
            ->addColumn('count', CType\Column\NumberType::class, [
                'label'    => t('redirection.field.count', [], 'EkynaSetting'),
                'position' => 30,
            ])
            ->addColumn('usedAt', CType\Column\DateTimeType::class, [
                'label'       => t('redirection.field.used_at', [], 'EkynaSetting'),
                'time_format' => 'none',
                'position'    => 40,
            ])
            ->addColumn('permanent', CType\Column\BooleanType::class, [
                'label'    => t('redirection.field.permanent', [], 'EkynaSetting'),
                'position' => 50,
            ])
            ->addColumn('enabled', CType\Column\BooleanType::class, [
                'label'    => t('field.enabled', [], 'EkynaUi'),
                'position' => 60,
            ])
            ->addColumn('actions', BType\Column\ActionsType::class, [
                'resource' => $this->dataClass,
            ])
            ->addFilter('fromPath', CType\Filter\TextType::class, [
                'label'    => t('redirection.field.from_path', [], 'EkynaSetting'),
                'position' => 10,
            ])
            ->addFilter('toPath', CType\Filter\TextType::class, [
                'label'    => t('redirection.field.to_path', [], 'EkynaSetting'),
                'position' => 20,
            ])
            ->addFilter('enabled', CType\Filter\BooleanType::class, [
                'label'    => t('field.enabled', [], 'EkynaUi'),
                'position' => 30,
            ])
            ->addFilter('permanent', CType\Filter\BooleanType::class, [
                'label'    => t('redirection.field.permanent', [], 'EkynaSetting'),
                'position' => 40,
            ]);
    }
}
