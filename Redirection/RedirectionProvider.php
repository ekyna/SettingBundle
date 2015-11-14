<?php

namespace Ekyna\Bundle\SettingBundle\Redirection;

use Doctrine\ORM\EntityManagerInterface;
use Ekyna\Bundle\CoreBundle\Redirection\AbstractProvider;
use Ekyna\Bundle\SettingBundle\Entity\RedirectionRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RedirectionProvider
 * @package Ekyna\Bundle\SettingBundle\Redirection
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class RedirectionProvider extends AbstractProvider
{
    /**
     * @var RedirectionRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $manager;


    /**
     * Constructor.
     *
     * @param RedirectionRepository  $repository
     * @param EntityManagerInterface $manager
     */
    public function __construct(RedirectionRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function redirect(Request $request)
    {
        /** @var \Ekyna\Bundle\SettingBundle\Entity\Redirection $redirection */
        if (null !== $redirection = $this->repository->findByPath($request->getPathInfo())) {
            $redirection
                ->setCount($redirection->getCount() + 1)
                ->setUsedAt(new \DateTime())
            ;
            $this->manager->persist($redirection);
            $this->manager->flush($redirection);

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
