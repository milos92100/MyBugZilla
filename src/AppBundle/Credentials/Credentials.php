<?php
declare(strict_types = 1);

namespace AppBundle\Credentials;


/**
 * Class Credentials
 *
 * @package AppBundle\Credentials
 */
abstract class Credentials
{
    /**
     *
     * Checks if the input input string length is valid.If not it throws a InvalidArgumentException.
     * If the input is valid it returns the entered value.
     *
     * @param string $input
     * @param int    $minLength [optional]
     * @param string $errorMsg  [optional]
     * @return string $input
     */
    protected function checkInputLength(string $input, int $minLength = 1, string $errorMsg = "") : string
    {
        if (strlen($input) < $minLength) {
            throw new \InvalidArgumentException($errorMsg);
        }

        return $input;
    }

}