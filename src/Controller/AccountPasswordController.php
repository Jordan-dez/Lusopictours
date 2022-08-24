<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ChangePasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;

    }
    /**
     * @Route("/compte/modifier-mon-mot-de-passe", name="app_account_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notification=null;
        //optention de l'utilisateur courant
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class , $user);
        $form->handleRequest($request);
        //summission du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('old_password')->getData();
            //vérifie si l'ancien  mot de passe saisie par l'utilisateur correspond à au lmot de passe de l'utilisateur dans la bdd 
            if ($encoder->isPasswordValid($user, $old_pwd)) {
                //récupérer le nouveau mot de passe et l'encoder
                $new_pwd = $form->get('new_password')->getData();
                $password = $encoder->encodePassword($user, $new_pwd);
                //modifier l'ancien motde passe existant dans user
                $user->setPassword($password);
                // $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification="votre mot de passe a été mis à jour";
            }else{
                $notification="votre mot de passe actuel est incorrect";
            }
        }

        return $this->render('account/password.html.twig', [
            'formulaire' => $form->createView(),
            'notification' => $notification,
        ]);
    }
}