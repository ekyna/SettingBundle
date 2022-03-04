<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Manager;

use Ekyna\Bundle\SettingBundle\Entity\Parameter;
use Ekyna\Bundle\SettingBundle\Model\I18nParameter;
use Ekyna\Bundle\SettingBundle\Model\ParameterInterface;
use Ekyna\Bundle\SettingBundle\Model\Settings;
use Ekyna\Bundle\SettingBundle\Repository\ParameterRepositoryInterface;
use Ekyna\Bundle\SettingBundle\Schema\SchemaRegistryInterface;
use Ekyna\Bundle\SettingBundle\Schema\SettingsBuilder;
use Ekyna\Component\Resource\Locale\LocaleProviderInterface;
use Ekyna\Component\Resource\Manager\ResourceManagerInterface;
use InvalidArgumentException;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use function array_key_exists;
use function explode;
use function strpos;

/**
 * Class SettingManager
 * @package Ekyna\Bundle\SettingBundle\Manager
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class SettingManager implements SettingManagerInterface
{
    protected SchemaRegistryInterface      $registry;
    protected ResourceManagerInterface     $manager;
    protected ParameterRepositoryInterface $repository;
    protected LocaleProviderInterface      $localeProvider;
    protected ValidatorInterface           $validator;
    protected ?CacheItemPoolInterface      $cache;

    /** @var Settings[] */
    protected array $resolvedSettings = [];

    public function __construct(
        SchemaRegistryInterface      $registry,
        ResourceManagerInterface     $manager,
        ParameterRepositoryInterface $repository,
        LocaleProviderInterface      $localeProvider,
        ValidatorInterface           $validator,
        ?CacheItemPoolInterface      $cache
    ) {
        $this->registry = $registry;
        $this->manager = $manager;
        $this->repository = $repository;
        $this->localeProvider = $localeProvider;
        $this->validator = $validator;
        $this->cache = $cache;
    }

    public function saveSettings(string $namespace, Settings $settings): void
    {
        $schema = $this->registry->getSchema($namespace);

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

        $persistedParameters = $this->repository->findByNamespace($namespace);
        /** @var ParameterInterface[] $persistedParametersMap */
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

                $errors = $this->validator->validate($parameter);
                if (0 < $errors->count()) {
                    throw new ValidatorException($errors->get(0)->getMessage());
                }

                $this->manager->persist($parameter);
            }
        }

        $this->manager->flush();

        if (null === $this->cache) {
            return;
        }

        $item = $this->cache->getItem($namespace);
        $item->set($parameters);
        $this->cache->save($item);
    }

    /**
     * @inheritDoc
     */
    public function getParameter(string $name, string $locale = null)
    {
        if (false === strpos($name, '.')) {
            throw new InvalidArgumentException("Parameter must be in format 'namespace.name', '$name' given");
        }

        [$namespace, $name] = explode('.', $name);

        $settings = $this->loadSettings($namespace);

        $parameter = $settings->get($name);

        if ($parameter instanceof I18nParameter) {
            $parameter->setCurrentLocale($this->localeProvider->getCurrentLocale());
            $parameter->setFallbackLocale($this->localeProvider->getFallbackLocale());

            return $parameter->trans($locale);
        }

        return $parameter;
    }

    public function loadSettings(string $namespace): Settings
    {
        if (isset($this->resolvedSettings[$namespace])) {
            return $this->resolvedSettings[$namespace];
        }

        if ($this->cache) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $item = $this->cache->getItem($namespace);
            if ($item->isHit()) {
                $parameters = $item->get();
            } else {
                $parameters = $this->getParameters($namespace);
                $item->set($parameters);
                $this->cache->save($item);
            }
        } else {
            $parameters = $this->getParameters($namespace);
        }

        $schema = $this->registry->getSchema($namespace);

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
     * Load parameter from database.
     *
     * @return ParameterInterface[]
     */
    private function getParameters(string $namespace): array
    {
        $parameters = [];

        foreach ($this->repository->findByNamespace($namespace) as $parameter) {
            $parameters[$parameter->getName()] = $parameter->getValue();
        }

        return $parameters;
    }

    public function getLabels(): array
    {
        $labels = [];
        foreach ($this->registry->getSchemas() as $namespace => $schema) {
            $labels[$namespace] = $schema->getLabel();
        }

        return $labels;
    }

    public function getShowTemplates(): array
    {
        $templates = [];
        foreach ($this->registry->getSchemas() as $namespace => $schema) {
            $templates[$namespace] = $schema->getShowTemplate();
        }

        return $templates;
    }

    public function getFormTemplates(): array
    {
        $templates = [];
        foreach ($this->registry->getSchemas() as $namespace => $schema) {
            $templates[$namespace] = $schema->getFormTemplate();
        }

        return $templates;
    }
}
