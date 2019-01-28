<?php namespace Spiroski\Domain\Events;

class BasicDispatcher implements Dispatcher
{
    /**
     * @var array
     */
    protected $listeners;

    /**
     * @var array
     */
    protected $subscribers;

    /**
     * BasicDispatcher constructor.
     */
    public function __construct()
    {
        $this->listeners = [];
        $this->subscribers = [];
    }


    /**
     * @param array $events
     * @return void
     */
    public function dispatch(array $events)
    {
        foreach ($events as $event) {
            $this->dispatchToListeners($event);
            $this->dispatchToSubscribers($event);
        }
    }

    /**
     * @param EventGenerator $generator
     */
    public function dispatchEventsFor(EventGenerator $generator)
    {
       $this->dispatch($generator->release());
    }

    /**
     * @param Event $event
     * @return void
     */
    protected function dispatchToListeners(Event $event)
    {
        $eventClass = get_class($event);

        if (!array_key_exists($eventClass, $this->listeners)) {
            return;
        }

        /** @var Listener $listener */
        foreach ($this->listeners[$eventClass] as $listener) {
            $listener->handle($event);
        }
    }

    /**
     * @param Event $event
     * @return void
     */
    protected function dispatchToSubscribers(Event $event)
    {
        $eventClass = get_class($event);

        /** @var Subscriber $subscriber */
        foreach ($this->subscribers as $subscriber) {
            if (array_key_exists($eventClass, $subscriber->getSubscribedEvents())) {
                $method = $subscriber->getSubscribedEvents()[$eventClass];
                call_user_func([$subscriber, $method], $event);
            }
        }
    }

    /**
     * @param $eventClass
     * @param Listener $listener
     * @return void
     */
    public function registerListener($eventClass, Listener $listener)
    {
        if (!array_key_exists($eventClass, $this->listeners)) {
            $this->listeners[$eventClass] = [];
        }

        $this->listeners[$eventClass][] = $listener;
    }

    /**
     * @param Subscriber $subscriber
     * @return void
     */
    public function registerSubscriber(Subscriber $subscriber)
    {
        $this->subscribers[] = $subscriber;
    }

}