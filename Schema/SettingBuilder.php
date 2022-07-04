<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Schema;

use Ekyna\Bundle\SettingBundle\Transformer\ParameterTransformerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SettingBuilder
 * @package Ekyna\Bundle\SettingBundle\Schema
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class SettingBuilder extends OptionsResolver
{
    /** @var array<ParameterTransformerInterface> */
    protected array $transformers = [];

    /**
     * Set transformer for given parameter.
     */
    public function setTransformer(string $parameterName, ParameterTransformerInterface $transformer): SettingBuilder
    {
        $this->transformers[$parameterName] = $transformer;

        return $this;
    }

    /**
     * Return all transformers.
     *
     * @return array<ParameterTransformerInterface>
     */
    public function getTransformers(): array
    {
        return $this->transformers;
    }
}
