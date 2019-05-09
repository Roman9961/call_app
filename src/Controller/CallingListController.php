<?php

namespace App\Controller;

use App\Entity\CallingList;
use App\Entity\ClientMsisdn;
use App\Form\CallingListType;
use App\Repository\CallingListRepository;
use App\Utils\CsvParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/calling/list")
 */
class CallingListController extends AbstractController
{
    /**
     * @Route("/", name="calling_list_index", methods={"GET"})
     */
    public function index(CallingListRepository $callingListRepository): Response
    {
        $repo = $this->getDoctrine()->getRepository('App\Entity\User');
        return $this->render('calling_list/index.html.twig', [
            'calling_lists' => $callingListRepository->findBy(['user'=>$repo->findByAccountCode($this->getUser()->getAccountCode())]),
        ]);
    }

    /**
     * @Route("/new", name="calling_list_new", methods={"GET","POST"})
     */
    public function new(Request $request, CsvParser $csvParser): Response
    {
        $repo = $this->getDoctrine()->getRepository('App\Entity\User');
        $callingList = new CallingList();
        $form = $this->createForm(CallingListType::class, $callingList, ['user' => $repo->findByAccountCode($this->getUser()->getAccountCode())]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $user = $this->getUser()->getParent()?$this->getUser()->getParent():$this->getUser();
            $callingList->setUser($user);

            $file = $form->get('file');
            $start = time();
            if($file) {
                $msisdns = $csvParser->saveMsisdnFromCsv($file->getData(), $user);
                foreach ($msisdns as $msisdn) {
                    $callingList->addClientMsisdn($msisdn);
                }
            }
            $entityManager->persist($callingList);
            $end = time();
            dd($end-$start);

            $entityManager->flush();
            $end = time();
            dump($end-$start);
            return $this->redirectToRoute('calling_list_index');
        }

        return $this->render('calling_list/new.html.twig', [
            'calling_list' => $callingList,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calling_list_show", methods={"GET"})
     */
    public function show(CallingList $callingList): Response
    {
        return $this->render('calling_list/show.html.twig', [
            'calling_list' => $callingList,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="calling_list_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CallingList $callingList): Response
    {
        $repo = $this->getDoctrine()->getRepository('App\Entity\User');
        $form = $this->createForm(CallingListType::class, $callingList, ['user' => $repo->findByAccountCode($this->getUser()->getAccountCode())]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('calling_list_index', [
                'id' => $callingList->getId(),
            ]);
        }

        return $this->render('calling_list/edit.html.twig', [
            'calling_list' => $callingList,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="calling_list_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CallingList $callingList): Response
    {
        if ($this->isCsrfTokenValid('delete'.$callingList->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($callingList);
            $entityManager->flush();
        }

        return $this->redirectToRoute('calling_list_index');
    }
}
