<?php
declare(strict_types = 1);

namespace AppBundle\Entity;


/**
 * Class User
 *
 * @package AppBundle\Entity
 */
class User implements \JsonSerializable
{

    const PASSWORD_HASH_ALGORITHM = "sha512";

    const ACTIVE = 1;
    const INACTIVE = 0;

    /**
     * $id
     *
     * @var int
     */
    private $id;

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
     * $email
     *
     * @var string
     */
    private $email;

    /**
     * $firstName
     *
     * @var string
     */
    private $firstName;

    /**
     *
     * $lastName
     *
     * @var string
     */
    private $lastName;

    /**
     * $phone
     *
     * @var string
     */
    private $phone;

    /**
     *
     * $workPosition
     *
     * @var string
     */
    private $workPosition;

    /**
     *
     * $image
     *
     * @var UserImage
     */
    private $image;

    /**
     * $active
     *
     * @var int
     */
    private $active;

    /**
     * $role
     *
     * @var UserRole
     */
    private $role;


    /**
     * $lastUpdated
     *
     * @var \DateTime
     */
    private $lastUpdated;

    /**
     * $timestamp
     *
     * @var \DateTime
     */
    private $timestamp;


    /**
     * $base64ImageContent
     *
     * @var string
     */
    public $base64ImageContent = null;

    /**
     * User constructor.
     *
     * @param int       $id
     * @param string    $username
     * @param string    $password
     * @param string    $email
     * @param string    $firstName
     * @param string    $lastName
     * @param string    $phone
     * @param string    $workPosition
     * @param UserRole  $role
     * @param \DateTime $lastUpdated
     * @param \DateTime $timestamp
     */
    public function __construct(
        int $id,
        string $username,
        string $password,
        string $email,
        string $firstName,
        string $lastName,
        string $phone,
        string $workPosition,
        UserRole $role,
        \DateTime $lastUpdated = null,
        \DateTime $timestamp = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->workPosition = $workPosition;
        $this->role = $role;
        $this->active = self::ACTIVE;

        if (null === $lastUpdated) {
            $lastUpdated = new \DateTime();
        }

        $this->lastUpdated = $lastUpdated;

        if (null === $timestamp) {
            $timestamp = new \DateTime();
        }
        $this->timestamp = $timestamp;

        
    }


    /**
     * This method is called before the object data is persisted by Doctrine
     */
    public function beforePersist()
    {
        $this->timestamp = new \DateTime();
    }

    /**
     * This method is called before the object data is updated by Doctrine
     */
    public function beforeUpdate()
    {
        $this->lastUpdated = new \DateTime();
    }

    public function activate()
    {
        $this->active = self::ACTIVE;
    }

    public function deactivate()
    {
        $this->active = self::INACTIVE;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getWorkPosition(): string
    {
        return $this->workPosition;
    }

    public function getImage() : ?UserImage
    {
        return $this->image;
    }

    /**
     * @return UserRole
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdated(): \DateTime
    {
        return $this->lastUpdated;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active == self::ACTIVE;
    }

    /**
     * @return string
     */
    public function getFullName():string
    {
        return $this->getFirstName() . " " . $this->getLastName();
    }

    /**
     * Returns the image as base 64 content
     *
     * @return string | null
     */
    public function loadBase64Image()
    {
        if (null === $this->base64ImageContent) {

            $image = $this->getImage();

            if (null === $image) {
                return null;
            }
            $this->base64ImageContent = $this->getImage()->getContentAsBase64();
        }

        return $this->base64ImageContent;
    }


    /**
     * Specify data which should be serialized to JSON
     *
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *        which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return array(
            "id" => $this->getId(),
            "username" => $this->getUsername(),
            "email" => $this->getEmail(),
            "firstName" => $this->getFirstName(),
            "lastName" => $this->getLastName(),
            "phone" => $this->getPhone(),
            "workPosition" => $this->getWorkPosition(),
            "role" => $this->getRole()->getId(),
            "active" => $this->isActive(),
            "lastUpdated" => $this->getLastUpdated()->format("Y-m-d H:i:s"),
            "timestamp" => $this->getTimestamp()->format("Y-m-d H:i:s"),
            "full_name_ex" => $this->getFirstName() . " " . $this->getLastName() . " ( {$this->getUsername()} )"
        );
    }
}