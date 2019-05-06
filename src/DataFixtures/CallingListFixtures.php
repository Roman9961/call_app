<?php

namespace App\DataFixtures;

use App\Entity\CallingList;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CallingListFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $callingList = (new CallingList())
            ->setName('calling list #1')
            ->setUser($this->getReference('user2'))
            ->addClientMsisdn($this->getReference('msisdn1'))
            ->addClientMsisdn($this->getReference('msisdn2'))
            ;
        $callingList2 = (new CallingList())
            ->setName('calling list #2')
            ->setUser($this->getReference('user2'))
            ->addClientMsisdn($this->getReference('msisdn1'))
            ->addClientMsisdn($this->getReference('msisdn2'))
        ;
        $manager->persist($callingList);
        $manager->persist($callingList2);

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
