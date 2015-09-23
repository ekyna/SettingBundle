<?php

namespace Ekyna\Bundle\SettingBundle\Schema;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * SchemaInterface.
 *
 * @author Étienne Dauvergne <contact@ekyna.com>
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
     * @return string
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
