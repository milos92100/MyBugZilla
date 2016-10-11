<?php
declare(strict_types = 1);

namespace AppBundle\Credentials;
use AppBundle\Entity\User;


/**
 * Class AuthenticationCredentials
 *
 * @package AppBundle\Credentials
 */
class AuthenticationCredentials
{


    /**
     * $username
     *
     * @var string
     */
    private $username;

    /**
     * $password
     *
     * @var string
     */
    private $password;

    /**
     * AuthenticationCredentials constructor.
     *
     * @param $username string
     * @param $password $username
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getHashedPassword()
    {
        return hash(User::PASSWORD_HASH_ALGORITHM, $this->password);
    }

    /**
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }

}