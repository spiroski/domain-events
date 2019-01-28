<?php namespace Spiroski\Domain\Events;

trait GeneratesEvents
{

    /**
     * @var array
     */
    protected $generatedEvents = [];

    /**
     * @param Event $event
     */
    public function raise(Event $event)
    {
        $this->generatedEvents[] = $event;
    }

    /**
     * @return array
     */
    public function release()
    {
        $events = $this->generatedEvents;
        $this->generatedEvents = [];
        return $events;
    }

}