<?php

namespace Yoon\YoonMvp;

use Ramsey\Uuid\Uuid;

interface Entity
{
    /**
     * Gets the entity id.
     * @return Rhumsaa\Uuid\Uuid
     */

    public function getId() : Uuid;

    /**
     * Gets the entity hash signed by the id.
     * @return string
     */
    public function getHashSignedById(): string;


    /**
     * Gets the entity hash signed by the id.
     * @return string
     */
    public function getState(): State;


    /**
     * Constructs an entity by it's state.                                                            
     *                                                                                                      
     * @param State $state
     * @return void
     */
    public function constructFromState(State $state) : Entity;
}