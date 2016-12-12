<?php
declare(strict_types = 1);

namespace AppBundle\Entity;


/**
 * Class UserImage
 *
 * @package AppBundle\Entity
 */
class UserImage extends Image
{

    /**
     * This constant represents the maximum image size in bytes.
     */
    protected const MAX_SIZE = 2000000;  //bytes - 2 MB

    /**
     * $user
     *
     * @var User
     */
    private $user;

    /**
     * UserImage constructor.
     *
     * @param int    $id
     * @param User   $user
     * @param string $content base 64 encoded string
     * @internal param int $userId
     */
    public function __construct(int $id, User $user, string $content)
    {
        $this->checkSize($content, self::MAX_SIZE);

        $this->id = $id;
        $this->user = $user;
        $this->content = base64_decode($content);
        $this->size = $this->getImageSize($content);
    }


    /**
     * Returns the User.
     *
     * @return User
     */
    public function getUser() : User
    {
        return $this->user;
    }


}