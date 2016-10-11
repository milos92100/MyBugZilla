<?php
declare(strict_types = 1);

namespace AppBundle\Service\Response;

use AppBundle\Entity\User;


/**
 * Class AuthenticationResponse
 *
 * @package AppBundle\Service\Response
 */
class AuthenticationResponse implements \JsonSerializable
{

    const ACCESS_GRANTED = true;

    const ACCESS_DENIED = false;

    /**
     * $accessGranted
     *
     * @var bool
     */
    private $accessGranted;

    /**
     * $message
     *
     * @var string
     */
    private $message;


    /**
     * @var User
     */
    private $authenticatedUser;

    /**
     * AuthenticationResponse constructor.
     *
     * @param bool   $accessGranted
     * @param string $message
     * @param User   $authenticatedUser
     */
    public function __construct(bool $accessGranted, string $message, User $authenticatedUser = null)
    {
        $this->accessGranted = $accessGranted;
        $this->message = $message;
        $this->authenticatedUser = $authenticatedUser;

    }

    /**
     * @return boolean
     */
    public function isAccessGranted(): bool
    {
        return $this->accessGranted;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return User
     */
    public function getAuthenticatedUser(): User
    {
        return $this->authenticatedUser;
    }


    /**
     * Specify data which should be serialized to JSON
     *
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *        which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize() : array
    {
        return array(
            "accessGranted" => $this->isAccessGranted(),
            "message" => $this->getMessage()
        );
    }
}