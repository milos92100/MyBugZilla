<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class HelpController
 *
 * @package AppBundle\Controller
 */
class HelpController extends BaseController
{


    /**
     * @Route("/help", name="help")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {

        return $this->renderMyView(':app:help.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),

        ]);

    }

}