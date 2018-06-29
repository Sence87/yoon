<?php

namespace Yoon\YoonMvp\EventStore;

class Transaction
{
    private $eventStream;
    private $committedEvents = array();

    public function __construct(EventStream $eventStream, array $committedEvents)
    {
        $this->eventStream = $eventStream;
        $this->committedEvents = $committedEvents;
    }

    /**
     * @return \Yoon\YoonMvp\EventStore\EventStream
     */
    public function getEventStream() : EventStream
    {
        return $this->eventStream;
    }

    /**
     * @return array<Yoon\YoonMvp\Event>
     */
    public function getCommittedEvents()
    {
        return $this->committedEvents;
    }
}
