<?php

namespace App\DataFixtures;

use App\Entity\CallingTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CallingTimeFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $callingTime1 = (new CallingTime())
            ->setUser($this->getReference('user2'))
            ->setCallingDay(1)
            ->setStartCallingTime((new \DateTime())->setTime(14, 55))
            ->setEndCallingTime((new \DateTime())->setTime(19, 55))
            ;
        $callingTime2 = (new CallingTime())
            ->setUser($this->getReference('user2'))
            ->setCallingDay(2)
            ->setStartCallingTime((new \DateTime())->setTime(9, 30))
            ->setEndCallingTime((new \DateTime())->setTime(18, 00))
            ;
        $manager->persist($callingTime1);
        $manager->persist($callingTime2);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 200;
    }
}
