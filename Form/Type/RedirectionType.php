<?php

namespace Ekyna\Bundle\SettingBundle\Form\Type;

use Ekyna\Bundle\AdminBundle\Form\Type\ResourceFormType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class RedirectionType
 * @package Ekyna\Bundle\SettingBundle\Form\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class RedirectionType extends ResourceFormType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fromPath', Type\TextType::class, [
                'label' => 'ekyna_setting.redirection.field.from_path',
                'required' => true,
            ])
            ->add('toPath', Type\TextType::class, [
                'label' => 'ekyna_setting.redirection.field.to_path',
                'required' => true,
            ])
            ->add('enabled', Type\CheckboxType::class, [
                'label' => 'ekyna_core.field.enabled',
                'required' => false,
                'attr' => [
                    'align_with_widget' => true,
                ]
            ])
            ->add('permanent', Type\CheckboxType::class, [
                'label' => 'ekyna_setting.redirection.field.permanent',
                'required' => false,
                'attr' => [
                    'align_with_widget' => true,
                ]
            ])
        ;
    }
}
