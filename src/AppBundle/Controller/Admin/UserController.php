<?php
namespace AppBundle\Controller\Admin;


use AppBundle\Controller\BaseController;
use AppBundle\Repository\Exception\UserNotFoundException;
use AppBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 *
 * @package AppBundle\Controller\Admin
 */
class UserController extends BaseController
{


    protected $userRepository = null;

    /**
     * Deactivates a user by id.
     *
     * @Route("/deactivate_user", name="deactivate_user")
     * @Method({"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function deactivateUser(Request $request)
    {

        $jsonResponse = new JsonResponse();

        try {

            $id = $request->request->get("id");

            $user = $this->getUserRepository()->getById($id);

            $this->getUserRepository()->deactivate($user->getId());

            $jsonResponse->setData(array(
                "success" => true,
                "msg" => "User {$user->getFullName()} successfully deactivated.",
                "data" => $user
            ));

        } catch (\Exception $exception) {
            $jsonResponse->setData(array(
                "success" => false,
                "msg" => $exception->getMessage(),
                "data" => null
            ));
        }

        return $jsonResponse;

    }

    protected function getUserRepository()
    {
        if (null === $this->userRepository) {
            $this->userRepository = new UserRepository($this->getDoctrine()->getManager());
        }
        return $this->userRepository;
    }


}