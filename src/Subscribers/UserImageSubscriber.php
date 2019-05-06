<?php

namespace App\Subscribers;

use App\Entity\User;
use App\Utils\FileManager;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserImageSubscriber implements EventSubscriber
{
    private $filemanager;

    /**
     * UserImageSubscriber constructor.
     * @param $filemanager
     */
    public function __construct(FileManager $filemanager)
    {
        $this->filemanager = $filemanager;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
       return [
           Events::postRemove
       ];
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        if($args->getEntity() instanceof User) {
            $file = $args->getObjectManager()->merge($args->getEntity()->getImage());
            $args->getObjectManager()->remove($file);
            $args->getObjectManager()->flush();
        }
    }

}