<?php

namespace AppBundle\Service;

use AppBundle\Credentials\AuthenticationCredentials;
use AppBundle\Repository\Exception\UserNotFoundException;
use AppBundle\Service\Exception\AccessDeniedException;
use AppBundle\Service\Response\AuthenticationResponse;
use AppBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\User;


/**
 * Class AuthenticationService
 *
 * @package AppBundle\Service
 */
class AuthenticationService extends Service
{

    /**
     * @var UserRepository
     */
    protected $userRepository = null;

    /**
     * @param AuthenticationCredentials $credentials
     * @return AuthenticationResponse
     */
    public function authenticate(AuthenticationCredentials $credentials)
    {
        $authResponse = null;


        try {

            $this->killSession();

            $user = $this->getUserRepository()->getByUsernameAndPassword($credentials->getUsername(), $credentials->getHashedPassword());


            if (!$user->isActive()) {
                throw new AccessDeniedException("User {$user->getUsername()} is not ACTIVE.");
            }

            $authResponse = new AuthenticationResponse(
                AuthenticationResponse::ACCESS_GRANTED,
                "Access granted.Welcome {$user->getFirstName()} {$user->getLastName()}",
                $user
            );

            $this->startSessionForUser($user);


        } catch (AccessDeniedException | UserNotFoundException $exception) {
            $authResponse = new AuthenticationResponse(AuthenticationResponse::ACCESS_DENIED, $exception->getMessage());
        }

        return $authResponse;
    }

    protected function startSessionForUser(User $user)
    {
        $session = new Session();
        $session->set("user", $user);

        $session->start();

    }

    protected function killSession()
    {
        $session = new Session();
        if ($session->isStarted()) {
            $session->clear();

        }
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