<?php

namespace App\Entity;

use App\Validation\Exception\InvalidNameAdditionException;
use App\Validation\Exception\InvalidTitleException;
use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $nameAddition = null;

    #[ORM\ManyToOne(inversedBy: 'persons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Room $room = null;

    public function __construct(
        #[ORM\Column(length: 255)]
        private readonly string $firstname,
        #[ORM\Column(length: 255)]
        private readonly string $lastname,
        #[ORM\Column(length: 255)]
        private readonly string $username
    )
    {
    }

    #[ArrayShape(['firstname' => "", 'lastname' => "", 'title' => "", 'nameAddition' => "", 'username' => ""])]
    public function jsonSerialize(): array
    {
        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'title' => $this->title,
            'nameAddition' => $this->nameAddition,
            'username' => $this->username
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        if ($title !== "Dr.") {
            throw new InvalidTitleException();
        }

        $this->title = $title;

        return $this;
    }

    public function getNameAddition(): ?string
    {
        return $this->nameAddition;
    }

    public function setNameAddition(?string $nameAddition): self
    {
        if ($nameAddition !== "van" && $nameAddition !== "von" && $nameAddition !== "de") {
            throw new InvalidNameAdditionException();
        }

        $this->nameAddition = $nameAddition;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }
}
