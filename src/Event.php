<?php namespace Spiroski\Domain\Events;

interface Event
{

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;

}