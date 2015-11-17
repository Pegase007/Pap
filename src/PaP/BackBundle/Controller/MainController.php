<?php

namespace PaP\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller

{
    public function indexAction()
    {
        return $this->render('BackBundle:Default:index.html.twig');
    }
}
