<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'attr'=> ['class'=>'form-controller','placeholder'=>"Nom du produit"]
            ])
            ->add('description', TextareaType::class,[
                'attr'=> ['class'=>'form-controller','placeholder'=>"Description du produit"]
            ])
            ->add('prix', NumberType::class,[
                'attr'=> ['class'=>'form-controller','placeholder'=>"Prix du produit"]
            ])
            ->add('quantite', NumberType::class,[
                'attr'=> ['class'=>'form-controller','placeholder'=>"Quantié du produit"]
            ])
            ->add('img', TextareaType::class,[
                'attr'=> ['class'=>'form-controller','placeholder'=>"liens image (optionnel)"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
