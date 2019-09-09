<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RetraitRepository")
 */
class Retrait
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateretrait;

    /**
     * @ORM\Column(type="integer")
     */
    private $codedenvoie;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Transaction", inversedBy="retrait", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $envoie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="retraits")
     * @ORM\JoinColumn(nullable=false)
     */
   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateretrait(): ?\DateTimeInterface
    {
        return $this->dateretrait;
    }

    public function setDateretrait(\DateTimeInterface $dateretrait): self
    {
        $this->dateretrait = $dateretrait;

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

    public function getEnvoie(): ?Transaction
    {
        return $this->envoie;
    }

    public function setEnvoie(Transaction $envoie): self
    {
        $this->envoie = $envoie;

        return $this;
    }

    
}
