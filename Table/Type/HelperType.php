<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Table\Type;

use Ekyna\Bundle\ResourceBundle\Table\Type\AbstractResourceType;
use Ekyna\Bundle\TableBundle\Extension\Type as BType;
use Ekyna\Component\Table\Extension\Core\Type as CType;
use Ekyna\Component\Table\TableBuilderInterface;

use function Symfony\Component\Translation\t;

/**
 * Class HelperType
 * @package Ekyna\Bundle\SettingBundle\Table\Type
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class HelperType extends AbstractResourceType
{
    public function buildTable(TableBuilderInterface $builder, array $options): void
    {
        $builder
            ->addColumn('name', BType\Column\AnchorType::class, [
                'label'    => t('field.name', [], 'EkynaUi'),
                'position' => 10,
            ])
            ->addColumn('reference', CType\Column\TextType::class, [
                'label'    => t('field.reference', [], 'EkynaUi'),
                'position' => 20,
            ])
            ->addColumn('enabled', CType\Column\BooleanType::class, [
                'label'    => t('field.enabled', [], 'EkynaUi'),
                'position' => 30,
            ])
            ->addColumn('actions', BType\Column\ActionsType::class, [
                'resource' => $this->dataClass,
            ])
            ->addFilter('name', CType\Filter\TextType::class, [
                'label'    => t('field.name', [], 'EkynaUi'),
                'position' => 10,
            ])
            ->addFilter('reference', CType\Filter\TextType::class, [
                'label'    => t('field.reference', [], 'EkynaUi'),
                'position' => 20,
            ])
            ->addFilter('enabled', CType\Filter\BooleanType::class, [
                'label'    => t('field.enabled', [], 'EkynaUi'),
                'position' => 30,
            ]);
    }
}
