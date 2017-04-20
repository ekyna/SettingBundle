<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Model;

use DateTime;
use Ekyna\Component\Resource\Model\ResourceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Interface RedirectionInterface
 * @package Ekyna\Bundle\SettingBundle\Model
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
interface RedirectionInterface extends ResourceInterface
{
    /**
     * Sets the "from path".
     *
     * @param string $fromPath
     *
     * @return RedirectionInterface|$this
     */
    public function setFromPath(string $fromPath): RedirectionInterface;

    /**
     * Returns the "from path".
     *
     * @return string|null
     */
    public function getFromPath(): ?string;

    /**
     * Sets the "to path".
     *
     * @param string $toPath
     *
     * @return RedirectionInterface|$this
     */
    public function setToPath(string $toPath): RedirectionInterface;

    /**
     * Returns the "to path".
     *
     * @return string|null
     */
    public function getToPath(): ?string;

    /**
     * Sets the permanent.
     *
     * @param bool $permanent
     *
     * @return RedirectionInterface|$this
     */
    public function setPermanent(bool $permanent): RedirectionInterface;

    /**
     * Returns the permanent.
     *
     * @return bool
     */
    public function getPermanent(): bool;

    /**
     * Sets the enabled.
     *
     * @param bool $enabled
     *
     * @return RedirectionInterface|$this
     */
    public function setEnabled(bool $enabled): RedirectionInterface;

    /**
     * Returns the enabled.
     *
     * @return bool
     */
    public function getEnabled(): bool;

    /**
     * Sets the count.
     *
     * @param int $count
     *
     * @return RedirectionInterface|$this
     */
    public function setCount(int $count): RedirectionInterface;

    /**
     * Returns the count.
     *
     * @return int
     */
    public function getCount(): int;

    /**
     * Sets the usedAt.
     *
     * @param DateTime|null $usedAt
     *
     * @return RedirectionInterface|$this
     */
    public function setUsedAt(DateTime $usedAt = null): RedirectionInterface;

    /**
     * Returns the usedAt.
     *
     * @return DateTime|null
     */
    public function getUsedAt(): ?DateTime;

    /**
     * Returns the redirect response.
     *
     * @return RedirectResponse
     */
    public function getResponse(): RedirectResponse;
}
