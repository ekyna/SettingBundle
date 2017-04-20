<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Schema;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Contracts\Translation\TranslatableInterface;

/**
 * Interface SchemaInterface
 * @package Ekyna\Bundle\SettingBundle\Schema
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
interface SchemaInterface
{
    /**
     * Build settings.
     *
     * @param SettingsBuilder $builder
     */
    public function buildSettings(SettingsBuilder $builder): void;

    /**
     * Build form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options);

    /**
     * Returns the label.
     *
     * Can be a string or an array : (['label', 'trans domain']).
     *
     * @return string|array
     */
    public function getLabel(): TranslatableInterface;

    /**
     * Returns the show template.
     *
     * @return string
     */
    public function getShowTemplate(): string;

    /**
     * Returns the form template.
     *
     * @return string
     */
    public function getFormTemplate(): string;
}
