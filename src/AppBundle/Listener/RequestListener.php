<?php
namespace AppBundle\Listener;

use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;


/**
 * Class RequestListener
 *
 * @package AppBundle\Listener
 */
class RequestListener
{

    private $router;

    /**
     *
     * Temporary
     *
     * @var array
     */
    private static $anonimysRouts = array(
        "login",
        "register_new_user",
        "register",
        "logout",
        "authenticate"
    );


    public function __construct(RouterInterface $r)
    {
        $this->router = $r;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {

        error_log("onKernelRequest >>> " . $event->getRequest()->get('_route'));

        if ($this->isAsseticRequest($event))
            return;

        if ($this->isAnonymousAllowed($event->getRequest()->get('_route'))) {
            return;
        }


        if (!$this->isUserLoggedIn() && $event->isMasterRequest()) {

            $response = new RedirectResponse($this->router->generate('login'));
            $event->setResponse($response);

        }
    }

    private function isAsseticRequest(GetResponseEvent $event)
    {
        return (strpos($event->getRequest()->attributes->get('_route'), 'assetic')
            || strpos($event->getRequest()->attributes->get('_route'), 'wdt'));
    }

    private function isUserLoggedIn()
    {
        $session = new Session();

        $user = $session->get("user", null);

        if (null === $user) {
            error_log("user logedin >>> FALSE");
            return false;
        }

        error_log("user logedin >>> TRUE");

        return true;

    }

    private function isAnonymousAllowed($route)
    {
        return in_array($route, self::$anonimysRouts);

    }


}