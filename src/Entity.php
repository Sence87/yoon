<?php

namespace Yoon\YoonMvp;

use Rhumsaa\Uuid\Uuid;

interface Entity
{
    /**
     * Gets the entity id.
     * @return Rhumsaa\Uuid\Uuid
     */

    public function getId();

    /**
     * Gets the entity hash signed by the id.
     * @return string
     */
    public function getHashSignedById();


}