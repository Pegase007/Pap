<?php

namespace PaP\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrontBundle:Main:index.html.twig');
    }
}
