<?php

namespace App\Controller;

use App\Entity\CallingTime;
use App\Form\CallingTimeType;
use App\Repository\CallingTimeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/calling/time")
 */
class CallingTimeController extends AbstractController
{
    /**
     * @Route("/", name="calling_time_index", methods={"GET"})
     */
    public function index(CallingTimeRepository $callingTimeRepository): Response
    {
        return $this->render('calling_time/index.html.twig', [
            'calling_times' => $callingTimeRepository->findBy(['user' => $this->getUser()]),
        ]);
    }

    /**
     * @Route("/new", name="calling_time_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $callingTime = new CallingTime();
        $form = $this->createForm(CallingTimeType::class, $callingTime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $callingTime->setUser($this->getUser()->getParent()?$this->getUser()->getParent():$this->getUser());
            $entityManager->persist($callingTime);
            $entityManager->flush();

            return $this->redirectToRoute('calling_time_index');
        }

        return $this->render('calling_time/new.html.twig', [
            'calling_time' => $callingTime,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calling_time_show", methods={"GET"})
     */
    public function show(CallingTime $callingTime): Response
    {
        return $this->render('calling_time/show.html.twig', [
            'calling_time' => $callingTime,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="calling_time_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CallingTime $callingTime): Response
    {
        $form = $this->createForm(CallingTimeType::class, $callingTime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('calling_time_index', [
                'id' => $callingTime->getId(),
            ]);
        }

        return $this->render('calling_time/edit.html.twig', [
            'calling_time' => $callingTime,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calling_time_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CallingTime $callingTime): Response
    {
        if ($this->isCsrfTokenValid('delete'.$callingTime->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($callingTime);
            $entityManager->flush();
        }

        return $this->redirectToRoute('calling_time_index');
    }
}
