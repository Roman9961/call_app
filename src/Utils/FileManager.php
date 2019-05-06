<?php

namespace App\Utils;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function uploadFile(UploadedFile $uploadedFile)
    {
        $filename = $this->generateUniqeName() . '.' . $uploadedFile->guessExtension();

        $uploadedFile->move(
            $this->getTargetDirectory(),
            $filename
        );

        return $filename;
    }

    public function removeFile($filename)
    {
        if(is_null($filename)){
            return;
        }
        $filesystem = new Filesystem();
        $path = $this->getTargetDirectory().'/'.$filename;
        $filesystem->remove(
            $path
        );
    }

    public function getTargetDirectory()
    {
        return $this->container->getParameter('upload_dir');
    }

    private function generateUniqeName()
    {
        return md5(uniqid());
    }
}