<?php

namespace AppBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Class BugReportAnswer
 *
 * @package AppBundle\Entity
 */
class BugReportAnswer
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
     * @var ArrayCollection
     */
    private $confirmations;

    /**
     * @var ArrayCollection
     */
    private $disagreements;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * BugReportAnswer constructor.
     *
     * @param $id
     * @param $content
     * @param $user
     * @param $confirmations
     * @param $disagreements
     * @param $timestamp
     */
    public function __construct(int $id, string $content, User $user, ArrayCollection $confirmations = null, ArrayCollection $disagreements = null, \DateTime $timestamp = null)
    {
        $this->id = $id;
        $this->content = $content;
        $this->user = $user;

        if (null === $confirmations) {
            $confirmations = new ArrayCollection();
        }

        if (null === $disagreements) {
            $disagreements = new ArrayCollection();
        }

        $this->confirmations = $confirmations;
        $this->disagreements = $disagreements;
        $this->timestamp = $timestamp;
    }


}