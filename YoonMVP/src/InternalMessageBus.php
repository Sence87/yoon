<?php

use __\__;

namespace Yoon\YoonMvp;

/**
 * Message bus handles all messages that were emitted by domain objects or commannd handlers.
 *
 * The Message Bus finds all message handlers that listen to a certain
 * command or event, and then triggers these handlers one after another. Exceptions in
 * event or command handlers should be swallowed. Intelligent Messagge Systems should know
 * how to retry failing messages until they are successful or failed too often.
 * 
 * This is a simple in memory message bus.
 */
class InternalMessageBus implements MessageBus
{
    private $handlers = array();

    /**
     * Publish a message to the bus.
     *
     * @param Event $message
     * @return void
     */
    public function publish(Message $message) : void
    {
        $handler = $this->findHandler(get_class($message));
    }

    private function findHandler(string $key) : Handler
    {
        $handler = __::get($handler->getHashSignedById(), $this->handlers);
        return $handler;
    }

    /**
     * Registeres a message handler.
     *
     * @param Event $handler
     * @return void
     */
    public function register(Handler $handler) : void
    {
        if(__::has($this->handlers, $handler->getMessageType()))
        {
            return;
        }
        __::set($handler->getMessageType(), $handler);
    }
}

?>