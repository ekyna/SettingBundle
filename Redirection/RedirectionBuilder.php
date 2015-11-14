<?php

namespace Ekyna\Bundle\SettingBundle\Redirection;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class RedirectionBuilder
 * @package Ekyna\Bundle\SettingBundle\Redirection
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class RedirectionBuilder
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var string
     */
    private $redirectionClass;


    /**
     * Constructor.
     *
     * @param EntityManagerInterface $em
     * @param string                 $redirectionClass
     */
    public function __construct(EntityManagerInterface $em, $redirectionClass)
    {
        $this->em = $em;
        $this->redirectionClass = $redirectionClass;
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
    public function buildRedirections(array $data)
    {
        // Data validation
        foreach ($data as $r) {
            if (!(array_key_exists('from', $r) && array_key_exists('to', $r))) {
                throw new \InvalidArgumentException('Invalid redirection data.');
            }
        }

        // Removes redirections whose "from" points to "to" paths.
        $toPaths = [];
        foreach ($data as $r) {
            $toPaths[] = $r['to'];
        }
        if (!empty($toPaths)) {
            $this->discardRedirections($toPaths);
        }

        // Creates or update
        foreach ($data as $r) {
            if (!(array_key_exists('from', $r) && array_key_exists('to', $r))) {
                throw new \InvalidArgumentException('Invalid redirection data.');
            }
            if (!array_key_exists('permanent', $r)) {
                $r['permanent'] = true;
            }

            $qb = $this->em->createQueryBuilder();

            $redirections = $qb
                ->from($this->redirectionClass, 'r')
                ->select('r')
                ->andWhere($qb->expr()->orX(
                    $qb->expr()->eq('r.fromPath', ':from'),
                    $qb->expr()->eq('r.toPath', ':from')
                ))
                ->getQuery()
                ->setParameter('from', $r['from'])
                ->getResult();

            $found = false;
            /** @var \Ekyna\Bundle\SettingBundle\Model\RedirectionInterface $redirection */
            foreach ($redirections as $redirection) {
                if ($redirection->getFromPath() == $r['from']) {
                    $found = true;
                }
                $redirection->setToPath($r['to']);
                // Temporary can become permanent but not the inverse
                if ($r['permanent']) {
                    $redirection->setPermanent(true);
                }

                $this->em->persist($redirection);
            }

            if (!$found) {
                $redirection = new $this->redirectionClass;
                $redirection
                    ->setFromPath($r['from'])
                    ->setToPath($r['to'])
                    ->setPermanent($r['permanent']);

                $this->em->persist($redirection);
            }
        }

        $this->em->flush();
    }

    /**
     * Discards the redirections.
     *
     * @param array $paths
     */
    public function discardRedirections(array $paths)
    {
        $qb = $this->em->createQueryBuilder();
        $qb
            ->delete($this->redirectionClass, 'r')
            ->where($qb->expr()->in('r.fromPath', ':paths'))
            ->getQuery()
            ->setParameter('paths', $paths)
            ->execute();
    }
}
