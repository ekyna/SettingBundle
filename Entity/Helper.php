<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Entity;

use DateTime;
use Ekyna\Component\Resource\Model as RM;

/**
 * Class Helper
 * @package Ekyna\Bundle\SettingBundle\Entity
 * @author  Étienne Dauvergne <contact@ekyna.com>
 *
 * @TODO    translatable
 */
class Helper implements RM\TaggedEntityInterface
{
    use RM\TaggedEntityTrait;

    private ?int        $id        = null;
    private ?string     $name      = null;
    private ?string     $reference = null;
    private ?string     $content   = null;
    private bool        $enabled   = false;
    protected ?DateTime $updatedAt = null;


    /**
     * Returns the string representation.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->name ?: 'New helper';
    }

    /**
     * @inheritDoc
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Sets the name.
     *
     * @param string $name
     *
     * @return Helper
     */
    public function setName(string $name): Helper
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets the reference.
     *
     * @param string $reference
     *
     * @return Helper
     */
    public function setReference(string $reference): Helper
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Returns the reference.
     *
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * Sets the content.
     *
     * @param string $content
     *
     * @return Helper
     */
    public function setContent(string $content): Helper
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Returns the content.
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Sets whether it is enabled or not.
     *
     * @param bool $enabled
     *
     * @return Helper
     */
    public function setEnabled(bool $enabled): Helper
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Returns whether it is enabled or not.
     *
     * @return bool
     */
    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Returns the 'updated at' date.
     *
     * @return DateTime
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Sets the 'updated at' date.
     *
     * @param DateTime|null $updatedAt
     *
     * @return Helper
     */
    public function setUpdatedAt(DateTime $updatedAt = null): Helper
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public static function getEntityTagPrefix(): string
    {
        return 'ekyna_setting.helper';
    }
}
