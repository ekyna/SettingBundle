<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Transformer;

/**
 * Interface ParameterTransformerInterface
 * @package Ekyna\Bundle\SettingBundle\Transformer
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
interface ParameterTransformerInterface
{
    /**
     * Transform the parameter into format which is suitable for storage.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function transform($value);

    /**
     * Transform parameter value back into it's original form.
     *
     * @param mixed $value
     *
     * @return mixed
    */
    public function reverseTransform($value);
}
