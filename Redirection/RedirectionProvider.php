<?php

namespace Ekyna\Bundle\SettingBundle\Redirection;

use Ekyna\Bundle\CoreBundle\Redirection\AbstractProvider;
use Ekyna\Bundle\SettingBundle\Entity\RedirectionRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RedirectionProvider
 * @package Ekyna\Bundle\SettingBundle\Redirection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class RedirectionProvider extends AbstractProvider
{
    /**
     * @var RedirectionRepository
     */
    private $repository;


    /**
     * Constructor.
     *
     * @param RedirectionRepository $repository
     */
    public function __construct(RedirectionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function redirect(Request $request)
    {
        /** @var \Ekyna\Bundle\SettingBundle\Entity\Redirection $redirection */
        if (null !== $redirection = $this->repository->findByPath($request->getPathInfo())) {
            return $redirection->getResponse();
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_setting_redirection';
    }
}
