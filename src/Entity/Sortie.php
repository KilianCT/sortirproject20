<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SortieRepository::class)
 */
class Sortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateHeureDebut;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateLimiteInscription;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbInscriptionMax;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $infosSortie;

    /**
     * @ORM\ManyToOne(targetEntity=etat::class, inversedBy="sortie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Participant::class, inversedBy="sortie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organisateur;

    /**
     * @ORM\ManyToOne(targetEntity=Lieu::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $lieux_no_lieux;

    /**
     * @ORM\ManyToOne(targetEntity=site::class)
     */
    private $site_no_site;

    /**
     * @ORM\ManyToMany(targetEntity=participant::class, inversedBy="sortie")
     */
    private $participant_no_participant;

    public function __construct()
    {
        $this->participant_no_participant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(\DateTimeInterface $dateLimiteInscription): self
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbInscriptionMax(): ?int
    {
        return $this->nbInscriptionMax;
    }

    public function setNbInscriptionMax(int $nbInscriptionMax): self
    {
        $this->nbInscriptionMax = $nbInscriptionMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(?string $infosSortie): self
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    public function getEtat(): ?etat
    {
        return $this->etat;
    }

    public function setEtat(?etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getOrganisateur(): ?Participant
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Participant $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    public function getLieuxNoLieux(): ?Lieu
    {
        return $this->lieux_no_lieux;
    }

    public function setLieuxNoLieux(?Lieu $lieux_no_lieux): self
    {
        $this->lieux_no_lieux = $lieux_no_lieux;

        return $this;
    }

    public function getSiteNoSite(): ?Site
    {
        return $this->site_no_site;
    }

    public function setSiteNoSite(?Site $site_no_site): self
    {
        $this->site_no_site = $site_no_site;

        return $this;
    }

    /**
     * @return Collection<int, participant>
     */
    public function getParticipantNoParticipant(): Collection
    {
        return $this->participant_no_participant;
    }

    public function addParticipantNoParticipant(participant $participantNoParticipant): self
    {
        if (!$this->participant_no_participant->contains($participantNoParticipant)) {
            $this->participant_no_participant[] = $participantNoParticipant;
        }

        return $this;
    }

    public function removeParticipantNoParticipant(participant $participantNoParticipant): self
    {
        $this->participant_no_participant->removeElement($participantNoParticipant);

        return $this;
    }
}
