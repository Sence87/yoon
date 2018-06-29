<?php
namespace Yoon\YoonMvp;

use Rhumsaa\Uuid\Uuid;

abstract class AggregateRoot extends Entity
{
    /**
     * @var Rhumsaa\Uuid\Uuid
     */
    private $id;

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

    /**
     * Gets the entity hash signed by the id.
     * @return string
     */
    final public function getHashSignedById()
    {
        return sodium_crypto_generichash($this->id);
    }

    public abstract function apply(Event $event);
}