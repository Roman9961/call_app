<?php

namespace App\Utils;

use App\Entity\ClientMsisdn;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Process\Process;

class CsvParser
{
    private $em;
    /**
     * @var AsyncSaveToDb
     */
    private $asyncSaveToDb;
    /**
     * @var FileManager
     */
    private $fileManager;

    public function __construct(EntityManagerInterface $em, AsyncSaveToDb $asyncSaveToDb, FileManager $fileManager)
    {
        $this->em = $em;
        $this->asyncSaveToDb = $asyncSaveToDb;
        $this->fileManager = $fileManager;
    }

    public function saveWorkToQueue(UploadedFile $file,$userId, $callingListId)
    {
        if($file) {
            $file = $this->fileManager->uploadFile($file);
            $this->asyncSaveToDb->later(10)->saveToDb($userId, $callingListId, $file);
        }
    }


}