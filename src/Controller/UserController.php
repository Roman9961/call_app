<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("admin/user")
 */
class UserController extends AbstractController
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findByParent($this->getUser());
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $roles =[
            'supervisor' =>'ROLE_SUPERVISOR',
            'administrator' =>'ROLE_ADMIN',
            'user' =>'ROLE_USER'
        ];

        if (!in_array('ROLE_ROOT', $this->getUser()->getRoles())){
            unset($roles['administrator']);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();

        $form = $this->createForm(UserType::class, $user, ['roles' => $roles, 'user' => $this->getUser(),'isSelfEdit' => false]);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {


                $password = $form->get('password')->getData();
                if($password) {
                    $user->setPassword($this->encoder->encodePassword($user, $password));
                    $entityManager->persist($user);
                }
                $user->setRoles($form->getData()->getRoles());

                $entityManager->persist($user);
                $entityManager->flush();

                    if(!$form->getData()->getParent()) {
                        $user->setParent($this->getUser());
                    }

//                    $user->setParent(null);

                    $user->generateAccountCode();


                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('user_index');
            }
        }


        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $roles =[
            'supervisor' =>'ROLE_SUPERVISOR',
            'administrator' =>'ROLE_ADMIN',
            'user' =>'ROLE_USER'
        ];
dd(substr('38380982187143', -10));
        if (!in_array('ROLE_ROOT', $this->getUser()->getRoles())){
            unset($roles['administrator']);
        }elseif (!in_array('ROLE_ADMIN', $this->getUser()->getRoles())
            &&!in_array('ROLE_ROOT', $this->getUser()->getRoles())
        ){
            unset($roles['supervisor']);
        }


        $form = $this->createForm(UserType::class, $user, ['roles' => $roles, 'user' => $this->getUser(), 'isSelfEdit' => $this->getUser() == $user]);
        $form->handleRequest($request);
        if ($form->isSubmitted()){

            if (
                !in_array('ROLE_SUPERVISOR', $user->getRoles())&&
                $user->getChildren()->count()>0 &&
                $this->getUser() !== $user
            ){
                $form->addError(new FormError('User have children: cant change role'));
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if(!$form->getData()->getParent() && $this->getUser() !== $user) {
                $user->setParent($this->getUser());
            }

            $user->generateAccountCode();

            $password = $form->get('password')->getData();
            if($password) {
                $user->setPassword($this->encoder->encodePassword($user, $password));
            }

            $em->persist($user);
            $em->flush();

            $route = 'user_index';
            if($request->query->has('profile')){
                $route = 'admin';
            }
            return $this->redirectToRoute($route, [
                'id' => $user->getId(),
            ]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'profile' => $request->get('profile'),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
