<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController  extends AbstractController
{

    /**
     * @Route(name="home", path="", methods={"GET"})
     */
    public function home() {
        return $this->render('main/home.html.twig');
    }

    /**
     * @Route(name="AccueilConnecter", path="" method="GET")
     */
    public function AccueilConnecter() {
        return $this->render('main/Accueil-Connnecter.html.twig');
    }




    /**
     * @Route(name="Connection", path="" method="GET")
     */
    public function Connection() {
        return $this->render('main/Connection.html.twig');
    }
    /**
     * @Route(name="Inscription", path="" method="GET")
     */
    public function Inscription() {
        return $this->render('main/Inscription.html.twig');
    }
    /**
     * @Route(name="TraitementInscription", path="" method="GET")
     */
    public function TraitementInscription() {
        return $this->render('main/TraitementInscription.html.twig');
    }



    /**
     * @Route(name="TraitementConnection", path="" method="POST")
     */
    public function TraitementConnection() {
        return $this->render('main/Traitement_Connection.html.twig');
    }
    /**
     * @Route(name="Profil", path="" method="GET")
     */
    public function Profil() {
        return $this->render('main/Profil.html.twig');
    }

    /**
     * @Route(name="ModifProfil", path="" method="POST")
     */
    public function ModifProfil() {
        return $this->render('main/Modif-Profil.html.twig');
    }

    /**
     * @Route(name="admin/Gerer-les-villes", path="" method="GET")
     */
    public function Ville() {
        return $this->render('main/Gerer-les-Ville.html.twig');
    }
    /**
     * @Route(name="admin/Gerer-les-sites", path="" method="GET")
     */
    public function Site() {
        return $this->render('main/Gerer-les-sites.html.twig');
    }




}