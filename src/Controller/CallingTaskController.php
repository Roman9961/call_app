<?php

namespace App\Controller;

use App\Entity\CallingTask;
use App\Form\CallingTaskType;
use App\Repository\CallingTaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/calling/task")
 */
class CallingTaskController extends AbstractController
{
    /**
     * @Route("/", name="calling_task_index", methods={"GET"})
     */
    public function index(CallingTaskRepository $callingTaskRepository): Response
    {
        $repo = $this->getDoctrine()->getRepository('App\Entity\User');
        return $this->render('calling_task/index.html.twig', [
            'calling_tasks' => $callingTaskRepository->findBy(['user'=>$repo->findByAccountCode($this->getUser()->getAccountCode())]),
        ]);
    }

    /**
     * @Route("/new", name="calling_task_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $repo = $this->getDoctrine()->getRepository('App\Entity\User');

        $callingTask = new CallingTask();
        $form = $this->createForm(CallingTaskType::class, $callingTask, ['user' => $repo->findByAccountCode($this->getUser()->getAccountCode())]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $callingTask->setUser($this->getUser()->getParent()?$this->getUser()->getParent():$this->getUser());
            $entityManager->persist($callingTask);
            $entityManager->flush();

            return $this->redirectToRoute('calling_task_index');
        }

        return $this->render('calling_task/new.html.twig', [
            'calling_task' => $callingTask,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calling_task_show", methods={"GET"})
     */
    public function show(CallingTask $callingTask): Response
    {
        return $this->render('calling_task/show.html.twig', [
            'calling_task' => $callingTask,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="calling_task_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CallingTask $callingTask): Response
    {
        $repo = $this->getDoctrine()->getRepository('App\Entity\User');

        $form = $this->createForm(CallingTaskType::class, $callingTask, ['user' => $repo->findByAccountCode($this->getUser()->getAccountCode())]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('calling_task_index', [
                'id' => $callingTask->getId(),
            ]);
        }

        return $this->render('calling_task/edit.html.twig', [
            'calling_task' => $callingTask,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calling_task_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CallingTask $callingTask): Response
    {
        if ($this->isCsrfTokenValid('delete'.$callingTask->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($callingTask);
            $entityManager->flush();
        }

        return $this->redirectToRoute('calling_task_index');
    }
}
