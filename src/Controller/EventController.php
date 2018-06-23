<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class EventController extends Controller
{
	protected $subcribed = array();
	protected $notSubscribed = array();

    /**
     * @Route("/event/{id}", name="event_show", methods="GET", requirements={"id"="\d+"})
     */
    public function show(Event $event, AuthorizationCheckerInterface $authChecker): Response
    {
        return $this->render('event/event.html.twig', ['event' => $event]);
    }

    /**
     * @Route("/event/list", name="event_list", methods="GET")
     */
    public function list(EventRepository $eventRepository, AuthorizationCheckerInterface $authChecker): Response
    {
    	$user = $this->get('security.token_storage')->getToken()->getUser();
    	$result = $this->getDoctrine()->getRepository(Event::class)->findOneByUser($user);
    	dump($user);
    	die;
    	/*
    	$dataToCheckSubscription = array(
    		'event_id' => $event->getId(),
    		'user_id' => $user->getId()
    		);
		$availableEventList = $this->getDoctrine()
		    ->getRepository(Event::class)
		    ->findUserUnsubscribedEvents($user->getId());
*/

		$availableEventList = $this->getEventListAvailableForUser($user->getId());

    	return $this->render(
    		'event/list.html.twig',
    		['eventList' => $availableEventList]);
    }
/*
    protected function getEventListAvailableForUser($userId): array
    {
    	//$userId = 17;
        $sql = "SELECT id FROM
            (SELECT event_id, id FROM
                (SELECT event_id
                    FROM subscription
                    WHERE user_id='".$userId."')
                a RIGHT JOIN event b
                ON a.event_id=b.id)
            c WHERE c.event_id IS NULL;";
        $sql = "SELECT * FROM event e WHERE e.id  NOT IN (SELECT event_id FROM subscription WHERE user_id = :userId);";
        $doctrineManager = $this->getDoctrine()->getManager();
        // de esta query hay que mapear el resultado a objectos de tipo evento
        $sqlResult = $doctrineManager->getConnection()->prepare($sql)->setParameters(['userId'=> $userId]);
        $sqlResult->execute();

        return $sqlResult->fetchAll();
    }
*/
	/**
	 * @param Event $event
	 *
	 * @Route("/event/add/{id}", requirements={"id" = "\d+"}, name="add_user_to_event")
	 * @return RedirectResponse
	 */
	public function addUserToEvent(Event $event)
	{
		$user = $this->get('security.token_storage')->getToken()->getUser();
		$capacity = $event->getCapacity();
		$userListStored = $event->getUserList();

		$event->setCapacity($capacity-1);

		$manager->persist($event);
	}

	/**
	 * @param Event $event
	 *
	 * @Route("/event/add/{id}", requirements={"id" = "\d+"}, name="add_user_to_event")
	 * @return RedirectResponse
	 */
	public function removeUserToEvent(Event $event)
	{
		$user = $this->get('security.token_storage')->getToken()->getUser();
		$capacity = $event->getCapacity();
		$userListStored = $event->getUserList();

		$event->setCapacity($capacity+1);

		$manager->persist($event);
	}
}
