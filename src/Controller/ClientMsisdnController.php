<?php

namespace App\Controller;

use App\Entity\ClientMsisdn;
use App\Form\ClientMsisdnType;
use App\Repository\ClientMsisdnRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client/msisdn")
 */
class ClientMsisdnController extends AbstractController
{
    /**
     * @Route("/", name="client_msisdn_index", methods={"GET"})
     */
    public function index(ClientMsisdnRepository $clientMsisdnRepository): Response
    {
        $repo = $this->getDoctrine()->getRepository('App\Entity\User');
        return $this->render('client_msisdn/index.html.twig', [
            'client_msisdns' => $clientMsisdnRepository->findBy(['user'=>$repo->findByAccountCode($this->getUser()->getAccountCode())]),
        ]);
    }

    /**
     * @Route("/new", name="client_msisdn_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $repo = $this->getDoctrine()->getRepository('App\Entity\User');

        $clientMsisdn = new ClientMsisdn();
        $form = $this->createForm(ClientMsisdnType::class, $clientMsisdn, ['user' => $repo->findByAccountCode($this->getUser()->getAccountCode())]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $clientMsisdn->setUser($this->getUser()->getParent()?$this->getUser()->getParent():$this->getUser());
            $entityManager->persist($clientMsisdn);
            $entityManager->flush();

            return $this->redirectToRoute('client_msisdn_index');
        }

        return $this->render('client_msisdn/new.html.twig', [
            'client_msisdn' => $clientMsisdn,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="client_msisdn_show", methods={"GET"})
     */
    public function show(ClientMsisdn $clientMsisdn): Response
    {
        return $this->render('client_msisdn/show.html.twig', [
            'client_msisdn' => $clientMsisdn,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_msisdn_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ClientMsisdn $clientMsisdn): Response
    {
        $repo = $this->getDoctrine()->getRepository('App\Entity\User');
        $form = $this->createForm(ClientMsisdnType::class, $clientMsisdn, ['user' => $repo->findByAccountCode($this->getUser()->getAccountCode())]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_msisdn_index', [
                'id' => $clientMsisdn->getId(),
            ]);
        }

        return $this->render('client_msisdn/edit.html.twig', [
            'client_msisdn' => $clientMsisdn,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="client_msisdn_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ClientMsisdn $clientMsisdn): Response
    {
        if ($this->isCsrfTokenValid('delete'.$clientMsisdn->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($clientMsisdn);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_msisdn_index');
    }
}
