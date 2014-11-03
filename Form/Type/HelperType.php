<?php

namespace Ekyna\Bundle\SettingBundle\Form\Type;

use Ekyna\Bundle\AdminBundle\Form\Type\ResourceFormType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class HelperType
 * @package Ekyna\Bundle\SettingBundle\Form\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class HelperType extends ResourceFormType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options = array())
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'ekyna_core.field.name',
                'required' => true,
            ))
            ->add('reference', 'text', array(
                'label' => 'ekyna_core.field.reference',
                'required' => true,
            ))
            ->add('content', 'textarea', array(
                'label' => 'ekyna_core.field.content',
                'required' => false,
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'helper',
                )
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'ekyna_core.field.enabled',
                'required' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_setting_helper';
    }
}
