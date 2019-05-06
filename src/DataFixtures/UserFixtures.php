<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername('admin');
        $user->setPassword($this->encoder->encodePassword($user, 'admin'));
        $user->setAccountCode(1);
        $user->setRoles(['ROLE_ROOT']);

        $user2 = new User();

        $user2->setUsername('supervisor');
        $user2->setPassword($this->encoder->encodePassword($user, '111'));
        $user2->setAccountCode(2);
        $user2->setRoles(['ROLE_SUPERVISOR']);

        $manager->persist($user);
        $manager->persist($user2);

        $manager->flush();

        $this->setReference('user', $user);
        $this->setReference('user2', $user2);
    }
}
