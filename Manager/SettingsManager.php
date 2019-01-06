<?php

namespace Ekyna\Bundle\SettingBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Ekyna\Bundle\CoreBundle\Cache\TagManager;
use Ekyna\Bundle\SettingBundle\Entity\Parameter;
use Ekyna\Bundle\SettingBundle\Model\Settings;
use Ekyna\Bundle\SettingBundle\Schema\SchemaRegistryInterface;
use Ekyna\Bundle\SettingBundle\Schema\SettingsBuilder;
use Ekyna\Component\Resource\Doctrine\ORM\ResourceRepository;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * SettingsManager.
 *
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class SettingsManager implements SettingsManagerInterface
{
    const HTTP_CACHE_TAG = 'ekyna_settings';

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
     * @var ResourceRepository
     */
    protected $parameterRepository;

    /**
     * Cache
     *
     * @var AdapterInterface
     */
    protected $cache;

    /**
     * Http cache tag manager
     *
     * @var TagManager
     */
    protected $tagManager;

    /**
     * Runtime cache for resolved parameters
     *
     * @var array|Settings[]
     */
    protected $resolvedSettings = [];

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
     * @param ResourceRepository      $parameterRepository
     * @param TagManager              $tagManager
     * @param ValidatorInterface      $validator
     * @param AdapterInterface        $cache
     */
    public function __construct(
        SchemaRegistryInterface $schemaRegistry,
        ObjectManager $parameterManager,
        ResourceRepository $parameterRepository,
        TagManager $tagManager,
        ValidatorInterface $validator,
        AdapterInterface $cache
    ) {
        $this->schemaRegistry = $schemaRegistry;
        $this->parameterManager = $parameterManager;
        $this->parameterRepository = $parameterRepository;
        $this->tagManager = $tagManager;
        $this->validator = $validator;
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     */
    public function loadSettings($namespace)
    {
        $this->tagManager->addTags(self::HTTP_CACHE_TAG . '.' . $namespace);

        if (isset($this->resolvedSettings[$namespace])) {
            return $this->resolvedSettings[$namespace];
        }

        if ($this->cache) {
            $item = $this->cache->getItem($namespace);
            if ($item->isHit()) {
                $parameters = $item->get();
            } else {
                $parameters = $this->getParameters($namespace);
                $item = $this->cache->getItem($namespace);
                $item->set($parameters);
                $this->cache->save($item);
            }
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

        /** @var Parameter[] $persistedParameters */
        $persistedParameters = $this->parameterRepository->findBy(['namespace' => $namespace]);
        /** @var Parameter[] $persistedParametersMap */
        $persistedParametersMap = [];

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
                    ->setValue($value);

                /* @var \Symfony\Component\Validator\ConstraintViolationListInterface $errors */
                $errors = $this->validator->validate($parameter);
                if (0 < $errors->count()) {
                    throw new ValidatorException($errors->get(0)->getMessage());
                }

                $this->parameterManager->persist($parameter);
            }
        }

        $this->parameterManager->flush();

        if ($this->cache) {
            $item = $this->cache->getItem($namespace);
            $item->set($parameters);
            $this->cache->save($item);
        }

        $this->tagManager->invalidateTags(self::HTTP_CACHE_TAG . '.' . $namespace);
    }

    /**
     * {@inheritDoc}
     */
    public function getParameter($name)
    {
        if (false === strpos($name, '.')) {
            throw new \InvalidArgumentException(sprintf('Parameter must be in format "namespace.name", "%s" given',
                $name));
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
        $labels = [];
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
        $templates = [];
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
        $templates = [];
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
        $parameters = [];

        /** @var Parameter $parameter */
        foreach ($this->parameterRepository->findBy(['namespace' => $namespace]) as $parameter) {
            $parameters[$parameter->getName()] = $parameter->getValue();
        }

        return $parameters;
    }
}
