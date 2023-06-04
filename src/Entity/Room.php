<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use App\Validation\RoomNumberValidator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: Person::class)]
    private Collection $persons;

    public function __construct(
        #[ORM\Column(length: 4)]
        private readonly string $number
    )
    {
        $validator = new RoomNumberValidator();
        $validator->validate($this->number);
        $this->persons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getPersons(): Collection
    {
        return $this->persons;
    }

    public function addPerson(Person $person): self
    {
        if (!$this->persons->contains($person)) {
            $this->persons[] = $person;
            $person->setRoom($this);
        }
        return $this;
    }

    public function removePerson(Person $person): self
    {
        // set the owning side to null (unless already changed)
        if ($this->persons->removeElement($person) && $person->getRoom() === $this) {
            $person->setRoom(null);
        }
        return $this;
    }
}
