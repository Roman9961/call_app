<?php

namespace App\Utils;

use App\Entity\ClientMsisdn;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CsvParser
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function saveMsisdnFromCsv(UploadedFile $uploadedFile, User $user)
    {
        $file = fopen($uploadedFile->getRealPath(), 'r');

        $headers = fgetcsv($file);

        $childrens = [];

        while(($data = fgetcsv($file)) !== false){

            $data = array_combine($headers, $data);

            $number = $data['NUM'];
            $msisdnP = new ClientMsisdn();
            $msisdnP->setMsisdn($number);
            $msisdnP->setUser($user);
            $this->em->persist($msisdnP);
            unset($data['NUM']);

            $childrens[] = $msisdnP;

            foreach ($data as $entry){
                $msisdn = new ClientMsisdn();
                $msisdn->setMsisdn($entry);
                $msisdn->setUser($user);
                $msisdn->setParent($msisdnP);
                $this->em->persist($msisdn);
                $childrens[] = $msisdn;
            }

        }
        return $childrens;
    }
}