<?php
namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/',name:'app_menu')]
    public function menu (LoggerInterface $logger)
    {
        $logger->info('bonjour cest une info');
        return $this->render('main.html.twig');

    }

    #[Route('/contact',name:'app_contact')]
    public function contact ()
    {
        return $this->render('contact.html.twig');
    }
    
    #[Route('/location',name:'app_location')]
    public function location ()
    {
        return $this->render('location.html.twig');

    }
   
    

}