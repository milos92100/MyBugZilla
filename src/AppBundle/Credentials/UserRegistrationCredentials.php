<?php
declare(strict_types = 1);

namespace AppBundle\Credentials;

use AppBundle\Credentials\Exception\EmailNotValidException;
use AppBundle\Credentials\Exception\PasswordsNotMatchingException;
use AppBundle\Entity\User;

/**
 * Class UserRegistrationCredentials
 *
 * @package AppBundle\Credentials
 */
final class UserRegistrationCredentials extends Credentials
{
    const MIN_USERNAME_LENGTH = 5;

    const MIN_PASSWORD_LENGTH = 8;


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
     * $workPosition
     *
     * @var string
     */
    private $workPosition;

    /**
     * $image
     *
     * @var string
     */
    private $image;

    /**
     * UserRegistrationCredentials constructor.
     *
     * @param string $username
     * @param string $password
     * @param string $repeatedPassword
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string $phone
     * @param string $workPosition
     * @param string $image
     * @throws PasswordsNotMatchingException
     * @throws EmailNotValidException
     */
    public function __construct(
        string $username,
        string $password,
        string $repeatedPassword,
        string $email,
        string $firstName,
        string $lastName,
        string $phone,
        string $workPosition,
        string $image
    )
    {

        $this->checkPasswords($password, $repeatedPassword);

        $this->validateEmail($email);

        $this->username = $this->checkInputLength(
            $username,
            self::MIN_USERNAME_LENGTH,
            "The username must be at least " . self::MIN_USERNAME_LENGTH . " characters long."
        );

        $this->password = $this->checkInputLength(
            $password,
            self::MIN_PASSWORD_LENGTH,
            "The password must be at least " . self::MIN_PASSWORD_LENGTH . " characters long."
        );

        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->workPosition = $workPosition;
        $this->image = $image;
    }

    /**
     * @param $password
     * @param $repeatedPassword
     * @throws PasswordsNotMatchingException
     */
    protected function checkPasswords($password, $repeatedPassword)
    {
        if (0 !== strcmp($password, $repeatedPassword)) {
            throw new PasswordsNotMatchingException("The entered passwords are not matching");
        }
    }

    /**
     * @param $email
     * @throws EmailNotValidException
     */
    protected function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            throw new EmailNotValidException("The given email '{$email}' is not valid.");
        }
    }

    public function getHashedPassword()
    {
        return hash(User::PASSWORD_HASH_ALGORITHM, $this->getPassword());
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

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }


    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }


}