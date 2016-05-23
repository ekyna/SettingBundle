<?php

namespace Ekyna\Bundle\SettingBundle\Schema;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * AbstractSchema.
 *
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
abstract class AbstractSchema extends AbstractType implements SchemaInterface
{
    /**
     * @var array
     */
    protected $defaults;

    /**
     * @param array $defaults
     */
    public function __construct(array $defaults = [])
    {
        $this->defaults = $defaults;
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'constraints' => [new Valid()],
        ]);
    }
}
