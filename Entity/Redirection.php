<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Entity;

use DateTime;
use Ekyna\Bundle\SettingBundle\Model\RedirectionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

use function sprintf;
use function strlen;
use function substr;

/**
 * Class Redirection
 * @package Ekyna\Bundle\SettingBundle\Entity
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class Redirection implements RedirectionInterface
{
    private ?int      $id        = null;
    private ?string   $fromPath  = null;
    private ?string   $toPath    = null;
    private bool      $permanent = false;
    private bool      $enabled   = true;
    private int       $count     = 0;
    private ?DateTime $usedAt    = null;


    /**
     * Returns the string representation.
     *
     * @return string
     */
    public function __toString(): string
    {
        if (empty($this->fromPath) && empty($this->toPath)) {
            return 'New redirection';
        }

        $from = strlen($this->fromPath) > 16 ? '&hellip;' . substr($this->fromPath, -16) : $this->fromPath;
        $to = strlen($this->toPath) > 16 ? '&hellip;' . substr($this->toPath, -16) : $this->toPath;

        return sprintf('%s &gt; %s', $from, $to);
    }

    /**
     * @inheritDoc
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function setFromPath(string $fromPath): RedirectionInterface
    {
        $this->fromPath = $fromPath;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getFromPath(): ?string
    {
        return $this->fromPath;
    }

    /**
     * @inheritDoc
     */
    public function setToPath(string $toPath): RedirectionInterface
    {
        $this->toPath = $toPath;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getToPath(): ?string
    {
        return $this->toPath;
    }

    /**
     * @inheritDoc
     */
    public function setPermanent(bool $permanent): RedirectionInterface
    {
        $this->permanent = $permanent;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPermanent(): bool
    {
        return $this->permanent;
    }

    /**
     * @inheritDoc
     */
    public function setEnabled(bool $enabled): RedirectionInterface
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @inheritDoc
     */
    public function setCount(int $count): RedirectionInterface
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @inheritDoc
     */
    public function setUsedAt(DateTime $usedAt = null): RedirectionInterface
    {
        $this->usedAt = $usedAt;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUsedAt(): ?DateTime
    {
        return $this->usedAt;
    }

    /**
     * @inheritDoc
     */
    public function getResponse(): RedirectResponse
    {
        return new RedirectResponse($this->toPath, $this->permanent ? 301 : 302);
    }
}
