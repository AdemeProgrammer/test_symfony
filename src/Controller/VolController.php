<?php

namespace App\Controller;

use App\Entity\Vol;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VolController extends AbstractController
{
    #[Route('/vol/{ajout}', name: 'vol_ajout')]
    public function ajoutVol(EntityManagerInterface $entityManager): Response
    {
        $vol = new Vol();
        $vol -> setVilleDepart("Paris");
        $vol ->setVilleArrive("Malaga");
        $vol -> setDateDepart(New \DateTime("now"));
        $vol -> setHeureDepart(New \DateTime("now"));
        $vol -> setPrixBilletInitial(200);

        $entityManager->persist($vol);
        $entityManager->flush();
        $entityManager->refresh($vol);

        dump($vol);

        return $this->render('vol/ajoutVol.html.twig', [
            'controller_name' => 'VolController',
            'vol' => $vol
        ]);
    }
    #[Route('/vol/{id}', name: 'vol_detail')]
    public function detail(int $id): Response
    {
        return $this->render('vol/detail.html.twig', [
            'controller_name' => 'VolController',
            'id' => $id,
        ]);
    }

    #[Route('/vol', name: 'app_vol')]
    public function index(): Response
    {
        return $this->render('vol/index.html.twig', [
            'controller_name' => 'VolController',
        ]);
    }
}
