<?php
declare(strict_types = 1);

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * Class BugReport
 *
 * @package AppBundle\Entity
 */
final class BugReport
{

    private $id;

    private $title;

    private $content;

    private $file;

    private $user;

    private $bugReference;

    private $comments;

    private $answers;

    private $timestamp;

    /**
     * BugReport constructor.
     *
     * @param $id
     * @param $title
     * @param $content
     * @param $file
     * @param $user
     * @param $bugReference
     * @param $comments
     * @param $answers
     * @param $timestamp
     */
    public function __construct(int $id, string $title, string $content, $file = null, User $user, $bugReference = null, ArrayCollection $comments = null, ArrayCollection $answers = null, \DateTime $timestamp = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->file = $file;
        $this->user = $user;
        $this->bugReference = $bugReference;

        if (null === $comments) {
            $comments = new ArrayCollection();
        }

        if (null === $answers) {
            $answers = new ArrayCollection();
        }
        $this->comments = $comments;
        $this->answers = $answers;
        $this->timestamp = $timestamp;
    }

    public function beforePersist()
    {
        $this->timestamp = new \DateTime();
    }


}