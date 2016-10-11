<?php
declare(strict_types = 1);

use AppBundle\Credentials\UserRegistrationCredentials;

/**
 * Class UserRegistrationCredentialsTest
 */
class UserRegistrationCredentialsTest extends PHPUnit_Framework_TestCase
{

    public function testConstructorThrowsPasswordsNotMatchingException()
    {

        $this->expectException(\AppBundle\Credentials\Exception\PasswordsNotMatchingException::class);

        $username = "smith";
        $password = "smith1234";
        $repeatedPassword = "smith12345";
        $email = "smith@testmail.com";
        $firstName = "Will";
        $lastName = "Smith";

        $creds = new UserRegistrationCredentials($username, $password, $repeatedPassword, $email, $firstName, $lastName);


    }

    public function testConstructorThrowsEmailNotValidException()
    {
        $this->expectException(\AppBundle\Credentials\Exception\EmailNotValidException::class);

        $username = "smith";
        $password = "smith1234";
        $repeatedPassword = "smith1234";
        $email = "asdasdds";
        $firstName = "Will";
        $lastName = "Smith";

        $creds = new UserRegistrationCredentials($username, $password, $repeatedPassword, $email, $firstName, $lastName);


    }

    public function testConstructorThrowsInvalidArgumentExceptionForInvalidUsernameLength()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("The username must be at least " . UserRegistrationCredentials::MIN_USERNAME_LENGTH . " characters long.");

        $username = "smit";
        $password = "smith1234";
        $repeatedPassword = "smith1234";
        $email = "smith@testmail.com";
        $firstName = "Will";
        $lastName = "Smith";

        $creds = new UserRegistrationCredentials($username, $password, $repeatedPassword, $email, $firstName, $lastName);

    }

    public function testConstructorThrowsInvalidArgumentExceptionForInvalidPasswordLength()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("The password must be at least " . UserRegistrationCredentials::MIN_PASSWORD_LENGTH . " characters long.");

        $username = "smith";
        $password = "smith1";
        $repeatedPassword = "smith1";
        $email = "smith@testmail.com";
        $firstName = "Will";
        $lastName = "Smith";

        $creds = new UserRegistrationCredentials($username, $password, $repeatedPassword, $email, $firstName, $lastName);

    }

    public function testConstructor()
    {
        $username = "smith";
        $password = "smith1234";
        $repeatedPassword = "smith1234";
        $email = "smith@testmail.com";
        $firstName = "Will";
        $lastName = "Smith";

        $credentials = new UserRegistrationCredentials($username, $password, $repeatedPassword, $email, $firstName, $lastName);

        $this->assertEquals($username, $credentials->getUsername());
        $this->assertEquals($password, $credentials->getPassword());
        $this->assertEquals($email, $credentials->getEmail());
        $this->assertEquals($firstName, $credentials->getFirstName());
        $this->assertEquals($lastName, $credentials->getLastName());
    }


}