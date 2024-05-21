<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function index(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $error =$authenticationUtils->getLastAuthenticationError();
        $lastUsername =$authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig',[
            'error'=>$error,
            'lastUsername'=>$lastUsername
        ]);
    }
    #[Route('/logout', name: 'logout')]
    public function logout()
    {}
    
    #[Route('/login/new',name:'app_login_new')]
    public function newUser(Request $request,EntityManagerInterface $Manager,UserPasswordHasherInterface $passwordHasher,ValidatorInterface $validator, AuthenticationUtils $authenticationUtils)
    {
        $user =new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted()){  
            $error=$validator->validate($user);
            if ($error->count() <= 0) {
                $user->setRoles([]);
                $user->setPassword($passwordHasher->hashPassword ($user, $user->getPassword()));
                $Manager->persist($user);
                $Manager->flush();
                $this->addFlash('success','félicitation, vous avez créé un compte : <b>'.$user->getUsername()."</b>");
                return $this->redirectToRoute('app_menu');
            } 
            else {
                    foreach ($error as $violation) {
                        $this->addFlash('error',$violation->getMessage());
                    }
            }   
        }
        return $this->render('security/new.html.twig',[
            'form' => $form->createView()
        ]);        
    }
}
