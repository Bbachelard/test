<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class,[
                'attr'=> ['class'=>'form-control','placeholder'=>"username"]
            ])
            ->add('email', EmailType::class,[
                'attr'=> ['class'=>'form-control','placeholder'=>"email"]
            ])
            ->add('password',PasswordType::class,[
                'attr'=> ['class'=>'form-control','placeholder'=>"mot de passe"]
            ])
            ->add('passwordConfirm',PasswordType::class,[
                'attr'=> ['class'=>'form-control','placeholder'=>"confirmation du mot de passe"],
                'propertyPath'=>'password'
            ])
            ->add('tel', NumberType::class,[
                'attr'=> ['class'=>'form-control','placeholder'=>"tel"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
