<?php

namespace AppBundle\Controller;


use AppBundle\Credentials\UserRegistrationCredentials;
use AppBundle\Service\UserRegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Controller\BaseController;

/**
 * Class RegistrationController
 *
 * @package AppBundle\Controller
 */
class UserRegistrationController extends BaseController
{

    protected $userRegistrationService = null;

    /**
     *
     * @Route("/register", name="register")
     * @Method({"GET"})
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {

        return $this->renderMyView(':app:register.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
        ]);
    }

    /**
     * @Route("/register_new_user", name="register_new_user")
     * @Method({"POST"})
     */
    public function registerNewUser(Request $request)
    {

        $response = new JsonResponse();
        try {

            $credentials = new UserRegistrationCredentials(
                $request->request->get("username"),
                $request->request->get("password"),
                $request->request->get("repeatPassword"),
                $request->request->get("email"),
                $request->request->get("firstName"),
                $request->request->get("lastName")
            );

            $user = $this->getUserRegistrationService()->registerNewUser($credentials);

            $response->setData(
                array(
                    "success" => true,
                    "msg" => "Successfully registered !",
                    "data" => $user
                )
            );

        } catch (\Exception $exception) {
            $response->setData(
                array(
                    "success" => false,
                    "msg" => $exception->getMessage(),
                    "data" => null
                )
            );
        }

        return $response;

    }

    /**
     * @return UserRegistrationService|null
     */
    protected function getUserRegistrationService()
    {
        if (null === $this->userRegistrationService) {
            $this->userRegistrationService = new UserRegistrationService($this->getDoctrine()->getManager());
        }
        return $this->userRegistrationService;
    }

}