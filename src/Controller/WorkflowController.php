<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WorkflowController extends AbstractController
{
    /**
     * @Route("/workflow", name="workflow")
     */
    public function index()
    {
        return $this->render('workflow/index.html.twig', [
            'controller_name' => 'WorkflowController',
        ]);
    }
}
