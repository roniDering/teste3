<?php

namespace App\Entity;

use App\Repository\ContatoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContatoRepository::class)
 */
class Contato
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *  @var bool
     * @ORM\Column(type="boolean")
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descricao;

    /**
     * @ORM\ManyToOne(targetEntity=Pessoa::class, inversedBy="contatos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idPessoa;  //fk de contato para pessoas e acima é o mapeaneto


    /**
     * @ORM\PrePersist()
     */
    public function PrePersist()
    {
        $this->tipo= (bool)$this->tipo; //passa pra boolean 
    }
    
    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->tipo = (bool) $this->tipo;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?bool
    {
        return $this->tipo;
    }

    public function setTipo(bool $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getIdPessoa(): ?Pessoa
    {
        return $this->idPessoa;
    }

    public function setIdPessoa(?Pessoa $idPessoa): self
    {
        $this->idPessoa = $idPessoa;

        return $this;
    }
}
