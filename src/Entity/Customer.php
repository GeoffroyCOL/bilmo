<?php

/**
 * Represent a client
 */

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity=Buyer::class, inversedBy="customers")
     */
    private $buyers;

    /**
     * @ORM\OneToMany(targetEntity=Command::class, mappedBy="customer", orphanRemoval=true)
     */
    private $commands;

    public function __construct()
    {
        $this->roles = ['ROLE_CUSTOMER'];
        $this->buyers = new ArrayCollection();
        $this->commands = new ArrayCollection();
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
     * @return Collection|Buyer[]
     */
    public function getBuyers(): Collection
    {
        return $this->buyers;
    }
    
    /**
     * addBuyer
     *
     * @param  Buyer $buyer
     * @return self
     */
    public function addBuyer(Buyer $buyer): self
    {
        if (!$this->buyers->contains($buyer)) {
            $this->buyers[] = $buyer;
        }

        return $this;
    }
    
    /**
     * removeBuyer
     *
     * @param  Buyer $buyer
     * @return self
     */
    public function removeBuyer(Buyer $buyer): self
    {
        if ($this->buyers->contains($buyer)) {
            $this->buyers->removeElement($buyer);
        }

        return $this;
    }

    /**
     * @return Collection|Command[]
     */
    public function getCommands(): Collection
    {
        return $this->commands;
    }
    
    /**
     * addCommand
     *
     * @param  Command $command
     * @return self
     */
    public function addCommand(Command $command): self
    {
        if (!$this->commands->contains($command)) {
            $this->commands[] = $command;
            $command->setCustomer($this);
        }

        return $this;
    }
    
    /**
     * removeCommand
     *
     * @param  Command $command
     * @return self
     */
    public function removeCommand(Command $command): self
    {
        if ($this->commands->contains($command)) {
            $this->commands->removeElement($command);
            // set the owning side to null (unless already changed)
            if ($command->getCustomer() === $this) {
                $command->setCustomer(null);
            }
        }

        return $this;
    }
}
