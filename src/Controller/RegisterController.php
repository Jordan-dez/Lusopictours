<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;


class RegisterController extends AbstractController
{   
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;

    }
    /**
     * @Route("/inscription", name="app_register")
     */
    public function index(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        $notification=null;
        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user=$form->getData();
            $password= $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);
           $this->entityManager->persist($user);
           $this->entityManager->flush();
           $notification="Votre inscription a été prise en compte"; 
        }

        return $this->render('register/index.html.twig',[
            'formulaire'=> $form->createView(),
            'notification'=>$notification,
        ]);
    }
}
