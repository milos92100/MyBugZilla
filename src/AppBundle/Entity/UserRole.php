<?php
declare(strict_types = 1);

namespace AppBundle\Entity;

/**
 * Class UserRole
 *
 * @package AppBundle\Entity
 */
class UserRole
{


    const ADMIN = 1;

    const USER = 2;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * UserRole constructor.
     *
     * @param $id
     * @param $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isAdmin() : bool
    {
        return $this->id == self::ADMIN;
    }


}