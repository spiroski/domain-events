<?php namespace Spiroski\Domain\Events;

interface Subscriber
{

    /**
     * @return array
     */
    public function getSubscribedEvents(): array;


}