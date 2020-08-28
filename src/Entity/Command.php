<?php

namespace App\Entity;

use App\Repository\CommandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandRepository::class)
 */
class Command
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=LineCommand::class, mappedBy="command", orphanRemoval=true)
     */
    private $lineCommand;

    /**
     * @ORM\ManyToOne(targetEntity=Buyer::class, inversedBy="commands")
     * @ORM\JoinColumn(nullable=false)
     */
    private $buyer;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="commands")
     * @ORM\JoinColumn(nullable=false)
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
     * @param  Linecommand $lineCommand
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
     * @param  Linecommand $lineCommand
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
}
