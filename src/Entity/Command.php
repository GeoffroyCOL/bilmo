<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommandRepository::class)
 * 
 * @ApiResource(
 *      attributes={
 *          "security"="is_granted('ROLE_USER')",
 *          "security_message"="Vous devez être connecté(e) pour accéde à cette zone",
 *          "pagination_items_per_page"=10
 *      },
 * 
 *      denormalizationContext={"groups"={"command:write"}},
 * 
 *      collectionOperations={
 *          "GET"={
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous ne pouvez pas consulter la liste des commandes !",
 *              "normalization_context"={"groups"={"command:read:list"}}
 *          },
 *          "POST"={
 *              "security"="is_granted('ROLE_CUSTOMER')",
 *              "security_message"="Vous ne pouvez pas ajouter de commande !"
 *          }
 *      },
 * 
 *      itemOperations={
 *          "GET"={
 *              "security"="is_granted('READ_COMMAND', object)",
 *              "security_message"="Vous ne pouvez pas consulter les informations de la commande !",
 *              "normalization_context"={"groups"={"command:read"}}
 *          },
 *          "DELETE"={
 *              "security"="is_granted('REMOVE_COMMAND', object)",
 *              "security_message"="Vous ne pouvez pas supprimer commande !"
 *          }
 *      }
 * )
 */
class Command
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({
     *      "command:read:list",
     *      "command:read",
     *      "buyer:read",
     *      "user:read"
     * })
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups({
     *      "command:read:list",
     *      "command:read",
     *      "buyer:read",
     *      "user:read"
     * })
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=LineCommand::class, mappedBy="command", orphanRemoval=true, cascade={"persist"})
     * 
     * @Groups({
     *      "command:read",
     *      "command:write"
     * })
     */
    private $lineCommand;

    /**
     * @ORM\ManyToOne(targetEntity=Buyer::class, inversedBy="commands", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups({
     *      "command:read:list",
     *      "command:read",
     *      "user:read",
     *      "command:write"
     * })
     */
    private $buyer;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="commands")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups({
     *      "command:read:list",
     *      "admin:buyer:read"
     * })
     */
    private $customer;

    public function __construct()
    {
        $this->lineCommand = new ArrayCollection();
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
     * @return Collection|LineCommand[]
     */
    public function getLineCommand(): Collection
    {
        return $this->lineCommand;
    }
    
    /**
     * addLineCommand
     *
     * @param  LineCommand $lineCommand
     * @return self
     */
    public function addLineCommand(LineCommand $lineCommand): self
    {
        if (!$this->lineCommand->contains($lineCommand)) {
            $this->lineCommand[] = $lineCommand;
            $lineCommand->setCommand($this);
        }

        return $this;
    }
    
    /**
     * removeLineCommand
     *
     * @param  LineCommand $lineCommand
     * @return self
     */
    public function removeLineCommand(LineCommand $lineCommand): self
    {
        if ($this->lineCommand->contains($lineCommand)) {
            $this->lineCommand->removeElement($lineCommand);
            // set the owning side to null (unless already changed)
            if ($lineCommand->getCommand() === $this) {
                $lineCommand->setCommand(null);
            }
        }

        return $this;
    }
    
    /**
     * getBuyer
     *
     * @return Buyer|null
     */
    public function getBuyer(): ?Buyer
    {
        return $this->buyer;
    }
    
    /**
     * setBuyer
     *
     * @param  Buyer|null $buyer
     * @return self
     */
    public function setBuyer(?Buyer $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }
    
    /**
     * getCustomer
     *
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }
    
    /**
     * setCustomer
     *
     * @param  Customer|null $customer
     * @return self
     */
    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get the value of price
     * 
     *  @Groups({
     *      "command:read",
     *      "user:read"
     * })
     * 
     * @return  float|null
     */ 
    public function getPrice(): ?float
    {
        $total = 0;
        foreach ($this->getLineCommand()->toArray() as $line) {
            $total += $line->getPrice();
        }
        return round($total, 2, PHP_ROUND_HALF_UP);
    }
}
