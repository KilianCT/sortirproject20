<?php

namespace App\Controller;



use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SitesRepository;
use App\Repository\SortieRepository;

use App\Entity\Participant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sortie")
 */
class SortieController extends AbstractController
{
    /**
     * @Route("/", name="app_sortie_index", methods={"GET"})
     */
    public function index(SortieRepository $sortieRepository): Response
    {
        return $this->render('sortie/index.html.twig', [
            'sorties' => $sortieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_sortie_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SortieRepository $sortieRepository, SitesRepository $sitesRepository, LieuRepository $lieuRepository, EtatRepository $etatRepository, ParticipantRepository $participantRepository): Response
    {
        $sortie = new Sortie();
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $sortie->setIdEtat(($etatRepository->find(1)));
            $sortie->setOrganisateur($participantRepository->find((int)$request->get('id')));
            $sortie->setLieuxNoLieux($lieuRepository->find((int)$request->get('selectLieux')));
            $sortie->setSiteNoSite($sitesRepository->find((int)$request->get('selectSite')));

            $sortieRepository->add($sortie);
            $this->addFlash('success', 'sortit créé');
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }




        return $this->renderForm('sortie/new.html.twig', [
            'sortie' => $sortie,
            'form' => $form,
            'sites' => $sitesRepository->findAll(),
            'lieux' => $lieuRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="app_sortie_show", methods={"GET"})
     */
    public function show(Sortie $sortie): Response
    {



        return $this->render('sortie/show.html.twig', [
            'sortie' => $sortie,

        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_sortie_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Sortie $sortie, SortieRepository $sortieRepository): Response
    {
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sortieRepository->add($sortie);
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sortie/edit.html.twig', [
            'sortie' => $sortie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_sortie_delete", methods={"POST"})
     */
    public function delete(Request $request, Sortie $sortie, SortieRepository $sortieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sortie->getId(), $request->request->get('_token'))) {
            $sortieRepository->remove($sortie);
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/Annuler/{idSortie}", name="app_sortie_Annuler", methods={"GET", "POST"})
     */
    public function Annuler(Request $request, SortieRepository $sortieRepository, EtatRepository $etatRepository) {


        $sortie = $sortieRepository->find((int)$request->get('idSortie'));

        $sortie->setIdEtat($etatRepository->find(6));
        $sortieRepository->add($sortie);

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/inscription/{idSortie}/{idParticipant}", name="app_sortie_inscription",methods={"GET", "POST"})
     *
     */
    public function inscription(Request $request, SortieRepository $sortieRepository, ParticipantRepository $participantRepository): Response
    {


        $sortie = $sortieRepository->find((int)$request->get('idSortie'));
        $participant = $participantRepository->find($request->get('idParticipant'));

        $sortie->addParticipant($participant);
        $sortie->addParticipantNoParticipant($participant);

        $sortieRepository->add($sortie);




        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER );
    }

    /**
     * @Route("/publier/{idSortie}", name="app_sortie_publier",methods={"GET", "POST"})
     *
     */
        public function publier(Request $request, SortieRepository $sortieRepository, EtatRepository $etatRepository) {


            $sortie = $sortieRepository->find((int)$request->get('idSortie'));

            $sortie->setIdEtat($etatRepository->find(2));
            $sortieRepository->add($sortie);

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }



    /**
     * @Route("/desinscription/{idSortie}/{idParticipant}", name="app_sortie_desinscription",methods={"GET", "POST"})
     *
     */
    public function desinscription(Request $request, SortieRepository $sortieRepository, ParticipantRepository $participantRepository): Response
    {


        $sortie = $sortieRepository->find((int)$request->get('idSortie'));
        $participant = $participantRepository->find($request->get('idParticipant'));

        $sortie->removeParticipant($participant);
        $sortie->removeParticipantNoParticipant($participant);

        $sortieRepository->add($sortie);



        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/recherche", name="app_sortie_recherche",methods={"GET", "POST"})
     *
     */
    public function recherche(Request $request, SortieRepository $sortieRepository, ParticipantRepository $participantRepository, SitesRepository $sitesRepository, Site $site): Response
    {

       $site = $sitesRepository->find((int)$request->get('selectSite'));
       $dateDebut = $request->get('dateDebut');
       $dateFin = $request->get('dateFin');
       $recherche  = $request->get('recherche');


        return $this->render('main/home.html.twig', [
            'site' => $site,
            'dateDebut'=>$dateDebut,
            'dateFin'=>$dateFin,
            'recherche'=> $recherche,

        ]);
    }


    }
