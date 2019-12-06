<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductionController extends AbstractController
{
    /**
     * @Route("/production", name="production")
     */
    public function index()
    {
        return $this->render('production/index.html.twig', [
            'controller_name' => 'ProductionController',
            'params'=>1,
        ]);
    }


}
