<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root');
        $menu->setAttributes(array(
            'id' => 'accordionSidebar',
            'class' => 'navbar-nav bg-gradient-primary sidebar sidebar-dark accordion'
        ));
        $menu->addChild('Dashboard', ['route' => 'admin'])->setAttributes([
            'class' => 'nav-item'
        ]);
//        $menu->addChild('Dashboard', ['route' => 'user_index']);

        // access services from the container!
//        $em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples

//        $menu->addChild('Latest Blog Post', [
//        'route' => 'blog_show',
//        'routeParameters' => ['id' => $blog->getId()]
//        ]);

        // create another menu item
        $menu->addChild('Components', ['route' => 'calling_list_index'])->setAttributes([
            'class' => 'nav-item'
        ]);
        // you can also add sub levels to your menus as follows
        $menu['Components']->addChild('Edit profile', ['route' => 'calling_list_index']);

        // ... add more children

        return $menu;
    }
}