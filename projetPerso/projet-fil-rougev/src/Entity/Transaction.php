<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numerotrans;

    /**
     * @ORM\Column(type="integer")
     */
    private $montanttrans;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datedenvoie;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $delairetrait;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateretrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Envoyer", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $envoyeur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Beneficiaire", inversedBy="transactions")
     */
    private $benef;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CompteBancaire", inversedBy="transactions")
     */
    private $compte;

    /**
     * @ORM\Column(type="integer")
     */
    private $codedenvoie;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Retrait", mappedBy="envoie", cascade={"persist", "remove"})
     */
    private $retrait;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumerotrans(): ?int
    {
        return $this->numerotrans;
    }

    public function setNumerotrans(int $numerotrans): self
    {
        $this->numerotrans = $numerotrans;

        return $this;
    }

    public function getMontanttrans(): ?int
    {
        return $this->montanttrans;
    }

    public function setMontanttrans(int $montanttrans): self
    {
        $this->montanttrans = $montanttrans;

        return $this;
    }

    public function getDatedenvoie(): ?\DateTimeInterface
    {
        return $this->datedenvoie;
    }

    public function setDatedenvoie(\DateTimeInterface $datedenvoie): self
    {
        $this->datedenvoie = $datedenvoie;

        return $this;
    }

    public function getDelairetrait(): ?\DateTimeInterface
    {
        return $this->delairetrait;
    }

    public function setDelairetrait(?\DateTimeInterface $delairetrait): self
    {
        $this->delairetrait = $delairetrait;

        return $this;
    }

    public function getDateretrait(): ?\DateTimeInterface
    {
        return $this->dateretrait;
    }

    public function setDateretrait(?\DateTimeInterface $dateretrait): self
    {
        $this->dateretrait = $dateretrait;

        return $this;
    }

    public function getEnvoyeur(): ?Envoyer
    {
        return $this->envoyeur;
    }

    public function setEnvoyeur(?Envoyer $envoyeur): self
    {
        $this->envoyeur = $envoyeur;

        return $this;
    }

    public function getBenef(): ?Beneficiaire
    {
        return $this->benef;
    }

    public function setBenef(?Beneficiaire $benef): self
    {
        $this->benef = $benef;

        return $this;
    }

    public function getCompte(): ?CompteBancaire
    {
        return $this->compte;
    }

    public function setCompte(?CompteBancaire $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getCodedenvoie(): ?int
    {
        return $this->codedenvoie;
    }

    public function setCodedenvoie(int $codedenvoie): self
    {
        $this->codedenvoie = $codedenvoie;

        return $this;
    }

    public function getRetrait(): ?Retrait
    {
        return $this->retrait;
    }

    public function setRetrait(Retrait $retrait): self
    {
        $this->retrait = $retrait;

        // set the owning side of the relation if necessary
        if ($this !== $retrait->getEnvoie()) {
            $retrait->setEnvoie($this);
        }

        return $this;
    }
}
