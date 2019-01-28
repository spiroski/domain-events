<?php namespace Spiroski\Domain\Events;

interface Dispatcher
{

    /**
     * @param array $events
     * @return void
     */
    public function dispatch(array $events);

    /**
     * @param EventGenerator $eventGenerator
     * @return void
     */
    public function dispatchEventsFor(EventGenerator $eventGenerator);


}