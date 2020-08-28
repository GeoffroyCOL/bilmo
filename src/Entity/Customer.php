<?php

/**
 * Represent a client
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * 
 * @ApiResource(
 *      attributes={
 *          "security"="is_granted('ROLE_USER')",
 *          "security_message"="Vous devez être connecté(e) pour accéde à cette zone",
 *          "pagination_items_per_page"=10
 *      },
 * 
 *      collectionOperations={
 *         "GET"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous ne pouvez pas consulter la liste des clients !",
 *              "normalization_context"={"groups"={"user:read:list"}}
 *         }
 *      },
 * )
 */
class Customer extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
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
        parent::__construct();
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
