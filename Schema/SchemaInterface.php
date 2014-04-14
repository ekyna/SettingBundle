<?php

namespace Ekyna\Bundle\SettingBundle\Schema;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * SchemaInterface
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 * @see https://github.com/Sylius/SyliusSettingsBundle/blob/master/Schema/SchemaInterface.php
 */
interface SchemaInterface
{
    /**
     * Build settings.
     *
     * @param SettingsBuilderInterface $builder
     */
    public function buildSettings(SettingsBuilderInterface $builder);
    
    /**
     * Build form.
     *
     * @param FormBuilderInterface $builder
    */
    public function buildForm(FormBuilderInterface $builder);
}
