<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\EnvoyerRepository")
 */
class Envoyer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomcomplet;

    /**
     * @ORM\Column(type="integer")
     */
    private $numenvoyeur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adressenv;

    /**
     * @ORM\Column(type="integer")
     */
    private $numcnienv;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="envoyeur", orphanRemoval=true)
     */
    private $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomcomplet(): ?string
    {
        return $this->nomcomplet;
    }

    public function setNomcomplet(string $nomcomplet): self
    {
        $this->nomcomplet = $nomcomplet;

        return $this;
    }

    public function getNumenvoyeur(): ?int
    {
        return $this->numenvoyeur;
    }

    public function setNumenvoyeur(int $numenvoyeur): self
    {
        $this->numenvoyeur = $numenvoyeur;

        return $this;
    }

    public function getAdressenv(): ?string
    {
        return $this->adressenv;
    }

    public function setAdressenv(?string $adressenv): self
    {
        $this->adressenv = $adressenv;

        return $this;
    }

    public function getNumcnienv(): ?int
    {
        return $this->numcnienv;
    }

    public function setNumcnienv(int $numcnienv): self
    {
        $this->numcnienv = $numcnienv;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setEnvoyeur($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getEnvoyeur() === $this) {
                $transaction->setEnvoyeur(null);
            }
        }

        return $this;
    }
}
