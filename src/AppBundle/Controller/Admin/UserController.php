<?php
namespace AppBundle\Controller\Admin;


use AppBundle\Controller\BaseController;
use AppBundle\Repository\Exception\UserNotFoundException;
use AppBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * Class UserController
 *
 * @package AppBundle\Controller\Admin
 */
class UserController extends BaseController
{


    protected $userRepository = null;


    /**
     * @Route("/admin_panel/view_user_profile/{id}", name="/admin_panel/view_user_profile/")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewUserProfileAction($id)
    {


        try {
            $user = $this->getUserRepository()->findById($id);


            if (null === $user) {
                throw new UserNotFoundException("User with the id '{$id}' was not fund.");
            }

            $user_image = $user->loadBase64Image();
            if ($user_image === null) {
                $user_image = $this->getDefaultProfileImage();
            }

            $data = array(
                "selected_user" => $user,
                "user_image" => $user_image,
                "success" => true,
                "msg" => "User found"
            );

        } catch (\Exception $exception) {
            $data = array(
                "selected_user" => null,
                "success" => false,
                "msg" => $exception->getMessage()
            );
        }

        return $this->renderMyView(':app/admin:user_profile.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
            'data' => $data
        ]);
    }


    /**
     * @Route("/get_users_by_phrase/{phrase}", name="/get_users_by_phrase",defaults={"phrase" = ""})
     * @Method({"GET"})
     *
     * @param $phrase
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getUsersByPhrase($phrase)
    {

        $response = new JsonResponse();
        try {


            $users = $this->getUserRepository()->findBestMathByUsernameOrNameOrSurname($phrase);

            $response->setData(
                $users->toArray()
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