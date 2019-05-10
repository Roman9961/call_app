<?php

namespace App\Utils;

use App\Entity\ClientMsisdn;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Dtc\QueueBundle\Model\Worker;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AsyncSaveToDb extends Worker
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var FileManager
     */
    private $fileManager;

    public function __construct(EntityManagerInterface $entityManager, FileManager $fileManager)
    {
        $this->entityManager = $entityManager;
        $this->fileManager = $fileManager;
    }

    public function getName()
    {
        return 'async_save_to_db';
    }

    public function saveToDb($userId, $listId, $file)
    {

        $userRepo = $this->entityManager->getRepository('App\Entity\User');
        $listRepo = $this->entityManager->getRepository('App\Entity\CallingList');
        $user = $userRepo->findOneBy(['id'=>$userId]);
        $list = $listRepo->findOneBy(['id'=>$listId]);

        $data = $this->fileManager->getTargetDirectory().'/'.$file;

            $msisdns = $this->saveMsisdnFromCsv($data, $user);
            foreach ($msisdns as $key=>$msisdn) {
                $list->addClientMsisdn($msisdn);
                dump($key);
            }
            $this->fileManager->removeFile($file);
            $this->entityManager->persist($list);

        $this->entityManager->flush();

    }

    private function saveMsisdnFromCsv($file, User $user)
    {
        $file = fopen($file, 'r');
        $headers = fgetcsv($file);
        $childrens = [];
        while(($data = fgetcsv($file)) !== false) {
            $data = array_combine($headers, $data);

            $number = $data['NUM'];
            $msisdnP = new ClientMsisdn();
            $msisdnP->setMsisdn($number);
            $msisdnP->setUser($user);
            $this->entityManager->persist($msisdnP);
            unset($data['NUM']);

            $childrens[] = $msisdnP;

            foreach ($data as $entry) {
                $msisdn = new ClientMsisdn();
                $msisdn->setMsisdn($entry);
                $msisdn->setUser($user);
                $msisdn->setParent($msisdnP);
                $this->entityManager->persist($msisdn);
                $childrens[] = $msisdn;
            }
        }


        return $childrens;
    }
}