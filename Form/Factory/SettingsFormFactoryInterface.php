<?php

namespace Ekyna\Bundle\SettingBundle\Form\Factory;

/**
 * SettingsFormFactoryInterface
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 * @see https://github.com/Sylius/SyliusSettingsBundle/blob/master/Form/Factory/SettingsFormFactoryInterface.php
 */
interface SettingsFormFactoryInterface
{
    /**
     * Create the form for given schema
     *
     * @param string $namespace
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function create($namespace);
}
