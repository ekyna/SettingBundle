<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Service\Redirection;

use DateTime;
use Ekyna\Bundle\ResourceBundle\Service\Redirection\AbstractProvider;
use Ekyna\Bundle\SettingBundle\Manager\RedirectionManagerInterface;
use Ekyna\Bundle\SettingBundle\Repository\RedirectionRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RedirectionProvider
 * @package Ekyna\Bundle\SettingBundle\Service\Redirection
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class RedirectionProvider extends AbstractProvider
{
    private RedirectionRepositoryInterface $repository;
    private RedirectionManagerInterface    $manager;


    /**
     * Constructor.
     *
     * @param RedirectionRepositoryInterface $repository
     * @param RedirectionManagerInterface    $manager
     */
    public function __construct(RedirectionRepositoryInterface $repository, RedirectionManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @inheritDoc
     */
    public function redirect(Request $request)
    {
        // TODO Not from admin or api sections

        if ($redirection = $this->repository->findOneByFrom($request->getPathInfo())) {
            $redirection
                ->setCount($redirection->getCount() + 1)
                ->setUsedAt(new DateTime());

            $this->manager->persist($redirection);
            $this->manager->flush();

            return $redirection->getResponse();
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'ekyna_setting_redirection';
    }
}
