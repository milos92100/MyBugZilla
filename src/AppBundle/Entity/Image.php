<?php
declare(strict_types = 1);

namespace AppBundle\Entity;

use AppBundle\Entity\Exception\ImageSizeExceededException;
use Doctrine\DBAL\Types\BlobType;


/**
 * Class Image
 *
 * @package AppBundle\Entity
 */
class Image
{

    /**
     * $id
     *
     * @var int
     */
    protected $id;

    /**
     *
     * $content
     *
     * @var string
     */
    protected $content;

    /**
     * $size
     *
     * @var int
     */
    protected $size;

    /**
     * $timestamp
     *
     * @var \DateTime
     */
    protected $timestamp;

    public function beforePersist()
    {
        $this->timestamp = new \DateTime();
    }

    /**
     *
     * This method checks if the size of the given image exceeds the
     * allowed size.If the size is exceeded a ImageSizeExceededException
     * exception is thrown.
     *
     * @param $content The image content as a string
     * @param $maxSize The maximum size in bytes
     * @throws ImageSizeExceededException
     */
    protected function checkSize($content, $maxSize)
    {
        if ($this->getImageSize($content) > $maxSize) {
            throw new ImageSizeExceededException("Image size is exceeded.Maximum size is {$maxSize} bytes.");
        }
    }

    /**
     * Returns the image size in bytes
     *
     * @param $content The image content
     * @return int
     */
    protected function getImageSize($content)
    {
        return mb_strlen($content, '8bit');
    }

    /**
     * Returns the id.
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Returns the image content
     *
     * @return string
     */
    public function getContent() : string
    {
        return stream_get_contents($this->content);
    }

    /**
     * @return string
     */
    public function getContentAsBase64() : string
    {
        return base64_encode($this->getContent());
    }

    /**
     *
     * Returns the image size
     *
     * @return mixed
     */
    public function getSize() :int
    {
        return $this->size;
    }

    /**
     * Returns the timestamp.
     *
     * @return \DateTime
     */
    public function getTimestamp() : \DateTime
    {
        return $this->timestamp;
    }


}