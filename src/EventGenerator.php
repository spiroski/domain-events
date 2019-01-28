<?php namespace Spiroski\Domain\Events;

interface EventGenerator
{
    /**
     * @return array
     */
    public function release(): array;

    /**
     * @param Event $event
     * @return void
     */
    public function raise(Event $event);

}