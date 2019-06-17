<?php

namespace Ekyna\Bundle\SettingBundle\Schema;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * Interface SchemaInterface
 * @package Ekyna\Bundle\SettingBundle\Schema
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
interface SchemaInterface
{
    /**
     * Build settings.
     *
     * @param SettingsBuilder $builder
     */
    public function buildSettings(SettingsBuilder $builder);

    /**
     * Build form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options);

    /**
     * Returns the label.
     *
     * Can be a string or an array : ([<label>, <trans domain>]).
     * 
     * @return string|array
     */
    public function getLabel();

    /**
     * Returns the show template.
     * 
     * @return string
     */
    public function getShowTemplate();

    /**
     * Returns the form template.
     * 
     * @return string
     */
    public function getFormTemplate();
}
