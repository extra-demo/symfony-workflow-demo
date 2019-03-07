<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Registry;

class WorkflowController extends AbstractController
{
    /**
     * WorkflowController constructor.
     */
    public function __construct()
    {
    }
    
    /**
     * @Route("/workflow", name="workflow")
     */
    public function index()
    {
        return $this->render('workflow/index.html.twig', [
            'controller_name' => 'WorkflowController',
        ]);
    }
    
    /**
     * @Route("/workflow/incr", name="incr")
     * @param Registry $registry
     * @throws \Symfony\Component\Workflow\Exception\InvalidArgumentException
     */
    public function incr(Registry $registry)
    {
        $subject = new Post();
        $subject->setCurrentPlace('draft');
        $workflow = $registry->get($subject);
        $workflow->apply($subject, 'to_review');
//        if ($workflow->can($subject, 'reject')) {
//            $workflow->apply($subject, 'reject');
//        }
        
        dd($workflow->getEnabledTransitions($subject));
    }
    
}
