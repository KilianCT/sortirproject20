<?php

namespace App\Controller;

use App\Repository\EtatRepository;
use App\Repository\SitesRepository;
use App\Repository\SortieRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class HomeController  extends AbstractController
{

    /**
     * @Route(name="home", path="/", methods={"GET"})
     */
    public function home(SortieRepository  $sortieRepository, SitesRepository $sitesRepository, Request $request)
    {
            $sites = $sitesRepository->findAll();
            $sorties = $sortieRepository->findAll();

        return $this->render('main/home.html.twig', [
            'sorties' => $sorties,
            'sites' => $sites,
            'isOrganisateur' => false,
            'isInscrit' => false,
            'isNotInscrit' => false,
            'isSortiePasse' => false,
        ]);

    }

    /**
     * @Route(name="homePost", path="/post/", methods={"POST"})
     */
    public function homePost(SortieRepository  $sortieRepository, SitesRepository $sitesRepository, Request $request, UserInterface $user, EtatRepository $etatRepository)
    {
            $utilisateur = $user;
            $sites = $sitesRepository->findAll();
            $nomChoisi = $request->get('recherche');
            $siteChoisi = (int)$request->get('selectSite');
            if ($request->get('dateMin') != null){
                $dateMin = $request->get('dateMin');
            }else{
                $dateMin = Date_format(Date_create("2020/01/01 00:00:00"), "Y/m/d H:i:s");
            }
            if ($request->get('dateMax') != null){
                $dateMax = $request->get('dateMax');
            }else{
                $dateMax = Date_format(Date_create("2122/05/19 18:31:27"), "Y/m/d H:i:s");
            }

            $isOrganisateur = (boolean)$request->get('organisateur');
            $isInscrit = (boolean)$request->get('participantInscrit');
            $isNotInscrit = (boolean)$request->get('participantPasInscrit');
            $isSortiePasse = (boolean)$request->get('sortiePasse');
            $etat = $etatRepository->find(5);

        $sorties = $sortieRepository->findByChamps($nomChoisi, $siteChoisi, $dateMin, $dateMax, $utilisateur, $isOrganisateur, $isSortiePasse, $etat);

        return $this->render('main/home.html.twig', [
            'sorties' => $sorties,
            'sites' => $sites,
            'isOrganisateur' => $isOrganisateur,
            'isInscrit' => $isInscrit,
            'isNotInscrit' => $isNotInscrit,
            'isSortiePasse' => $isSortiePasse,
            'recherche' => $nomChoisi,
            'dateMin' => $dateMin,
            'dateMax' => $dateMax,
        ]);



    }


}