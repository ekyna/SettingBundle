<?php

namespace Ekyna\Bundle\SettingBundle\Schema;

use Ekyna\Bundle\SettingBundle\Transformer\ParameterTransformerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * SettingsBuilder
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 * @see https://github.com/Sylius/SyliusSettingsBundle/blob/master/Schema/SettingsBuilder.php
 */
class SettingsBuilder extends OptionsResolver
{
    /**
     * Transformers array.
     *
     * @var ParameterTransformerInterface[]
     */
    protected $transformers = [];


    /**
     * Set transformer for given parameter.
     *
     * @param string                        $parameterName
     * @param ParameterTransformerInterface $transformer
     * @return SettingsBuilder
     */
    public function setTransformer($parameterName, ParameterTransformerInterface $transformer)
    {
        $this->transformers[$parameterName] = $transformer;

        return $this;
    }

    /**
     * Return all transformers.
     *
     * @return ParameterTransformerInterface[]
     */
    public function getTransformers()
    {
        return $this->transformers;
    }
}
