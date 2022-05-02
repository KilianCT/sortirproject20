<?php

namespace App\Controller;

use App\Repository\SitesRepository;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController  extends AbstractController
{

    /**
     * @Route(name="home", path="/", methods={"GET"})
     */
    public function home(SortieRepository  $sortieRepository, SitesRepository $sitesRepository)
    {





        return $this->render('main/home.html.twig', [
            'sorties' => $sortieRepository->findAll(),
            'sites' => $sitesRepository->findAll(),
        ]);



    }


}