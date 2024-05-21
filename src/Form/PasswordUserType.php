<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Actualpassword',PasswordType::class,[
                'attr'=> ['class'=>'form-control','placeholder'=>"mot de passe Actuel"],
                'mapped' => false
            ])
            ->add('passwordCo',RepeatedType::class,[
                'type'=>PasswordType::class,
                'first_options'=>[
                    'label'=>'Votre nouveau mot de passe',
                    'attr'=> ['class'=>'form-control','placeholder'=>"Nouveau mot de passe"],
                ],
                'second_options'=>[
                    'attr'=> ['class'=>'form-control','placeholder'=>"confirmation du nouveau mot de passe"],
                ],
                'mapped' => false
                ])
            ->add('submit',SubmitType::class,[
                'label'=>"mettre a jour mot de passe",
                'attr'=> ['class'=>'btn btn-success']
            ])
            ->addEventListener(FormEvents::SUBMIT, function(FormEvent $event){
                $form=$event->getForm();
                $user=$form->getConfig()->getOptions()['data'];
                $passwordHasher=$form->getConfig()->getOptions()['passwordhasher'];
                $actualPwd=$form->get('Actualpassword')->getData();
                $newPwd=$form->get('passwordCo')->getData();
                $user->setPasswordConfirm($newPwd);

                $isValid =$passwordHasher->isPasswordValid(
                    $user,
                    $actualPwd
                );
                if(!$isValid){
                    $form->get('Actualpassword')->addError(new FormError('Votre mot de passe ne corespond pas'));
                }
                else{
                    $user->setPassword($passwordHasher->hashPassword ($user, $newPwd));
                }

                //if($actualPwd==$actualPwdBdd){}
                
            })
    
        
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordhasher'=> null
        ]);
    }
}
