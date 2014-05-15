<?php

namespace Ekyna\Bundle\SettingBundle\Schema;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * AbstractSchema.
 *
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
abstract class AbstractSchema extends AbstractType implements SchemaInterface
{
    /**
     * {@inheritDoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => true,
        ));
    }
}
