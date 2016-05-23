<?php

namespace Ekyna\Bundle\SettingBundle\Form\Type;

use Ekyna\Bundle\AdminBundle\Form\Type\ResourceFormType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class HelperType
 * @package Ekyna\Bundle\SettingBundle\Form\Type
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class HelperType extends ResourceFormType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', Type\TextType::class, [
                'label'    => 'ekyna_core.field.name',
                'required' => true,
            ])
            ->add('reference', Type\TextType::class, [
                'label'    => 'ekyna_core.field.reference',
                'required' => true,
            ])
            ->add('content', Type\TextareaType::class, [
                'label'    => 'ekyna_core.field.content',
                'required' => false,
                'attr'     => [
                    'class'      => 'tinymce',
                    'data-theme' => 'helper',
                ],
            ])
            ->add('enabled', Type\CheckboxType::class, [
                'label'    => 'ekyna_core.field.enabled',
                'required' => false,
            ]);
    }
}
