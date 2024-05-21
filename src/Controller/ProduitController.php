<?php

namespace App\Controller;

use App\Form\ProduitType;
use App\Entity\Produit;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProduitController extends AbstractController
{
    #[Route('/produit',name:'app_produit')]
    public function index (EntityManagerInterface $entityManager)
    {
        $produits = $entityManager->getRepository(Produit::class)->findAll();
        return $this->render('produits/index.html.twig',['produits'=>$produits]);        
    }


    #[Route('/produit/new',name:'app_produit_new')]
    public function new(Request $request,EntityManagerInterface $Manager)
    {
        $produit =new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){   
            $Manager->persist($produit);
            $Manager->flush();
            $this->addFlash('success','félicitation, vous avez créé un produit : <b>'.$produit->getNom()."</b>");
            return $this->redirectToRoute('app_produit');
        }

        return $this->render('produits/new.html.twig',[
            'form' => $form->createView()
        ]);        
    }

    #[Route('/produit/{id}',name:'app_produit_show')]
    public function show ($id,EntityManagerInterface $entityManager)
    {
        $produits = $entityManager->getRepository(Produit::class)->findOneBy(['id'=>$id]);
        if($produits == NULL){
            return $this->redirectToRoute('app_produit');
        }
        return $this->render('produits/show.html.twig',[
            'produits'=>$produits
        ]);        
    }

}
   
    
