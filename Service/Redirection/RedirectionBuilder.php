<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Service\Redirection;

use Ekyna\Bundle\SettingBundle\Manager\RedirectionManagerInterface;
use Ekyna\Bundle\SettingBundle\Model\RedirectionInterface;
use Ekyna\Bundle\SettingBundle\Repository\RedirectionRepositoryInterface;
use Ekyna\Component\Resource\Factory\ResourceFactoryInterface;
use InvalidArgumentException;

use function array_key_exists;

/**
 * Class RedirectionBuilder
 * @package Ekyna\Bundle\SettingBundle\Service\Redirection
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class RedirectionBuilder
{
    private ResourceFactoryInterface       $factory;
    private RedirectionRepositoryInterface $repository;
    private RedirectionManagerInterface    $manager;

    public function __construct(
        ResourceFactoryInterface       $factory,
        RedirectionRepositoryInterface $repository,
        RedirectionManagerInterface    $manager
    ) {
        $this->factory = $factory;
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * Builds the redirections.
     *
     * data format : (array of array) [
     *     'from'      => `string`
     *     'to'        => `string`
     *     'permanent' => `boolean`
     * ]
     *
     * @param array $data
     */
    public function buildRedirections(array $data): void
    {
        // Data validation
        foreach ($data as $r) {
            if (!(array_key_exists('from', $r) && array_key_exists('to', $r))) {
                throw new InvalidArgumentException('Invalid redirection data.');
            }
        }

        // Removes redirections whose "from" points to "to" paths.
        $toPaths = [];
        foreach ($data as $r) {
            $toPaths[] = $r['to'];
        }
        if (!empty($toPaths)) {
            $this->manager->discardRedirections($toPaths);
        }

        // Creates or update
        foreach ($data as $r) {
            if (!(array_key_exists('from', $r) && array_key_exists('to', $r))) {
                throw new InvalidArgumentException('Invalid redirection data.');
            }
            if (!array_key_exists('permanent', $r)) {
                $r['permanent'] = true;
            }

            $redirections = $this->repository->findByFromOrTo($r['from']);

            $found = false;
            /** @var RedirectionInterface $redirection */
            foreach ($redirections as $redirection) {
                if ($redirection->getFromPath() == $r['from']) {
                    $found = true;
                }
                $redirection->setToPath($r['to']);
                // Temporary can become permanent but not the inverse
                if ($r['permanent']) {
                    $redirection->setPermanent(true);
                }

                $this->manager->persist($redirection);
            }

            if (!$found) {
                $redirection = $this->factory->create();
                $redirection
                    ->setFromPath($r['from'])
                    ->setToPath($r['to'])
                    ->setPermanent($r['permanent']);

                $this->manager->persist($redirection);
            }
        }

        $this->manager->flush();
    }

    /**
     * Discards the redirections.
     *
     * @param array $paths
     */
    public function discardRedirections(array $paths): void
    {
        $this->manager->discardRedirections($paths);
    }
}
