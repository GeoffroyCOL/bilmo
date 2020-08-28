<?php

/**
 * Represents a line of a command: phone and number thereof
 */

namespace App\Entity;

use App\Repository\LinecommandRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LinecommandRepository::class)
 */
class Linecommand
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity=Command::class, inversedBy="lineCommand")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $command;
    
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
     * getNumber
     *
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }
    
    /**
     * setNumber
     *
     * @param  int $number
     * @return self
     */
    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }
    
    /**
     * getCommand
     *
     * @return Command|null
     */
    public function getCommand(): ?Command
    {
        return $this->command;
    }
    
    /**
     * setCommand
     *
     * @param  Command|null $command
     * @return self
     */
    public function setCommand(?Command $command): self
    {
        $this->command = $command;

        return $this;
    }
}
