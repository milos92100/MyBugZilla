<?php
namespace AppBundle\Service\Exception;

use AppBundle\Service\Auth\AuthFailureExceptionInterface;


/**
 * Class AccessDeniedException
 *
 * @package AppBundle\Service\Exception
 */
class AccessDeniedException extends \Exception implements AuthFailureExceptionInterface
{

}