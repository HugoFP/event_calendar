<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Event;
use App\Entity\Subscription;
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
        $user = new User();
        $user->setUsername('admin');
        $user->setLastname('admin');
        $user->setEmail('admin@test.ch');
        $password = $this->encoder->encodePassword($user, '555');
        $user->setPassword($password);
        $user->setDni(555);
        $user->setPhone(555555555);
        $user->setIsActive(1);
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setUserorder(1);

        $manager->persist($user);
        $manager->flush();
        $firstUserId = $user->getId();


        $user = new User();
        $user->setUsername('111');
        $user->setLastname('111');
        $user->setEmail('111@test.ch');
        $password = $this->encoder->encodePassword($user, '555');
        $user->setPassword($password);
        $user->setDni(111);
        $user->setPhone(111111111);
        $user->setIsActive(1);
        $user->setRoles(array('ROLE_USER'));
        $user->setUserorder(2);

        $manager->persist($user);
        $manager->flush();
        $secondUserId = $user->getId();


        $user = new User();
        $user->setUsername('333');
        $user->setLastname('333');
        $user->setEmail('333@test.ch');
        $password = $this->encoder->encodePassword($user, '555');
        $user->setPassword($password);
        $user->setDni(333);
        $user->setPhone(333333333);
        $user->setIsActive(1);
        $user->setRoles(array('ROLE_USER'));
        $user->setUserorder(3);

        $manager->persist($user);
        $manager->flush();
        $secondUserId = $user->getId();

        $event = new Event();
        $event->setName('First Event');
        $event->setDateFrom(\DateTime::createFromFormat('j-M-Y', '15-Feb-2009'));
        $event->setDateTo(\DateTime::createFromFormat('j-M-Y', '15-Feb-2029'));
        $event->setCapacity(10);
        $event->setCapacityLeft(8);
        $event->setIsActive(1);
        $event->setNotes('Default Note to test bla bla bla');

        $manager->persist($event);
        $manager->flush();
        $firstEventId = $event->getId();

        $event = new Event();
        $event->setName('Second Event');
        $event->setDateFrom(\DateTime::createFromFormat('j-M-Y', '15-Feb-2009'));
        $event->setDateTo(\DateTime::createFromFormat('j-M-Y', '15-Feb-2029'));
        $event->setCapacity(20);
        $event->setCapacityLeft(19);
        $event->setIsActive(1);
        $event->setNotes('Default Note to test bla bla bla');

        $manager->persist($event);
        $manager->flush();
        $secondEventId = $event->getId();

        $event = new Event();
        $event->setName('Third Event');
        $event->setDateFrom(\DateTime::createFromFormat('j-M-Y', '15-Feb-2009'));
        $event->setDateTo(\DateTime::createFromFormat('j-M-Y', '15-Feb-2029'));
        $event->setCapacity(30);
        $event->setCapacityLeft(30);
        $event->setIsActive(1);
        $event->setNotes('Default Note to test bla bla bla');

        $manager->persist($event);
        $manager->flush();
        $thirdEventId = $event->getId();



        $subscription = new Subscription();
        $subscription->setEventId($firstEventId);
        $subscription->setUserId($firstUserId);

        $manager->persist($subscription);


        $subscription = new Subscription();
        $subscription->setEventId($firstEventId);
        $subscription->setUserId($secondUserId);

        $manager->persist($subscription);



        $subscription = new Subscription();
        $subscription->setEventId($secondEventId);
        $subscription->setUserId($firstUserId);

        $manager->persist($subscription);

        $manager->flush();
    }
}
