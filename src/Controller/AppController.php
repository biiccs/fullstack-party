<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AppController
 * @package App\Controller
 */
class AppController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $user = $this->getUser();
        if ($user && in_array('ROLE_USER', $user->getRoles())) {
            $this->redirectToRoute('issues');
        }

        return $this->render(
            'app/index.html.twig'
        );
    }

    /**
     * @Route("/app", name="issues")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function issues(Request $request)
    {
        $provider = $this->get('Github\Provider');
        $filter = $provider::getIssuesFilter($request);
        $issues = $this->get('Github\Provider')->getIssues($filter);

        $paging = $provider->parsePagination($filter);
        $counting = $provider->totalCount($filter, $paging['total']);

        $data = [
            'filter' => $filter,
            'issues' => $issues,
            'pagination' => $paging,
            'counting' => $counting,
        ];

        return $this->render('app/issues.html.twig', $data);
    }

    /**
     * @Route("/app/issue/{id}", name="issue")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function issue($id)
    {
        $provider = $this->get('Github\Provider');
        $issue = $provider->getIssue($id);

        $data = [
            'issue' => $issue,
        ];

        $data['comments'] = !empty($issue['comments']) ? $provider->getIssueComments($id) : [];

        return $this->render('app/issue.html.twig', $data);
    }
}