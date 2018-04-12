<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\User;
use App\Entity\Subscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findAllAvailableEventsForTheUser($userId): array
    {
        $qb = $this->createQueryBuilder('event')
            ->andWhere('event.capacity_left > 0')
            ->andWhere('event.is_active > 0')
            ->andWhere('event.date_to > CURRENT_DATE()')
            ->getQuery();

        return $qb->execute();
    }

    public function findUserSubscribedEvents($userId): array
    {
        return $this->createQueryBuilder('user')
            ->andWhere('user.id <> '.$userId)
        	//->setParameter('id', $userId)
            ->getQuery()
            ->getResult();
            // ->execute();
    }

    public function findUserUnsubscribedEvents($userId): array
    {
    	$sql = "SELECT id FROM
    		(SELECT event_id, id FROM
    			(SELECT event_id
    				FROM subscription
    				WHERE user_id='".$userId."')
    			a RIGHT JOIN event b
    			ON a.event_id=b.id)
    		c WHERE c.event_id IS NULL;";

	    $doctrineManager = $this->getDoctrine()->getManager();
	    $sqlResult = $doctrineManager->getConnection()->prepare($sql);
	    $sqlResult->execute();

	    return $sqlResult->fetchAll();

	    /*

$query = $em->createQuery('SELECT u FROM MyProject\Model\User u WHERE u.age > 20');
$users = $query->getResult();
	    */
    }

    public function addUserToEvent($userId, $eventId)
    {
    	/*
        $user = new User();
        $user->setUsername('admin');
        $user->setLastname('admin');
        $user->setEmail('admin@test.ch');
        $password = $this->encoder->encodePassword($user, '555');
        $user->setPassword($password);
        $user->setDni(555);
        $user->setPhone(555555555);
        $user->setIsActive(1);
        $user->setOrder(1);
        $user->setRoles(array('ROLE_ADMIN'));

        $manager->persist($user);
        $manager->flush();
    	*/
    	/*
    	$event = new Event();
		$event->setName($newEventName);

		$entityManager->persist($event);
		$entityManager->flush();

		        return $this->createQueryBuilder('user')
            ->andWhere('user.id <> '.$userId)
        	//->setParameter('id', $userId)
            ->getQuery()
            ->getResult();
            // ->execute();

        */
    	// addToEvent
    	// subscription set (user_id - event_id)
    	// event.capacity -1
    	// send email to the next user
    }

	public function removeUserFromEvent($userId, $eventId)
    {
    	// removeFromEvent
    	// subscription unset (user_id - event_id)
    	// event.capacity +1
    	// send email to the next user
    }
}
