<?php

namespace App\Entity;

use App\Repository\HistoriqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoriqueRepository::class)
 */
class Historique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_sortie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_sortie;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebutSortie;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dureeSortie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomLieu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $id_organisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_organisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone_organisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email_organisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdSortie(): ?int
    {
        return $this->id_sortie;
    }

    public function setIdSortie(int $id_sortie): self
    {
        $this->id_sortie = $id_sortie;

        return $this;
    }

    public function getNomSortie(): ?string
    {
        return $this->nom_sortie;
    }

    public function setNomSortie(string $nom_sortie): self
    {
        $this->nom_sortie = $nom_sortie;

        return $this;
    }

    public function getDateDebutSortie(): ?\DateTimeInterface
    {
        return $this->dateDebutSortie;
    }

    public function setDateDebutSortie(\DateTimeInterface $dateDebutSortie): self
    {
        $this->dateDebutSortie = $dateDebutSortie;

        return $this;
    }

    public function getDureeSortie(): ?int
    {
        return $this->dureeSortie;
    }

    public function setDureeSortie(?int $dureeSortie): self
    {
        $this->dureeSortie = $dureeSortie;

        return $this;
    }

    public function getNomLieu(): ?string
    {
        return $this->nomLieu;
    }

    public function setNomLieu(string $nomLieu): self
    {
        $this->nomLieu = $nomLieu;

        return $this;
    }

    public function getIdOrganisateur(): ?string
    {
        return $this->id_organisateur;
    }

    public function setIdOrganisateur(string $id_organisateur): self
    {
        $this->id_organisateur = $id_organisateur;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getNomOrganisateur(): ?string
    {
        return $this->nom_organisateur;
    }

    public function setNomOrganisateur(string $nom_organisateur): self
    {
        $this->nom_organisateur = $nom_organisateur;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephoneOrganisateur(): ?string
    {
        return $this->telephone_organisateur;
    }

    public function setTelephoneOrganisateur(string $telephone_organisateur): self
    {
        $this->telephone_organisateur = $telephone_organisateur;

        return $this;
    }

    public function getEmailOrganisateur(): ?string
    {
        return $this->email_organisateur;
    }

    public function setEmailOrganisateur(string $email_organisateur): self
    {
        $this->email_organisateur = $email_organisateur;

        return $this;
    }
}
