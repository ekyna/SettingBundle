<?php

namespace Ekyna\Bundle\SettingBundle\Transformer;

/**
 * ParameterTransformerInterface
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 * @see https://github.com/Sylius/SyliusSettingsBundle/blob/master/Transformer/ParameterTransformerInterface.php
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
