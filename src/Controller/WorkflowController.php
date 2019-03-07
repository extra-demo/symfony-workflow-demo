<?php

namespace App\Controller;

use App\Repository\PullRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkflowController extends AbstractController
{
    /**
     * @var PullRequestRepository
     */
    protected $pullRequestRepository;
    
    /**
     * WorkflowController constructor.
     * @param PullRequestRepository $pullRequestRepository
     */
    public function __construct(PullRequestRepository $pullRequestRepository)
    {
        $this->pullRequestRepository = $pullRequestRepository;
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
     */
    public function incr()
    {
        return JsonResponse::create($this->pullRequestRepository->findAll());
    }
}
