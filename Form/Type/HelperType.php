<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Form\Type;

use Ekyna\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

use function Symfony\Component\Translation\t;

/**
 * Class HelperType
 * @package Ekyna\Bundle\SettingBundle\Form\Type
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class HelperType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', Type\TextType::class, [
                'label'    => t('field.name', [], 'EkynaUi'),
                'required' => true,
            ])
            ->add('reference', Type\TextType::class, [
                'label'    => t('field.reference', [], 'EkynaUi'),
                'required' => true,
            ])
            ->add('content', Type\TextareaType::class, [
                'label'    => t('field.content', [], 'EkynaUi'),
                'required' => false,
                'attr'     => [
                    'class'      => 'tinymce',
                    'data-theme' => 'helper',
                ],
            ])
            ->add('enabled', Type\CheckboxType::class, [
                'label'    => t('field.enabled', [], 'EkynaUi'),
                'required' => false,
            ]);
    }
}
