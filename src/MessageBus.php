<?php

namespace Yoon\YoonMvp;
/**
 * Message bus handles all messages that were emitted by domain objects or commannd handlers.
 *
 * The Message Bus finds all message handlers that listen to a certain
 * command or event, and then triggers these handlers one after another. Exceptions in
 * event or command handlers should be swallowed. Intelligent Messagge Systems should know
 * how to retry failing messages until they are successful or failed too often.
 */
interface EventMessageBus
{
    /**
     * Publish an event to the bus.
     *
     * @param Event $event
     * @return void
     */
    public function publish(Event $event);
}