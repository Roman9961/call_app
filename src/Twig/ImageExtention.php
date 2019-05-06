<?php

namespace App\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ImageExtention extends AbstractExtension
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            new TwigFilter('default_image', [$this, 'getDefaultImage'] ),
        );
    }

    public function getDefaultImage(string $path = null)
    {
        $defaultImagePath = $this->container->getParameter('default_image_path');
        return preg_match('/uploads/', $path)? $path : $defaultImagePath;
    }
}