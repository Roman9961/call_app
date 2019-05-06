<?php

namespace App\DataFixtures;

use App\Entity\ClientMsisdn;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ClientMsisdnFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $clientMsisdn1 = (new ClientMsisdn())->setMsisdn(380999999999);
        $clientMsisdn2 = (new ClientMsisdn())->setMsisdn(380999999998);
        $clientMsisdn3 = (new ClientMsisdn())->setMsisdn(380999999997);
        $clientMsisdn4 = (new ClientMsisdn())->setMsisdn(380999999996);
        $clientMsisdn5 = (new ClientMsisdn())->setMsisdn(380999999995);

        $manager->persist($clientMsisdn1);
        $manager->persist($clientMsisdn2);
        $manager->persist($clientMsisdn3);
        $manager->persist($clientMsisdn4);
        $manager->persist($clientMsisdn5);

        $manager->flush();

        $this->addReference('msisdn1', $clientMsisdn1);
        $this->addReference('msisdn2', $clientMsisdn2);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 100;
    }
}
