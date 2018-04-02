<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
	private $encoder;

	public function __construct(UserPasswordEncoderInterface $encoder)
	{
	    $this->encoder = $encoder;
	}
    public function load(ObjectManager $manager)
    {
        // for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setUsername('hhh');
            $user->setLastname('hhh');
            $user->setEmail('hhh@test.ch');
            $password = $this->encoder->encodePassword($user, '555');
            $user->setPassword($password);
            // $user->setPassword(555);
            $user->setDni(555);
            $user->setPhone(555555555);
            $user->setIsActive(1);

            $manager->persist($user);
        // }

        $manager->flush();
    }
}
