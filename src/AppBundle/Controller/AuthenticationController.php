<?php
/**
 * Created by PhpStorm.
 * User: milos
 * Date: 25.9.16.
 * Time: 23.44
 */

namespace AppBundle\Controller;

use AppBundle\Credentials\AuthenticationCredentials;
use AppBundle\Service\AuthenticationService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class AuthenticationController
 *
 * @package AppBundle\Controller
 */
class AuthenticationController extends BaseController
{

    /**
     * $authenticationService
     *
     * @var AuthenticationService
     */
    protected $authenticationService = null;

    /**
     *
     * @Route("/login", name="login")
     * @Method({"GET"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {

        $session = new Session();

        error_log("logout");
        $session->clear();

        // replace this example code with whatever you need
        return $this->renderMyView('app/login.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
        ]);

    }

    /**
     * @Route("/authenticate", name="authenticate")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function authenticateAction(Request $request)
    {
        $response = new JsonResponse();

        try {


            $username = $request->request->get("username");
            $password = $request->request->get("password");

            $credentials = new AuthenticationCredentials($username, $password);

            $authResponse = $this->getAuthenticationService()->authenticate($credentials);

            $response->setData(
                array(
                    "success" => true,
                    "msg" => "Auth. finished",
                    "data" => $authResponse
                )
            );


        } catch (\Exception $e) {

            $response->setData(
                array(
                    "success" => false,
                    "msg" => $e->getMessage(),
                    "data" => null
                )
            );
        }

        return $response;

    }

    /**
     * @Route("/logout", name="logout")
     * @Method({"POST"})
     */
    public function logout()
    {


        $response = new JsonResponse();

        try {


            $session = new Session();

            error_log("logout");
            $session->clear();


            $response->setData(
                array(
                    "success" => true,
                    "msg" => "Loged out",
                    "data" => null
                )
            );


        } catch (\Exception $e) {

            $response->setData(
                array(
                    "success" => false,
                    "msg" => $e->getMessage(),
                    "data" => null
                )
            );
        }

        return $response;
    }

    /**
     * @return AuthenticationService
     */
    protected function getAuthenticationService()
    {
        if (null === $this->authenticationService) {
            $this->authenticationService = new AuthenticationService($this->getDoctrine()->getManager());
        }
        return $this->authenticationService;
    }

}