<?php
declare(strict_types = 1);

namespace AppBundle\Repository;

use AppBundle\Repository\Exception\UserNotFoundException;
use Doctrine\Common\Collections\Criteria;
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
     * @param int $id
     * @return User|null
     * @throws UserNotFoundException
     */
    public function getById(int $id)
    {
        $user = $this->findById($id);

        if (null === $user) {
            throw new UserNotFoundException("User({$id}) not found");
        }

        return $user;
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
     * @param $str
     * @return \Doctrine\Common\Collections\Collection
     */
    public function findBestMathByUsernameOrNameOrSurname($str)
    {

        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->contains("username", $str))
            ->orWhere(Criteria::expr()->contains("firstName", $str))
            ->orWhere(Criteria::expr()->contains("lastName", $str));


        return $this->matching($criteria);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function deactivate(int $id)
    {
        return $this->setStatus(User::INACTIVE, $id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function activate(int $id)
    {
        return $this->setStatus(User::ACTIVE, $id);
    }

    /**
     * @param int $active
     * @param int $id
     * @return mixed
     */
    protected function setStatus(int $active, int $id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $q = $qb->update(User::class, 'u')
            ->set('u.active', '?active')
            ->where('u.id = ?id')
            ->setParameter("active", $active)
            ->setParameter("id", $id)
            ->getQuery();
        return $q->execute();
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

