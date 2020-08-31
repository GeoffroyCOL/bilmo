<?php

/**
 * Represents a phone buyer at a client
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BuyerRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=BuyerRepository::class)
 * 
 * @ApiResource(
 *      attributes={
 *          "security"="is_granted('ROLE_USER')",
 *          "security_message"="Vous devez être connecté(e) pour accéde à cette zone",
 *          "pagination_items_per_page"=10
 *      },
 * 
 *      collectionOperations={
 *          "GET"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous ne pouvez pas les droits pour consulter la liste des acheteurs !",
 *              "normalization_context"={"groups"={"buyer:read:list"}}
 *          }
 *      },
 *      itemOperations={
 *          "GET"={
    *          "security"="is_granted('ROLE_ADMIN') or is_granted('READ_BUYER', object)",
    *          "security_message"="Vous ne pouvez pas les droits pour consulter le profil de cet acheteur !",
    *          "normalization_context"={"groups"={"buyer:read"}}
    *      },
            "DELETE"={
 *              "security"="is_granted('REMOVE_BUYER', object)",
 *              "security_message"="Vous ne pouvez pas les droits pour supprimer le profil de cet acheteur !",
 *              "controller"=App\Controller\Api\Buyer\DeleteBuyer::class
 *          },
 *      }
 * )
 * 
 * @ApiFilter(SearchFilter::class, properties={"firstName": "partial", "lastName": "partial", "customers":"partial"})
 * 
 */
class Buyer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({
     *      "buyer:read:list",
     *      "buyer:read",
     *      "user:read",
     *      "command:read:list",
     *      "command:read",
     *      "buyer_list:read",
     *      "command_list:read"
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({
     *      "buyer:read:list",
     *      "buyer:read",
     *      "user:read",
     *      "command:read:list",
     *      "command:read",
     *      "command:write",
     *      "buyer_list:read",
     *      "command_list:read"
     * })
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({
     *      "buyer:read:list",
     *      "buyer:read",
     *      "user:read",
     *      "command:read:list",
     *      "command:read",
     *      "command:write",
     *      "buyer_list:read",
     *      "command_list:read"
     * })
     */
    private $lastName;

    /**
     * The date of his first order
     * 
     * @ORM\Column(type="datetime")
     * 
     * @Groups({
     *      "buyer:read:list",
     *      "buyer:read",
     *      "user:read"
     * })
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity=Customer::class, mappedBy="buyers")
     * 
     * @Groups({
     *      "admin:buyer:read"
     * })
     */
    private $customers;

    /**
     * @ORM\OneToMany(targetEntity=Command::class, mappedBy="buyer", orphanRemoval=true)
     * 
     * @Groups({
     *      "admin:buyer:read"
     * })
     */
    private $commands;
    
    /**
     * commandsByCustomer - Retrieve the list of orders from a customer
     * 
     * @Groups({
     *      "customer:buyer:read"
     * })
     */
    private $commandsByCustomer;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
        $this->commands = new ArrayCollection();
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
     * getFirstName
     *
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    
    /**
     * setFirstName
     *
     * @param  string $firstName
     * @return self
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }
    
    /**
     * getLastName
     *
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }
    
    /**
     * setLastName
     *
     * @param  string $lastName
     * @return self
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }
    
    /**
     * addCustomer
     *
     * @param  Customer $customer
     * @return self
     */
    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->addBuyer($this);
        }

        return $this;
    }
    
    /**
     * removeCustomer
     *
     * @param  Customer $customer
     * @return self
     */
    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->contains($customer)) {
            $this->customers->removeElement($customer);
            $customer->removeBuyer($this);
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
            $command->setBuyer($this);
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
            if ($command->getBuyer() === $this) {
                $command->setBuyer(null);
            }
        }

        return $this;
    }

    /**
     * Get commandsByCustomer - Retrieve the list of orders from a customer
     */ 
    public function getCommandsByCustomer()
    {
        return $this->commandsByCustomer;
    }

    /**
     * Set commandsByCustomer - Retrieve the list of orders from a customer
     *
     * @return  self
     */ 
    public function setCommandsByCustomer($commandsByCustomer)
    {
        $this->commandsByCustomer = $commandsByCustomer;

        return $this;
    }
}
