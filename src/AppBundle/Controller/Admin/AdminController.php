<?php
namespace AppBundle\Controller\Admin;


use AppBundle\AppBundle;
use AppBundle\Entity\User;
use AppBundle\Repository\Exception\UserNotFoundException;
use AppBundle\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Controller\ListController;

/**
 * Class AdminController
 *
 * @package AppBundle\Controller
 */
class AdminController extends ListController
{

    const LIMIT = 5;

    protected $userRepository = null;

    /**
     * @Route("/admin_panel", name="admin_panel")
     *
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->renderMyView(':app/admin:admin.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
        ]);

    }

    /**
     * @Route("/admin_panel/users/{page}",
     *     name="admin_panel_show_users" ,
     *     requirements={"page": "\d+"}  ,
     *     defaults={"page" = 1})
     *
     * @Method({"GET"})
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showUsersAction($page)
    {
        return $this->renderMyListView(User::class, self::LIMIT, $page, ':app/admin:users.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
        ]);
    }

    /**
     * @Route("/admin_panel/add_user", name="/admin_panel/add_user")
     * @Method({"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAddUserAction()
    {
        return $this->renderMyView(':app/admin:add_user.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
        ]);
    }

    /**
     * @Route("/admin_panel/view_user_profile/{id}", name="/admin_panel/view_user_profile/")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewUserProfileAction($id)
    {

        $data = array();
        try {
            $user = $this->getUserRepository()->findById($id);

            if (null === $user) {
                throw new UserNotFoundException("User with the id '{$id}' was not fund.");
            }

            $data = array(
                "selected_user" => $user,
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
     * @return UserRepository|null
     */
    protected function getUserRepository()
    {
        if (null === $this->userRepository) {
            $this->userRepository = new UserRepository($this->getDoctrine()->getManager());
        }
        return $this->userRepository;
    }

}