<?php
declare(strict_types = 1);

namespace AppBundle\Service;

use AppBundle\Credentials\UserRegistrationCredentials;
use AppBundle\Entity\User;
use AppBundle\Entity\UserImage;
use AppBundle\Entity\UserRole;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\Exception\EmailAlreadyRegisteredException;
use AppBundle\Service\Exception\FailedToRegisterUserException;
use AppBundle\Service\Exception\UsernameNotAvailableException;


/**
 * Class UserRegistrationService , this class handles the user registration,
 * and all requirements of this action.
 *
 * @package AppBundle\Service
 */
class UserRegistrationService extends Service
{

    /**
     * $userRepository
     *
     * @var \AppBundle\Repository\UserRepository
     */
    protected $userRepository = null;

    /**
     *
     * This method creates a new user and all hes required relations with
     * other tables.First it validates and checks the input for duplicate data through the system.
     * If the registration is successful a user object will be returned,
     * if it fails a Exception is thrown with the proper message.
     *
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


        return $this->addUser($credentials);

    }

    /**
     * This method creates a new user and all hes required relations with
     * other tables.If the registration is successful a user object will be returned,
     * if it fails a Exception is thrown with the proper message.
     *
     * @param UserRegistrationCredentials $credentials
     * @return User|null
     * @throws FailedToRegisterUserException
     */
    protected function addUser(UserRegistrationCredentials $credentials)
    {
        $user = new User(
            0,
            $credentials->getUsername(),
            $credentials->getHashedPassword(),
            $credentials->getEmail(),
            $credentials->getFirstName(),
            $credentials->getLastName(),
            $credentials->getPhone(),
            $credentials->getWorkPosition(),
            $this->findRoleById(UserRole::USER)
        );

        $this->getEntityManager()->persist($user);

        $image = new UserImage(
            0,
            $user,
            $credentials->getImage()
        );

        $this->getEntityManager()->persist($image);

        $this->getEntityManager()->flush();

        $user = $this->getUserRepository()->findById($user->getId());

        if (null === $user) {
            throw new FailedToRegisterUserException("User registration failed because of some persistence issue.");
        }

        return $user;
    }


    /**
     * This method checks if the given username is available,if not
     * it returns false, otherwise true.
     *
     * @param $username string  The username to check
     * @return bool
     */
    protected function isUsernameAvailable(string $username)
    {
        return null === $this->getUserRepository()->findOneBy(array(
            "username" => $username
        ), null);

    }

    /**
     * This method checks if the given email address is already registered in  the system.
     * If the email address is in use it will return true,otherwise it returns false.
     *
     * @param $email string The email address to check
     * @return bool
     */
    protected function isEmailAlreadyRegistered(string $email)
    {
        return null !== $this->getUserRepository()->findOneBy(array(
            "email" => $email
        ), null);
    }

    /**
     * This method returns a UserRole object for the given id,
     * or NULL if not found.
     *
     * @param int $id the user role id
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
     * Returns a instance of the UserRepository class.
     *
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