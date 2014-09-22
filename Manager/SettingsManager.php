<?php

namespace Ekyna\Bundle\SettingBundle\Manager;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Ekyna\Bundle\SettingBundle\Model\Settings;
use Ekyna\Bundle\SettingBundle\Schema\SchemaRegistryInterface;
use Ekyna\Bundle\SettingBundle\Schema\SettingsBuilder;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\ValidatorInterface;
use Ekyna\Bundle\SettingBundle\Entity\Parameter;

/**
 * SettingsManager.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 * @see https://github.com/Sylius/SyliusSettingsBundle/blob/master/Manager/SettingsManager.php
 */
class SettingsManager implements SettingsManagerInterface
{
    /**
     * Schema registry
     *
     * @var SchemaRegistryInterface
     */
    protected $schemaRegistry;

    /**
     * Object manager
     *
     * @var ObjectManager
     */
    protected $parameterManager;

    /**
     * Parameter object repository
     *
     * @var ObjectRepository
     */
    protected $parameterRepository;

    /**
     * Cache
     *
     * @var Cache
     */
    protected $cache;

    /**
     * Runtime cache for resolved parameters
     *
     * @var array
     */
    protected $resolvedSettings = array();

    /**
     * Validator instance
     *
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * Constructor
     *
     * @param SchemaRegistryInterface $schemaRegistry
     * @param ObjectManager           $parameterManager
     * @param ObjectRepository        $parameterRepository
     * @param Cache                   $cache
     * @param ValidatorInterface      $validator
     */
    public function __construct(
        SchemaRegistryInterface $schemaRegistry, 
        ObjectManager $parameterManager, 
        ObjectRepository $parameterRepository, 
        Cache $cache, 
        ValidatorInterface $validator
    ) {
        $this->schemaRegistry = $schemaRegistry;
        $this->parameterManager = $parameterManager;
        $this->parameterRepository = $parameterRepository;
        $this->cache = $cache;
        $this->validator = $validator;
    }

    /**
     * {@inheritDoc}
     */
    public function loadSettings($namespace)
    {
        if (isset($this->resolvedSettings[$namespace])) {
            return $this->resolvedSettings[$namespace];
        }

        if ($this->cache->contains($namespace)) {
            $parameters = $this->cache->fetch($namespace);
        } else {
            $parameters = $this->getParameters($namespace);
        }

        $schema = $this->schemaRegistry->getSchema($namespace);

        $settingsBuilder = new SettingsBuilder();
        $schema->buildSettings($settingsBuilder);

        foreach ($settingsBuilder->getTransformers() as $parameter => $transformer) {
            if (array_key_exists($parameter, $parameters)) {
                $parameters[$parameter] = $transformer->reverseTransform($parameters[$parameter]);
            }
        }

        $parameters = $settingsBuilder->resolve($parameters);

        return $this->resolvedSettings[$namespace] = new Settings($parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function saveSettings($namespace, Settings $settings)
    {
        $schema = $this->schemaRegistry->getSchema($namespace);

        $settingsBuilder = new SettingsBuilder();
        $schema->buildSettings($settingsBuilder);

        $parameters = $settingsBuilder->resolve($settings->getParameters());

        foreach ($settingsBuilder->getTransformers() as $parameter => $transformer) {
            if (array_key_exists($parameter, $parameters)) {
                $parameters[$parameter] = $transformer->transform($parameters[$parameter]);
            }
        }

        if (isset($this->resolvedSettings[$namespace])) {
            $this->resolvedSettings[$namespace]->setParameters($parameters);
        }

        /** @var $persistedParameters */
        $persistedParameters = $this->parameterRepository->findBy(array('namespace' => $namespace));
        $persistedParametersMap = array();

        foreach ($persistedParameters as $parameter) {
            $persistedParametersMap[$parameter->getName()] = $parameter;
        }

        foreach ($parameters as $name => $value) {
            if (isset($persistedParametersMap[$name])) {
                $persistedParametersMap[$name]->setValue($value);
            } else {
                $parameter = new Parameter();

                $parameter
                    ->setNamespace($namespace)
                    ->setName($name)
                    ->setValue($value)
                ;

                /* @var \Symfony\Component\Validator\ConstraintViolationListInterface $errors */
                $errors = $this->validator->validate($parameter);
                if (0 < $errors->count()) {
                    throw new ValidatorException($errors->get(0)->getMessage());
                }

                $this->parameterManager->persist($parameter);
            }
        }

        $this->parameterManager->flush();

        $this->cache->save($namespace, $parameters);
    }

    /**
     * {@inheritDoc}
     */
    public function getParameter($name)
    {
        if (false === strpos($name, '.')) {
            throw new \InvalidArgumentException(sprintf('Parameter must be in format "namespace.name", "%s" given', $name));
        }
    
        list($namespace, $name) = explode('.', $name);
    
        $settings = $this->loadSettings($namespace);
    
        return $settings->get($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getLabels()
    {
        $labels = array();
        foreach ($this->schemaRegistry->getSchemas() as $namespace => $schema) {
            $labels[$namespace] = $schema->getLabel();
        }
        return $labels;
    }

    /**
     * {@inheritDoc}
     */
    public function getShowTemplates()
    {
        $templates = array();
        foreach ($this->schemaRegistry->getSchemas() as $namespace => $schema) {
            $templates[$namespace] = $schema->getShowTemplate();
        }
        return $templates;
    }

    /**
     * {@inheritDoc}
     */
    public function getFormTemplates()
    {
        $templates = array();
        foreach ($this->schemaRegistry->getSchemas() as $namespace => $schema) {
            $templates[$namespace] = $schema->getFormTemplate();
        }
        return $templates;
    }

    /**
     * Load parameter from database.
     *
     * @param string $namespace
     *
     * @return array
     */
    private function getParameters($namespace)
    {
        $parameters = array();

        foreach ($this->parameterRepository->findBy(array('namespace' => $namespace)) as $parameter) {
            $parameters[$parameter->getName()] = $parameter->getValue();
        }

        return $parameters;
    }
}
