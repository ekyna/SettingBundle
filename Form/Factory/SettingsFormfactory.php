<?php

namespace Ekyna\Bundle\SettingBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;
use Ekyna\Bundle\SettingBundle\Schema\SchemaRegistryInterface;

/**
 * SettingsFormfactory
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 * @see https://github.com/Sylius/SyliusSettingsBundle/blob/master/Form/Factory/SettingsFormFactory.php
 */
class SettingsFormfactory implements SettingsFormFactoryInterface
{
    /**
     * Schema registry
     *
     * @var SchemaRegistryInterface
     */
    protected $schemaRegistry;

    /**
     * Form factory
     *
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * Constructor
     *
     * @param SchemaRegistryInterface $schemaRegistry
     * @param FormFactoryInterface    $formFactory
     */
    public function __construct(SchemaRegistryInterface $schemaRegistry, FormFactoryInterface $formFactory)
    {
        $this->schemaRegistry = $schemaRegistry;
        $this->formFactory = $formFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function create($namespace)
    {
        $schema = $this->schemaRegistry->getSchema($namespace);
        $builder = $this->formFactory->createBuilder('form', null, array('data_class' => null));

        $schema->buildForm($builder);

        return $builder->getForm();
    }
}
