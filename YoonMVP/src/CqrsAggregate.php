<?php
namespace Yoon\YoonMvp;

use Yoon\YoonMvp\EventStore\EventStream;

use Rhumsaa\Uuid\Uuid;

abstract class CqrsAggregate extends AggregateRoot
{
    /**
     * @var array<Event>
     */
    private $events = array();

    /**
     * Loads all events from the specified event stream.
     *
     * @param EventStream $eventStream
     * @return void
     */
    public function loadFromEventStream(EventStream $eventStream) : void
    {
        if ($this->events) {
            throw new RuntimeException("AggregateRoot was already created from event stream and cannot be hydrated again.");
        }
        $this->setId($eventStream->getUuid());
        foreach ($eventStream as $event) {
            $this->executeEvent($event);
        }
    }

    /**
     * Pulls all stored outstanding events within the aggregate and clears them.
     *
     * @return void
     */
    public function popAllEvents() : array
    {
        $events = $this->events;
        $this->events = array();
        return $events;
    }
}