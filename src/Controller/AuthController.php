<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthController
 * @package App\Controller
 */
class AuthController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        return $this->render(
            'index.html.twig'
        );
    }
}