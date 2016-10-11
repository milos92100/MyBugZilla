<?php
declare(strict_types = 1);

namespace AppBundle\Repository;

use AppBundle\Repository\Exception\UserNotFoundException;
use \Doctrine\ORM\EntityRepository;
use \Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\User;
use Doctrine\ORM\Mapping\ClassMetadata;


/**
 * Class UserRepository
 *
 * @package AppBundle\Repository
 */
class UserRepository extends EntityRepository
{


    /**
     * UserRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, new ClassMetadata(User::class));
    }

    /**
     * @param int $id
     * @return null|User
     */
    public function findById(int $id)
    {
        return $this->findOneBy(array(
            "id" => $id
        ), null);
    }


    /**
     *
     * This method returns a User object for the given username and password.
     * If no User is found a UserNotFoundException exception is thrown.
     *
     * @param string $username
     * @param string $password
     * @return User|null
     * @throws UserNotFoundException
     */
    public function getByUsernameAndPassword(string $username, string $password)
    {
        $user = $this->findByUsernameAndPassword($username, $password);

        if (null === $user) {
            throw new UserNotFoundException("User for username '{$username}' and password not found");
        }

        return $user;
    }


    /**
     * This method returns a User object for the given username and password.
     * If no user is found it returns null.
     *
     * @param string $username
     * @param string $password
     * @return null|User
     */
    public function findByUsernameAndPassword(string $username, string $password)
    {
        return $this->findOneBy(array(
            "username" => $username,
            "password" => $password
        ), null);
    }
}

