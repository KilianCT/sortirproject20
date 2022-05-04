<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Site;
use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use App\Repository\SitesRepository;
use App\Security\AppUserAuthAuthenticator;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

/**
 * @Route("/participant")
 */
class ParticipantController extends AbstractController
{
    /**
     * @Route("/", name="app_participant_index", methods={"GET"})
     */
    public function index(ParticipantRepository $participantRepository): Response
    {
        return $this->render('participant/index.html.twig', [
            'participants' => $participantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_participant_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ParticipantRepository $participantRepository, UserPasswordHasherInterface $userPasswordHasher , AppUserAuthAuthenticator $authenticator, UserAuthenticatorInterface $userAuthenticator, SitesRepository $sitesRepository): Response
    {

        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant,['type' => 'create']);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('photoUrl')->getData() != null) {

                $file = $form->get('photoUrl')->getData();

                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move($this->getParameter('users_photos_directory'), $fileName);

                $participant->setPhotoUrl($fileName);

            }
        }



        if ($form->isSubmitted() && $form->isValid()) {
            $participant->setAdministrateur(false);
            $participant->setActif(true);
            $participant->setPassword($userPasswordHasher->hashPassword($participant, $participant->getPassword()));
            $idSiteSelected = (int) $request->get('selectSite');
            $participant->setSiteNoSite($sitesRepository->find($idSiteSelected));
            $participantRepository->add($participant);
            $this->addFlash('success', 'profile créé');

            return $userAuthenticator->authenticateUser($participant, $authenticator, $request);

        }



        return $this->renderForm('participant/new.html.twig', [
            'participant' => $participant,
            'id' => $participant->getId(),
            'form' => $form,
            'sites' => $sitesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_participant_show", methods={"GET"})
     */
    public function show(Participant $participant): Response
    {
        return $this->render('participant/show.html.twig', [
            'participant' => $participant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_participant_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Participant $participant, ParticipantRepository $participantRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(ParticipantType::class, $participant,['type' => 'edit']);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('photoUrl')->getData() != null) {

                $file = $form->get('photoUrl')->getData();

                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move($this->getParameter('users_photos_directory'), $fileName);

                $participant->setPhotoUrl($fileName);

            }
        }

            if ($form->isSubmitted() && $form->isValid()) {
                $participantRepository->add($participant);

                return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
            }


            return $this->renderForm('participant/edit.html.twig', [
                'participant' => $participant,
                'form' => $form,
                'var' => true,
            ]);

        }

    /**
     * @Route("/{id}", name="app_participant_delete", methods={"POST"})
     */
    public function delete(Request $request, Participant $participant, ParticipantRepository $participantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participant->getId(), $request->request->get('_token'))) {
            $participantRepository->remove($participant);
        }

        return $this->redirectToRoute('app_participant_index', [], Response::HTTP_SEE_OTHER);
    }



    /**
     * @Route("Admin/{id}", name="app_participant_devenirAdmin", methods={"GET", "POST"})
     */
    public function devenirAdmin(Request $request, Participant $participant, ParticipantRepository $participantRepository): Response
    {
            $participant = $participantRepository->find($request->get('id'));
            $participant->setAdministrateur(true);
            $participantRepository->add($participant);


        return $this->redirectToRoute('app_participant_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/reset_password", name="app_reset_password", methods={"GET", "POST"})
     */

    public function editPassword(Request $request, Participant $participant, ParticipantRepository $participantRepository, UserPasswordHasherInterface $userPasswordHasher){

        $form = $this->createForm(ParticipantType::class, $participant,['type' => 'passwordEdit']);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $participant->setPassword($userPasswordHasher->hashPassword($participant, $participant->getPassword()));
            $participantRepository->add($participant);
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }



        return $this->renderForm('participant/edit.html.twig', [
            'participant' => $participant,
            'form' => $form,
            'var' => false,

        ]);


    }






}
