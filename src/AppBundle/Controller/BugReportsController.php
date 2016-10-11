<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * Class BugReportsController
 *
 * @package AppBundle\Controller
 */
class BugReportsController extends BaseController
{

    /**
     * @Route("/bug_reports", name="bug_reports")
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {


        return $this->renderMyView(':app:bug_reports.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
        ]);
    }

    /**
     * @Route("/new_bug_report", name="new_bug_report")
     * @Method({"GET"})
     */
    public function reportNewBugAction()
    {

        return $this->renderMyView(':app:new_bug_report.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
        ]);
    }

}