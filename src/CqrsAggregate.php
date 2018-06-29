<?php
namespace Yoon\YoonMvp;

use Yoon\YoonMvp\EventStore\EventStream;

use Rhumsaa\Uuid\Uuid;

abstract class CqrsAggregate extends AggregateRoot
{
    /**
     * @var array<Event>
     */
    private $messages = array();

    public function loadFromEventStream(EventStream $eventStream)
    {
        if ($this->events) {
            throw new RuntimeException("AggregateRoot was already created from event stream and cannot be hydrated again.");
        }
        $this->setId($eventStream->getUuid());
        foreach ($eventStream as $event) {
            $this->executeEvent($event);
        }
    }

    public function pullEvents()
    {
        $events = $this->events;
        $this->events = array();
        return $events;
    }
}