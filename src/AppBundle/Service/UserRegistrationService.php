<?php
declare(strict_types = 1);

namespace AppBundle\Service;

use AppBundle\Credentials\UserRegistrationCredentials;
use AppBundle\Entity\User;
use AppBundle\Entity\UserRole;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\Exception\EmailAlreadyRegisteredException;
use AppBundle\Service\Exception\FailedToRegisterUserException;
use AppBundle\Service\Exception\UsernameNotAvailableException;


/**
 * Class UserRegistrationService
 *
 * @package AppBundle\Service
 */
class UserRegistrationService extends Service
{

    protected $userRepository = null;

    /**
     * @param UserRegistrationCredentials $credentials
     * @return User
     * @throws EmailAlreadyRegisteredException
     * @throws UsernameNotAvailableException
     * @throws FailedToRegisterUserException
     */
    public function registerNewUser(UserRegistrationCredentials $credentials)
    {

        if (!$this->isUsernameAvailable($credentials->getUsername())) {
            throw new UsernameNotAvailableException("The entered username '{$credentials->getUsername()}' is already token.");
        }

        if ($this->isEmailAlreadyRegistered($credentials->getEmail())) {
            throw new EmailAlreadyRegisteredException("The entered email '{$credentials->getEmail()}' is already token.");
        }

        $user = new User(
            0,
            $credentials->getUsername(),
            $credentials->getHashedPassword(),
            $credentials->getEmail(),
            $credentials->getFirstName(),
            $credentials->getLastName(),
            $this->findRoleById(UserRole::USER)
        );

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        $user = $this->getUserRepository()->findById($user->getId());

        if (null === $user) {
            throw new FailedToRegisterUserException("User registration failed because of some persistence issue.");
        }

        return $user;

    }


    /**
     * @param $username
     * @return bool
     */
    protected function isUsernameAvailable($username)
    {
        return null === $this->getUserRepository()->findOneBy(array(
            "username" => $username
        ), null);

    }

    /**
     * @param $email
     * @return bool
     */
    protected function isEmailAlreadyRegistered($email)
    {
        return null !== $this->getUserRepository()->findOneBy(array(
            "email" => $email
        ), null);
    }

    /**
     * @param int $id
     * @return UserRole|object
     */
    protected function findRoleById(int $id)
    {
        return $this->getEntityManager()->getRepository(
            UserRole::class)->findOneBy(
            array("id" => $id),
            null
        );
    }

    /**
     * @return UserRepository|null
     */
    protected function getUserRepository()
    {
        if (null === $this->userRepository) {
            $this->userRepository = new UserRepository($this->getEntityManager());
        }
        return $this->userRepository;
    }


}