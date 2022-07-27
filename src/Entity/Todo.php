<?php

namespace App\Entity;

use App\Repository\TodoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TodoRepository::class)]
class Todo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $todo;

    #[ORM\Column(type: 'string', length: 255)]
    private string $by;

    #[ORM\Column(type: 'boolean', nullable: false)]
    private bool $isdone;

    public function __construct(?int $id, ?string $todo, ?string $by, ?bool $isdone) {
        $this->id = $id;
        $this->todo = $todo;
        $this->by = $by;
        $this->isdone = $isdone;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTodo(): ?string
    {
        return $this->todo;
    }

    public function setTodo(string $todo): self
    {
        $this->todo = $todo;

        return $this;
    }

    public function getBy(): ?string
    {
        return $this->by;
    }

    public function setBy(string $by): self
    {
        $this->by = $by;

        return $this;
    }

    public function getIsdone(): bool
    {
        return $this->isdone;
    }

    public function setIsdone(bool $isdone): self
    {
        $this->isdone = $isdone;

        return $this;
    }
}