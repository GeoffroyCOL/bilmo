<?php

namespace App\Service;

use App\Entity\Phone;
use App\Repository\PhoneRepository;
use Doctrine\ORM\EntityManagerInterface;

class PhoneHandler
{
    private $manager;
    private $repository;

    public function __construct(EntityManagerInterface $manager, PhoneRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }
    
    /**
     * edit
     *
     * @param  Phone $phone
     * @param  int $numberCommand
     * @param  int coef // Allows you to know whether to add or remove the numberSold attribute
     */
    public function edit(Phone $phone, int $numberCommand, int $coef = 1): void
    {
        //Recovery of the number of phones sold and the total number
        $number = $phone->getNumber();
        $numberSold = $phone->getNumberSold() + ($numberCommand * $coef);

        //Edit number phone sold
        $phone->setNumberSold($numberSold);

        $phone->setActive($this->changeStatus($number, $numberSold));
        $this->manager->flush();
    }
    
    /**
     * changeStatus - If the phone can be sold
     *
     * @param  int $number
     * @param  int $numberSold
     * @return bool
     */
    private function changeStatus(int $number, int $numberSold): bool
    {
        if ($number - $numberSold == 0) {
            return false;
        }

        return true;
    }
    
    /**
     * getPhone
     *
     * @param  int $id
     * @return Phone
     */
    public function getPhone(int $id): Phone
    {
        return $this->repository->find($id);
    }
}
