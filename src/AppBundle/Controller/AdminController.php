<?php
namespace AppBundle\Controller;


use AppBundle\AppBundle;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class AdminController
 *
 * @package AppBundle\Controller
 */
class AdminController extends ListController
{

    const LIMIT = 5;

    /**
     * @Route("/admin_panel/{page}", name="admin_panel_show_users" ,requirements={"page": "\d+"} ,defaults={"page" = 1})
     *
     * @Method({"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page)
    {
        return $this->renderMyListView(User::class, self::LIMIT, $page, ':app/admin:admin.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
        ]);

    }

}