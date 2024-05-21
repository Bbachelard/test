<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\PasswordUserType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController{


    #[Route('/compte', name: 'app_compte')]
    public function index(EntityManagerInterface $entityManager)
    {
        /*$user =$entityManager->getRepository(User::class)->findOneBy;
        if($user == NULL){
            return $this->redirectToRoute('app_menu');
        }*/
        return $this->render('account/index.html.twig',['user'=>$user]);
    }

    #[Route('/compte/modifier-mot-de-passe', name:'app_compte_modify_pwd')]
    public function password(Request $request,UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $Manager){
        $user=$this->getUser();
        $form = $this->createForm(PasswordUserType::class ,$user,[
            'passwordhasher'=>$passwordHasher
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $Manager->flush();
            $this->addFlash('success','félicitation <b>'.$user->getUsername()."</b>, vous avez modifier votre mot de passe ");
        }
        return $this->render('account/password.html.twig',[
            'modifyPwd'=>$form->createView()
        ]);
    }

}