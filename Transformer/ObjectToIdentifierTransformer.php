<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Transformer;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Ekyna\Bundle\CoreBundle\Form\DataTransformer\ObjectToIdentifierTransformer as BaseTransformer;

/**
 * Class ObjectToIdentifierTransformer
 * @package Ekyna\Bundle\SettingBundle\Transformer
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class ObjectToIdentifierTransformer extends BaseTransformer implements ParameterTransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transform($value)
    {
        if (!is_object($value)) {
            return null;
        }

        $accessor = PropertyAccess::createPropertyAccessor();

        return $accessor->getValue($value, $this->identifier);
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($value)
    {
        if (empty($value)) {
            return null;
        }

        return $this->repository->findOneBy([$this->identifier => $value]);
    }
}
