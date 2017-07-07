<?php

namespace Vidandev\WebpackAssetsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WebpackAssetsBundle:Default:index.html.twig');
    }
}
