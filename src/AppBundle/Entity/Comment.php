<?php
namespace AppBundle\Entity;

use AppBundle\Entity\User;


/**
 * Class Comment
 *
 * @package AppBundle\Entity
 */
abstract class Comment
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \AppBundle\Entity\User
     */
    private $user;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * BugReportComment constructor.
     *
     * @param $id
     * @param $content
     * @param $user
     * @param $timestamp
     */
    public function __construct(int $id, string $content, User $user, \DateTime $timestamp = null)
    {
        $this->id = $id;
        $this->content = $content;
        $this->user = $user;

        if (null === $timestamp) {
            $timestamp = new \DateTime();
        }
        $this->timestamp = $timestamp;
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
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

}