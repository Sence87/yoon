<?php
namespace Yoon\YoonMvp;

use Rhumsaa\Uuid\Uuid;

abstract class AggregateRoot extends Entitiy
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

    protected function apply(DomainEvent $event)
    {
        $this->executeEvent($event);
        $this->messages[] = $event;
    }

    private function executeEvent(DomainEvent $event)
    {
        $eventName = new EventName($event);
        $method = sprintf('apply%s', (string)$eventName);
        if (!method_exists($this, $method)) {
            throw new BadMethodCallException(
                "There is no event named '$method' that can be applied to '" . get_class($this) . "'. " .
                "If you just want to emit an event without applying changes use the raise() method."
            );
        }
        $this->$method($event);
    }
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
    public function pullDomainEvents()
    {
        $events = $this->events;
        $this->events = array();
        return $events;
    }
}