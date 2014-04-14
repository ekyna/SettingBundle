<?php

namespace Ekyna\Bundle\SettingBundle\Schema;

use Ekyna\Bundle\SettingBundle\Transformer\ParameterTransformerInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * SettingsBuilderInterface
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 * @see https://github.com/Sylius/SyliusSettingsBundle/blob/master/Schema/SettingsBuilderInterface.php
 */
interface SettingsBuilderInterface extends OptionsResolverInterface
{
    /**
     * Return all transformers.
     *
     * @return ParameterTransformerInterface[]
     */
    public function getTransformers();

    /**
     * Set transformer for given parameter.
     *
     * @param string                        $parameterName
     * @param ParameterTransformerInterface $transformer
     */
    public function setTransformer($parameterName, ParameterTransformerInterface $transformer);
}
