<?php
namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * Class AboutUsController
 *
 * @package AppBundle\Controller
 */
class AboutUsController extends BaseController
{

    /**
     * @Route("/about_us", name="about_us")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {

        return $this->renderMyView(':app:about_us.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),

        ]);

    }
}