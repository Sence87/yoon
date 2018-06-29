<?php

namespace Yoon\YoonMvp\EventStore;

use Yoon\YoonMvp\Event;

/**
 * Abstraction for DomainEvent serializers
 */
interface SerializerInterface
{
    public function serialize(Event $event, $format);
    public function deserialize($eventClass, $data, $format);
}

