<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Model;

use DateTimeInterface;
use Ekyna\Component\Resource\Model\TaggedEntityInterface;

/**
 * Interface HelperInterface
 * @package Ekyna\Bundle\SettingBundle\Model
 * @author  Étienne Dauvergne <contact@ekyna.com>
 *
 * @TODO    translatable
 */
interface HelperInterface extends TaggedEntityInterface
{
    /**
     * Sets the name.
     */
    public function setName(string $name): HelperInterface;

    /**
     * Returns the name.
     */
    public function getName(): ?string;

    /**
     * Sets the reference.
     */
    public function setReference(string $reference): HelperInterface;

    /**
     * Returns the reference.
     */
    public function getReference(): ?string;

    /**
     * Sets the content.
     */
    public function setContent(string $content): HelperInterface;

    /**
     * Returns the content.
     */
    public function getContent(): ?string;

    /**
     * Sets whether it is enabled or not.
     */
    public function setEnabled(bool $enabled): HelperInterface;

    /**
     * Returns whether it is enabled or not.
     */
    public function getEnabled(): bool;

    /**
     * Returns the 'updated at' date.
     */
    public function getUpdatedAt(): ?DateTimeInterface;

    /**
     * Sets the 'updated at' date.
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt): HelperInterface;
}
