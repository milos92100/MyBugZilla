<?php


namespace AppBundle\Controller;


/**
 * Class ListController
 *
 * @package AppBundle\Controller
 */
class ListController extends BaseController
{

    /**
     * @param string        $class
     * @param int           $limit
     * @param int           $page
     * @param               $view
     * @param array         $parameters
     * @param Response|null $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderMyListView(string $class, int $limit, int $page, $view, array $parameters = array(), Response $response = null)
    {
        $offset = ($page * $limit) - $limit;

        $qb = $this->getDoctrine()->getManager()->createQueryBuilder();
        $qb->select($qb->expr()->count('entity.id'));
        $qb->from($class, 'entity');


        $count = $qb->getQuery()->getSingleScalarResult();
        $repo = $this->getDoctrine()->getRepository($class);
        $result = $repo->findBy(array(), null, $limit, $offset);

        return $this->renderMyView($view, array_merge($parameters, [
            'result' => $result,
            'current_page' => $page,
            'total_pages' => (ceil($count / $limit)),
            'count' => $count,
        ]));

    }


}