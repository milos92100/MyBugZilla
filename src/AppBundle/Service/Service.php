<?php


namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Service
 *
 * @package AppBundle\Service
 */
abstract class Service
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Service constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

}