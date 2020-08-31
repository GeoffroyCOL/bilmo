<?php

/**
 * Represent a client
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CustomerRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

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
 *      denormalizationContext={"groups"={"user:write"}},
 *
 *      collectionOperations={
 *          "GET"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous ne pouvez pas consulter la liste des clients !",
 *              "normalization_context"={"groups"={"user:read:list"}}
 *          },
 *          "POST"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous ne pouvez pas les droits pour ajouter un nouveau client !"
 *          }
 *      },
 *
 *      itemOperations={
 *          "GET"={
 *              "security"="is_granted('ROLE_ADMIN') or object == user",
 *              "security_message"="Vous ne pouvez pas consulter le profil de ce client !",
 *              "normalization_context"={"groups"={"user:read"}}
 *          },
 *          "PUT"={
 *              "security"="is_granted('ROLE_ADMIN') or object == user",
 *              "security_message"="Vous ne pouvez pas modifer le profil de ce client !"
 *          },
 *          "DELETE"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous ne pouvez pas les droits pour supprimer un client !"
 *          },
 *          "get_list_buyers": {
 *              "method": "GET",
 *              "path": "/customers/{id}/buyers",
 *              "controller": App\Controller\Api\Buyer\ListBuyers::class,
 *              "security"="is_granted('ROLE_ADMIN') or object == user",
 *              "security_message"="Vous ne pouvez pas les droits de consulter la liste des acheteurs d'un autre client !",
 *              "normalization_context"={"groups"={"buyer_list:read"}}
 *         },
 *          "get_list_commands": {
 *              "method": "GET",
 *              "path": "/customers/{id}/commands",
 *              "controller": App\Controller\Api\Command\ListCommands::class,
 *              "security"="is_granted('ROLE_ADMIN') or object == user",
 *              "security_message"="Vous ne pouvez pas les droits de consulter la liste des commandes d'un autre client !",
 *              "normalization_context"={"groups"={"command_list:read"}}
 *         }
 *      }
 * )
 *
 * @ApiFilter(SearchFilter::class, properties={"username": "partial"})
 *
 */
class Customer extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({
     *      "user:read:list",
     *      "user:read",
     *      "user:write",
     *      "buyer:read",
     *      "command:read"
     * })
     *
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity=Buyer::class, inversedBy="customers")
     *
     * @Groups({
     *      "user:read"
     * })
     */
    private $buyers;

    /**
     * @ORM\OneToMany(targetEntity=Command::class, mappedBy="customer", orphanRemoval=true)
     *
     * @Groups({
     *      "user:read"
     * })
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
