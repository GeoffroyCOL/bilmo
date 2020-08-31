<?php

/**
 * Represents the users of the API: Administrator and client
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap(
 *      typeProperty="type",
 *      mapping={"user" = "User", "admin" = "Admin", "customer" = "Customer"}
 * )
 */
abstract class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({
     *      "user:read:list",
     *      "user:read",
     *      "buyer:read",
     *      "command:read:list",
     *      "command:read"
     * })
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *
     * @Groups({
     *      "user:read:list",
     *      "user:read",
     *      "user:write",
     *      "buyer:read",
     *      "command:read:list",
     *      "command:read"
     * })
     */
    protected $username;

    /**
     * @ORM\Column(type="json")
     */
    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    protected $password;
    
    /**
     * plainPassword
     *
     * @var string
     *
     * @Groups({
     *      "user:write"
     * })
     */
    protected $plainPassword;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups({
     *      "user:read:list",
     *      "user:read"
     * })
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Groups({
     *      "user:read:list",
     *      "user:read"
     * })
     */
    protected $connectedAt;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({
     *      "user:read:list",
     *      "user:read",
     *      "user:write"
     * })
     */
    protected $email;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    
    /**
     * getId
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }
    
    /**
     * setUsername
     *
     * @param  string $username
     * @return self
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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
    
    /**
     * setRoles
     *
     * @param  array $roles
     * @return self
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }
    
    /**
     * setPassword
     *
     * @param  string $password
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
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
     * getPlainPassword
     *
     * @return string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @param  string $plainPassword
     * @return  self
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
    
    /**
     * getCreatedAt
     *
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    
    /**
     * setCreatedAt
     *
     * @param  DateTimeInterface $createdAt
     * @return self
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    
    /**
     * getConnectedAt
     *
     * @return DateTimeInterface|null
     */
    public function getConnectedAt(): ?\DateTimeInterface
    {
        return $this->connectedAt;
    }
    
    /**
     * setConnectedAt
     *
     * @param  DateTimeInterface|null $connectedAt
     * @return self
     */
    public function setConnectedAt(?\DateTimeInterface $connectedAt): self
    {
        $this->connectedAt = $connectedAt;

        return $this;
    }
    
    /**
     * getEmail
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
    
    /**
     * setEmail
     *
     * @param  string $email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
