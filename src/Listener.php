<?php namespace Spiroski\Domain\Events;

interface Listener
{

    /**
     * @param Event $event
     * @return void
     */
    public function handle(Event $event);

}