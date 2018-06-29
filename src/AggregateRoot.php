<?php
namespace Yoon\YoonMvp;

use Rhumsaa\Uuid\Uuid;

abstract class AggregateRoot extends Entity
{
    /**
     * @var Rhumsaa\Uuid\Uuid
     */
    private $id;
    /**
     * @var array<Message>
     */
    private $messages = array();

    protected function setId(Uuid $uuid)
    {
        $this->id = $uuid;
    }

    /**
     * @return Rhumsaa\Uuid\Uuid
     */
    final public function getId()
    { 
        return $this->id;
    }

    protected abstract function apply(Message $event);


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

    public function pullMessages()
    {
        $events = $this->events;
        $this->events = array();
        return $events;
    }
}