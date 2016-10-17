<?php
declare(strict_types = 1);

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class BaseController
 *
 * @package AppBundle\Controller
 */
class BaseController extends Controller
{

    /**
     * @var Session
     */
    protected $session = null;

    /**
     * @return User || null
     */
    protected function getLoggedUser()
    {
        return $this->getSession()->get("user", null);

    }

    /**
     * @param string        $view
     * @param array         $parameters
     * @param Response|null $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderMyView($view, array $parameters = array(), Response $response = null)
    {
        return parent::render($view,
            array_merge($parameters, [
                "menu" => $this->getMenuItems($this->getLoggedUser()),
                "user" => $this->getLoggedUser()
            ]),
            $response);
    }

    protected function getMenuItems(User $user = null)
    {
        if (null === $user) {
            return array(
                "left_menu" => array(),
                "right_menu" => array(),
                "profile" => false,
            );
        }


        if ($user->getRole()->isAdmin()) {
            $menu = array(
                "left_menu" => array(
                    "Bug Reports" => "/bug_reports",
                    "Report Bag" => "/new_bug_report",


                ),
                "right_menu" => array(
                    "Help" => "/help",
                    "About us" => "/about_us",
                    "Admin Panel" => "/admin_panel",
                ),
                "profile_menu" => array(
                    "My Profile" => "/user_profile",
                    "Preference" => "/user_preference"
                ),
                "profile" => true,

            );

        } else {
            $menu = array(
                "left_menu" => array(
                    "Bug Reports" => "/bug_reports",
                    "Report Bag" => "/new_bug_report",


                ),
                "right_menu" => array(
                    "Help" => "/help",
                    "About us" => "/about_us",
                ),
                "profile_menu" => array(
                    "My Profile" => "/user_profile",
                    "Preference" => "/user_preference"
                ),
                "profile" => true,

            );
        }

        return $menu;

    }

    /**
     * @return Session
     */
    protected function getSession()
    {
        if (null === $this->session) {
            $this->session = new Session();
        }
        return $this->session;
    }
}