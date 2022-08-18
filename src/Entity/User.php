<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Voyage::class, mappedBy="owner")
     */
    private $ownedVoyages;

    /**
     * @ORM\ManyToMany(targetEntity=Voyage::class, mappedBy="users")
     */
    private $sharedVoyages;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="author")
     */
    private $notes;

    public function __construct()
    {
        $this->ownedVoyages = new ArrayCollection();
        $this->sharedVoyages = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Voyage>
     */
    public function getOwnedVoyages(): Collection
    {
        return $this->ownedVoyages;
    }

    public function addOwnedVoyage(Voyage $ownedVoyage): self
    {
        if (!$this->ownedVoyages->contains($ownedVoyage)) {
            $this->ownedVoyages[] = $ownedVoyage;
            $ownedVoyage->setOwner($this);
        }

        return $this;
    }

    public function removeOwnedVoyage(Voyage $ownedVoyage): self
    {
        if ($this->ownedVoyages->removeElement($ownedVoyage)) {
            // set the owning side to null (unless already changed)
            if ($ownedVoyage->getOwner() === $this) {
                $ownedVoyage->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Voyage>
     */
    public function getSharedVoyages(): Collection
    {
        return $this->sharedVoyages;
    }

    public function addSharedVoyage(Voyage $sharedVoyage): self
    {
        if (!$this->sharedVoyages->contains($sharedVoyage)) {
            $this->sharedVoyages[] = $sharedVoyage;
            $sharedVoyage->addUser($this);
        }

        return $this;
    }

    public function removeSharedVoyage(Voyage $sharedVoyage): self
    {
        if ($this->sharedVoyages->removeElement($sharedVoyage)) {
            $sharedVoyage->removeUser($this);
        }

        return $this;
    }

    public function getVoyages(): ArrayCollection
    {
        return new ArrayCollection(
            array_merge(
                $this->getOwnedVoyages()->toArray(),
                $this->getSharedVoyages()->toArray()
            )
        );
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setAuthor($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getAuthor() === $this) {
                $note->setAuthor(null);
            }
        }

        return $this;
    }
}
