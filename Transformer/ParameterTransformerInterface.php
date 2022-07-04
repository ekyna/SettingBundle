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
     */
    public function transform(mixed $value): mixed;

    /**
     * Transform parameter value back into it's original form.
    */
    public function reverseTransform(mixed $value): mixed;
}
