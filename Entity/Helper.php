<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Entity;

use DateTime;
use DateTimeInterface;
use Ekyna\Bundle\SettingBundle\Model\HelperInterface;
use Ekyna\Component\Resource\Model\AbstractResource;
use Ekyna\Component\Resource\Model\TaggedEntityTrait;

/**
 * Class Helper
 * @package Ekyna\Bundle\SettingBundle\Entity
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class Helper extends AbstractResource implements HelperInterface
{
    use TaggedEntityTrait;

    private ?string     $name      = null;
    private ?string     $reference = null;
    private ?string     $content   = null;
    private bool        $enabled   = false;
    protected ?DateTime $updatedAt = null;


    /**
     * Returns the string representation.
     */
    public function __toString(): string
    {
        return $this->name ?: 'New helper';
    }

    public function setName(string $name): HelperInterface
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setReference(string $reference): HelperInterface
    {
        $this->reference = $reference;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setContent(string $content): HelperInterface
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setEnabled(bool $enabled): HelperInterface
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): HelperInterface
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public static function getEntityTagPrefix(): string
    {
        return 'ekyna_setting.helper';
    }
}
