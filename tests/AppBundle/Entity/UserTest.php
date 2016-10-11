<?php
declare(strict_types = 1);

/**
 * Class UserTest
 */
class UserTest extends PHPUnit_Framework_TestCase
{

    const EXPECTED_ID = 22;
    const EXPECTED_USERNAME = "smith";
    const EXPECTED_PASSWORD = "1234";
    const EXPECTED_EMAIL = "smith@testmail.com";
    const EXPECTED_FIRST_NAME = "John";
    const EXPECTED_LAST_NAME = "Smith";

    public function testConstructor()
    {

        $now = new \DateTime();

        $lastUpdate = clone $now;
        $timestamp = clone $now;

        $user = new \AppBundle\Entity\User(self::EXPECTED_ID,
            self::EXPECTED_USERNAME,
            self::EXPECTED_PASSWORD,
            self::EXPECTED_EMAIL,
            self::EXPECTED_FIRST_NAME,
            self::EXPECTED_LAST_NAME,
            $lastUpdate,
            $timestamp);

        $this->assertEquals(self::EXPECTED_ID, $user->getId());
        $this->assertEquals(self::EXPECTED_USERNAME, $user->getUsername());
        $this->assertEquals(self::EXPECTED_PASSWORD, $user->getPassword());
        $this->assertEquals(self::EXPECTED_EMAIL, $user->getEmail());
        $this->assertEquals(self::EXPECTED_FIRST_NAME, $user->getFirstName());
        $this->assertEquals(self::EXPECTED_LAST_NAME, $user->getLastName());
        $this->assertTrue($user->getLastUpdated() == $now);
        $this->assertTrue($user->getTimestamp() == $now);


    }

    public function testConstructorWithDefaultDateTime()
    {
        $user = new \AppBundle\Entity\User(self::EXPECTED_ID,
            self::EXPECTED_USERNAME,
            self::EXPECTED_PASSWORD,
            self::EXPECTED_EMAIL,
            self::EXPECTED_FIRST_NAME,
            self::EXPECTED_LAST_NAME);

        $this->assertEquals(self::EXPECTED_ID, $user->getId());
        $this->assertEquals(self::EXPECTED_USERNAME, $user->getUsername());
        $this->assertEquals(self::EXPECTED_PASSWORD, $user->getPassword());
        $this->assertEquals(self::EXPECTED_EMAIL, $user->getEmail());
        $this->assertEquals(self::EXPECTED_FIRST_NAME, $user->getFirstName());
        $this->assertEquals(self::EXPECTED_LAST_NAME, $user->getLastName());
        $this->assertInstanceOf(\DateTime::class, $user->getLastUpdated());
        $this->assertInstanceOf(\DateTime::class, $user->getTimestamp());

    }

    public function testActivate()
    {
        $user = new \AppBundle\Entity\User(self::EXPECTED_ID,
            self::EXPECTED_USERNAME,
            self::EXPECTED_PASSWORD,
            self::EXPECTED_EMAIL,
            self::EXPECTED_FIRST_NAME,
            self::EXPECTED_LAST_NAME);

        $user->deactivate();

        $user->activate();

        $this->assertTrue($user->isActive());
    }

    public function testDeactivate()
    {
        $user = new \AppBundle\Entity\User(self::EXPECTED_ID,
            self::EXPECTED_USERNAME,
            self::EXPECTED_PASSWORD,
            self::EXPECTED_EMAIL,
            self::EXPECTED_FIRST_NAME,
            self::EXPECTED_LAST_NAME);

        $user->activate();

        $user->deactivate();

        $this->assertFalse($user->isActive());

    }

}