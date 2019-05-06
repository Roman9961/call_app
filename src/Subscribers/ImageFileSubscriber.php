<?php

namespace App\Subscribers;

use App\Entity\User;
use App\Utils\FileManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\File;

class ImageFileSubscriber implements EventSubscriberInterface
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
    public static function getSubscribedEvents()
    {
       return [
          FormEvents::PRE_SET_DATA => 'onPreSetData'
       ];
    }

    public function onPreSetData(FormEvent $event)
    {
        $entity = $event->getData();


        if (!$entity instanceof User) {
            return;
        }

        if ($fileName = $entity->getImage()) {
            $entity->setImage(new File($this->filemanager->getTargetDirectory().'/'.$fileName));
            $event->setData($entity);
        }

    }
}