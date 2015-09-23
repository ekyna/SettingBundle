<?php

namespace Ekyna\Bundle\SettingBundle\Form\Type;

use Ekyna\Bundle\AdminBundle\Form\Type\ResourceFormType;
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
            ->add('fromPath', 'text', [
                'label' => 'ekyna_setting.redirection.field.from_path',
                'required' => true,
            ])
            ->add('toPath', 'text', [
                'label' => 'ekyna_setting.redirection.field.to_path',
                'required' => true,
            ])
            ->add('enabled', 'checkbox', [
                'label' => 'ekyna_core.field.enabled',
                'required' => false,
                'attr' => [
                    'align_with_widget' => true,
                ]
            ])
            ->add('permanent', 'checkbox', [
                'label' => 'ekyna_setting.redirection.field.permanent',
                'required' => false,
                'attr' => [
                    'align_with_widget' => true,
                ]
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
