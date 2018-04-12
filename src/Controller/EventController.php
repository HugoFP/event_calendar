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
		$availableEventList = $this->getDoctrine()
		    ->getRepository(Event::class)
		    ->findAllAvailableEventsForTheUser($user->getId());

    	return $this->render(
    		'event/list.html.twig',
    		['eventList' => $availableEventList]);
    }

    protected function eventsSubscribedByUser($event)
    {
		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userSuscriptionState = in_array($user->getId(), explode(',', $event->findAllAvailableEventsForTheUser()));

		if ($userSuscriptionState) {
			array_push($this->subcribed, $event);
			// array_push($this->subscribed['yes'], $event);
		} else {
			// array_push($this->subscribed['no'], $event);
			array_push($this->notSubcribed, $event);
		}
    }

    public function eventUnSubscribedByUser()
    {
    	findUserUnsubscribedEvents();
    }

    protected function eventsAvailabletoJoin()
    {

    }


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
