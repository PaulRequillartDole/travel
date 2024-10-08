<?php

namespace App\Entity;

use App\Repository\VoyageRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoyageRepository::class)]
class Voyage
{
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue]
    #[ORM\Id]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private $destination;

    #[ORM\Column(type: "text", nullable: true)]
    private $description;

    #[ORM\Column(type: "date", nullable: true)]
    private $startAt;

    #[ORM\Column(type: "date", nullable: true)]
    private $endAt;

    #[ORM\ManyToOne(targetEntity: Status::class, inversedBy: "voyages")]
    private $status;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "ownedVoyages")]
    private $owner;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: "sharedVoyages")]
    private $users;

    #[ORM\Column(type: "text", nullable: true)]
    private $image;

    #[ORM\OneToMany(mappedBy: "voyage", targetEntity: Section::class)]
    private $sections;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $lon = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $lat = null;

    #[ORM\OneToMany(mappedBy: "voyage", targetEntity: Destination::class)]
    private $destinations;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $destinationType = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->sections = new ArrayCollection();
        $this->destinations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStartAt(): ?DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(?DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function duration(): int
    {
        if (null === $this->startAt || null === $this->endAt) {
            return 0;
        }
        $diff = $this->endAt->diff($this->startAt);
        return $diff->days;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
    
    /**
     * @return Collection<int, Section>
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections[] = $section;
            $section->setVoyage($this);
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->sections->removeElement($section)) {
            // set the owning side to null (unless already changed)
            if ($section->getVoyage() === $this) {
                $section->setVoyage(null);
            }
        }

        return $this;
    }

    public function getLon(): ?string
    {
        return $this->lon;
    }

    public function setLon(?string $lon): static
    {
        $this->lon = $lon;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getCoordinates(): ?string
    {
        if ($this->lon) {
            return $this->lat . ',' . $this->lon;
        }
        return null;
    }

    /**
     * @return Collection<int, Destination>
     */
    public function getDestinations(): Collection
    {
        return $this->destinations;
    }

    public function addDestination(Destination $destination): static
    {
        if (!$this->destinations->contains($destination)) {
            $this->destinations->add($destination);
            $destination->setVoyage($this);
        }

        return $this;
    }

    public function removeDestination(Destination $destination): static
    {
        if ($this->destinations->removeElement($destination)) {
            // set the owning side to null (unless already changed)
            if ($destination->getVoyage() === $this) {
                $destination->setVoyage(null);
            }
        }

        return $this;
    }

    public function getDestinationType(): ?string
    {
        return $this->destinationType;
    }

    public function setDestinationType(?string $destinationType): static
    {
        $this->destinationType = $destinationType;

        return $this;
    }
}
