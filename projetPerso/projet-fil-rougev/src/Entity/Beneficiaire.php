<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BeneficiaireRepository")
 */
class Beneficiaire
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
    private $numbenef;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adressebenef;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomcompletbenef;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="benef")
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

    public function getNumbenef(): ?int
    {
        return $this->numbenef;
    }

    public function setNumbenef(int $numbenef): self
    {
        $this->numbenef = $numbenef;

        return $this;
    }

    public function getAdressebenef(): ?string
    {
        return $this->adressebenef;
    }

    public function setAdressebenef(?string $adressebenef): self
    {
        $this->adressebenef = $adressebenef;

        return $this;
    }

    public function getNomcompletbenef(): ?string
    {
        return $this->nomcompletbenef;
    }

    public function setNomcompletbenef(string $nomcompletbenef): self
    {
        $this->nomcompletbenef = $nomcompletbenef;

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
            $transaction->setBenef($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getBenef() === $this) {
                $transaction->setBenef(null);
            }
        }

        return $this;
    }
}
