<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Workflow\Exception\UndefinedTransitionException;
use Symfony\Component\Workflow\Registry;

class WorkflowController extends AbstractController
{
    /**
     * @var PostRepository
     */
    protected $postRepository;
    
    /**
     * WorkflowController constructor.
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    
    /**
     * @Route("/workflow", name="workflow")
     * @throws \LogicException
     * @throws \Doctrine\ORM\ORMException
     */
    public function index(Registry $registry, Request $request)
    {
        $id = $request->get('id');
        $subject = $this->postRepository->find($id);
        if (empty($subject)) {
            $subject = $this->postRepository->create("title", "content", "draft");
        }

        return $this->render('workflow/index.html.twig', [
            'post' => $subject,
            'id' => $id,
        ]);
    }
    
    /**
     * @Route("/workflow/next", name="next")
     *
     * @param Registry $registry
     * @param Request  $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Symfony\Component\Workflow\Exception\LogicException
     * @throws \Symfony\Component\Workflow\Exception\InvalidArgumentException
     */
    public function apply(Registry $registry, Request $request)
    {
        try {
            $id = $request->get('id');
            $subject = $this->postRepository->find($id);
            
            $workflow = $registry->get($subject);
            $transition = $request->get('transition');
            $workflow->apply($subject, $transition);
            
            $place = array_keys($workflow->getMarking($subject)->getPlaces())[0];
            $this->postRepository->updatePlaces($subject, $place);
        } catch (UndefinedTransitionException $exception) {
            return JsonResponse::create(['not' => 'supported']);
        }
        return RedirectResponse::create('/workflow?id=' . $id);
    }
    
    /**
     * @Route("/reset", name="reset")
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function reset(Request $request)
    {
        $id = $request->get('id');
        $this->postRepository->resetPlace($id);
        return RedirectResponse::create('/workflow?id=' . $id);
    }
}
