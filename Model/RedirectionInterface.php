<?php

namespace Ekyna\Bundle\SettingBundle\Model;

use Ekyna\Component\Resource\Model\ResourceInterface;

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
    public function setFromPath($fromPath);

    /**
     * Returns the "from path".
     *
     * @return string
     */
    public function getFromPath();

    /**
     * Sets the "to path".
     *
     * @param string $toPath
     *
     * @return RedirectionInterface|$this
     */
    public function setToPath($toPath);

    /**
     * Returns the "to path".
     *
     * @return string
     */
    public function getToPath();

    /**
     * Sets the permanent.
     *
     * @param boolean $permanent
     *
     * @return RedirectionInterface|$this
     */
    public function setPermanent($permanent);

    /**
     * Returns the permanent.
     *
     * @return boolean
     */
    public function getPermanent();

    /**
     * Sets the enabled.
     *
     * @param boolean $enabled
     *
     * @return RedirectionInterface|$this
     */
    public function setEnabled($enabled);

    /**
     * Returns the enabled.
     *
     * @return boolean
     */
    public function getEnabled();

    /**
     * Sets the count.
     *
     * @param int $count
     *
     * @return RedirectionInterface|$this
     */
    public function setCount($count);

    /**
     * Returns the count.
     *
     * @return int
     */
    public function getCount();

    /**
     * Sets the usedAt.
     *
     * @param \DateTime $usedAt
     *
     * @return RedirectionInterface|$this
     */
    public function setUsedAt(\DateTime $usedAt = null);

    /**
     * Returns the usedAt.
     *
     * @return \DateTime
     */
    public function getUsedAt();

    /**
     * Returns the redirect response.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getResponse();
}
