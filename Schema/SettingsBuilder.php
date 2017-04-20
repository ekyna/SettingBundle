<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Schema;

use Ekyna\Bundle\SettingBundle\Transformer\ParameterTransformerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SettingsBuilder
 * @package Ekyna\Bundle\SettingBundle\Schema
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class SettingsBuilder extends OptionsResolver
{
    /** @var ParameterTransformerInterface[] */
    protected array $transformers = [];


    /**
     * Set transformer for given parameter.
     *
     * @param string                        $parameterName
     * @param ParameterTransformerInterface $transformer
     *
     * @return SettingsBuilder
     */
    public function setTransformer(string $parameterName, ParameterTransformerInterface $transformer): SettingsBuilder
    {
        $this->transformers[$parameterName] = $transformer;

        return $this;
    }

    /**
     * Return all transformers.
     *
     * @return ParameterTransformerInterface[]
     */
    public function getTransformers(): array
    {
        return $this->transformers;
    }
}
