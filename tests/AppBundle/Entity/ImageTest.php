<?php

/**
 * Class ImageTest
 */
class ImageTest extends PHPUnit_Framework_TestCase
{


    public function testGetImageSize()
    {

        $filePath = __DIR__ . "/res/base64_encoded_image_string";

        $imageContent = file_get_contents($filePath);
        $expectedSize = filesize($filePath);


        $image = $this->getMockBuilder(\AppBundle\Entity\Image::class)
            ->disableOriginalConstructor()
            ->setMethods(array())
            ->getMock();

        $size = \AppBundle\Util\TestUtil::invokeMethod($image, "getImageSize", array($imageContent));
        $this->assertEquals($expectedSize, $size);

    }

    public function testCheckSizeThrowsImageSizeExceededException()
    {
        $filePath = __DIR__ . "/res/base64_encoded_image_string";

        $imageContent = file_get_contents($filePath);
        $maxSize = filesize($filePath) - 100;

        $this->expectException(\AppBundle\Entity\Exception\ImageSizeExceededException::class);
        $this->expectExceptionMessage("Image size is exceeded.Maximum size is {$maxSize} bytes.");

        $image = $this->getMockBuilder(\AppBundle\Entity\Image::class)
            ->disableOriginalConstructor()
            ->setMethods(array())
            ->getMock();

        \AppBundle\Util\TestUtil::invokeMethod($image, "checkSize", array($imageContent, $maxSize));

    }

    public function testCheckSize()
    {
        $filePath = __DIR__ . "/res/base64_encoded_image_string";

        $imageContent = file_get_contents($filePath);
        $maxSize = filesize($filePath);

        $image = $this->getMockBuilder(\AppBundle\Entity\Image::class)
            ->disableOriginalConstructor()
            ->setMethods(array())
            ->getMock();

        \AppBundle\Util\TestUtil::invokeMethod($image, "checkSize", array($imageContent, $maxSize));
    }

}