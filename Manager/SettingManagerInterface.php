<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Manager;

use Ekyna\Bundle\SettingBundle\Model\Setting;
use InvalidArgumentException;
use Symfony\Contracts\Translation\TranslatableInterface;

/**
 * Interface SettingManagerInterface
 * @package Ekyna\Bundle\SettingBundle\Manager
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
interface SettingManagerInterface
{
    /**
     * Load settings from given namespace.
     */
    public function loadSettings(string $namespace): Setting;

    /**
     * Save settings under given namespace.
     */
    public function saveSettings(string $namespace, Setting $settings): void;

    /**
     * Returns settings parameter for given namespace and name.
     *
     * @throws InvalidArgumentException
     */
    public function getParameter(string $name, string $locale = null): mixed;

    /**
     * Returns namespaces labels.
     *
     * @return array<string, TranslatableInterface>
     */
    public function getLabels(): array;

    /**
     * Returns namespaces show templates.
     *
     * @return array<string>
     */
    public function getShowTemplates(): array;

    /**
     * Returns namespaces form templates.
     *
     * @return array<string>
     */
    public function getFormTemplates(): array;
}
