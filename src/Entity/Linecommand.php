<?php

/**
 * Represents a line of a command: phone and number thereof
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LineCommandRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LineCommandRepository::class)
 */
class LineCommand
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Groups({
     *      "command:read",
     *      "command:write",
     *      "command_list:read"
     * })
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity=Command::class, inversedBy="lineCommand")
     * @ORM\JoinColumn(nullable=false)
     */
    private $command;

    /**
     * @ORM\ManyToOne(targetEntity=Phone::class)
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Groups({
     *      "command:read",
     *      "command:write",
     *      "command_list:read"
     * })
     */
    private $phone;
    
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
    
    /**
     * getPhone
     *
     * @return Phone|null
     */
    public function getPhone(): ?Phone
    {
        return $this->phone;
    }
    
    /**
     * setPhone
     *
     * @param  Phone|null $phone
     * @return self
     */
    public function setPhone(?Phone $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Display price for a row
     * 
     * @Groups({
     *      "command:read"
     * })
     * 
     * @return  float|null
     */ 
    public function getPrice(): ?float
    {
        return round($this->getNumber() * $this->getPhone()->getPrice(), 2, PHP_ROUND_HALF_UP);
    }
}
