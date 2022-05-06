<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Repository\EtatRepository;
use App\Repository\HistoriqueRepository;
use App\Repository\SitesRepository;
use App\Repository\SortieRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use app\Entity\Etat;
use app\Entity\sortie;

class HomeController  extends AbstractController
{

    /**
     * @Route(name="home", path="/", methods={"GET"})
     * * @throws \Exception
     */
    public function home(SortieRepository  $sortieRepository, SitesRepository $sitesRepository, Request $request, EtatRepository $etatRepository, HistoriqueRepository $historiqueRepository)
    {
            $sites = $sitesRepository->findAll();
            $sorties = $sortieRepository->findAll();

        $sql = " SELECT * FROM `sortie` ORDER BY `sortie`.`date_heure_debut` DESC";
        

        $date = date_create('now');
        setlocale(LC_TIME, 'fra_fra');
        $dateAfficher =  strftime('%d %B %Y | %H:%M:%S');

        for($i=0; $i<count($sorties);$i++){
            // if($sorties[$i]->getIdEtat() != 1) {
            $dateformatInscriptionFin = $sorties[$i]->getDateLimiteInscription();
            $datefinInsc=date_diff($date,$dateformatInscriptionFin);
            $dateformatActiv = $sorties[$i]->getDateHeureDebut();
            $datedebutActiv=date_diff($date,$dateformatActiv);
            $datefinActiv = $dateformatActiv;
            $datedébutSortie = $sorties[$i]->getDateHeureDebut();
            $datefinActiv->add(new \DateInterval('PT'. $sorties[$i]->getDuree().'M'));
            $dateduree=date_diff($date,$dateformatActiv);
            $finpasse = $dateformatActiv->add(new \DateInterval('P1M'));
            $finpassediff = date_diff($date,$finpasse);
            if (($datefinInsc->invert == 1) and ($sorties[$i]->getIdEtat()->getId()!=6)) {
                $sorties[$i]->setIdEtat($etatRepository->find(3));
                $sortieRepository->add($sorties[$i]);
            }
            if (($datedebutActiv->invert == 1) and ($sorties[$i]->getIdEtat()->getId()!=6)){
                $sorties[$i]->setIdEtat($etatRepository->find(4));
                $sortieRepository->add($sorties[$i]);
            }
            if (($dateduree->invert == 1) and ($sorties[$i]->getIdEtat()->getId()!=6)){
                $sorties[$i]->setIdEtat($etatRepository->find(5));
                $sortieRepository->add($sorties[$i]);
            }
            if ($finpassediff->invert == 1) {

                $historique = new Historique();
                $historique->setIdSortie($sorties[$i]->getId());
                $historique->setNomSortie($sorties[$i]->getNom());
                $historique->setDateDebutSortie($sorties[$i]->getDateHeureDebut());
                $historique->setDureeSortie($sorties[$i]->getDuree());
                $historique->setNomLieu($sorties[$i]->getLieuxNoLieux()->getNom());

                $organisateur = $sorties[$i]->getOrganisateur();

                $historique->setIdOrganisateur($organisateur->getId());
                $historique->setPseudo($organisateur->getPseudo());
                $historique->setNomOrganisateur($organisateur->getNom());
                $historique->setPrenom($organisateur->getPrenom());
                $historique->setTelephoneOrganisateur($organisateur->getTelephone());
                $historique->setEmailOrganisateur($organisateur->getEmail());


                $historiqueRepository->add($historique);

                $sortieRepository->remove($sortieRepository->find($sorties[$i]->getId()));



            }







            //  }



        }







        //for($i=0; $i<count($sorties);$i++){



        //if($sorties[$i]->getIdEtat() != 1) {



        //     $dateformatActiv = $sorties[$i]->getDateHeureDebut();



        //  $datedebutActiv=date_diff($dateformatActiv,$date);



        //    if ($datedebutActiv ) {



        //       $sorties[$i]->setIdEtat($etatRepository->find(4));



        //        $sortieRepository->add($sorties[$i]);



        //   }



        //}



        //  }


        $AnnulerRecherche = false;
        $rechercher = true;
        return $this->render('main/home.html.twig', [
            'sorties' => $sorties,
            'sites' => $sites,
            'isOrganisateur' => false,
            'isInscrit' => false,
            'isNotInscrit' => false,
            'isSortiePasse' => false,
            'dateAfficher' => $dateAfficher,
            'AnnulerRecherche' => $AnnulerRecherche,
            'rechercher' => $rechercher,
        ]);

    }

    /**
     * @Route(name="homePost", path="/post/", methods={"POST"})
     */
    public function homePost(SortieRepository  $sortieRepository, SitesRepository $sitesRepository, Request $request, UserInterface $user, EtatRepository $etatRepository)
    {
            //$sorties = $sortieRepository->findAll();
            $date = date_create('now');
            setlocale(LC_TIME, 'fra_fra');
            $dateAfficher =  strftime('%d %B %Y | %H:%M:%S');
            $utilisateur = $user;
            $sites = $sitesRepository->findAll();
            $recherche= $request->get('recherche');
            $siteChoisi = (int)$request->get('selectSite');
            $siteChoisiObjet= $sitesRepository->find($siteChoisi);
            if ($request->get('dateMin') != null){
                $dateMin = $request->get('dateMin');
            }else{
                $dateMin = Date_format(Date_create("2000/01/01 00:00:00"), "Y/m/d H:i:s");
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

        $sorties = $sortieRepository->findBySite($siteChoisiObjet, $recherche, $dateMin, $dateMax);
        $sortiesApresFiltre = [];

        if($isOrganisateur){
            for($i=0; $i < count($sorties); $i++){
                if($sorties[$i]->getOrganisateur()->getId() == $utilisateur->getId()){
                    $sortiesApresFiltre[] = $sorties[$i];
                }
            }
        }else{
            $sortiesApresFiltre = $sorties;
        }

        $sorties = $sortiesApresFiltre;

        $sortiesApresFiltre2 = [];

        if ($isSortiePasse) {
            for ($y = 0; $y < count($sortiesApresFiltre); $y++) {
                if ($sortiesApresFiltre[$y]->getIdEtat()->getId() == 5) {
                    $sortiesApresFiltre2[] = $sortiesApresFiltre[$y];
                }
            }
        }else{
                $sortiesApresFiltre2 = $sortiesApresFiltre;
            }

        $sorties = $sortiesApresFiltre2;

        ##dd($sortiesApresFiltre, $sortiesApresFiltre2);
        $AnnulerRecherche = true;
        $rechercher = false;
        return $this->render('main/home.html.twig', [
            'sorties' => $sorties,
            'sites' => $sites,
            'isOrganisateur' => $isOrganisateur,
            'isInscrit' => $isInscrit,
            'isNotInscrit' => $isNotInscrit,
            'isSortiePasse' => $isSortiePasse,
            'recherche' => $recherche,
            'dateMin' => $dateMin,
            'dateMax' => $dateMax,
            'siteChoisi' => $siteChoisi,
            'dateAfficher' => $dateAfficher,
            'AnnulerRecherche' => $AnnulerRecherche,
            'rechercher' => $rechercher,
        ]);



    }


}