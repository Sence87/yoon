<?php

namespace Yoon\YoonMvp;

use Rhumsaa\Uuid\Uuid;

interface Message
{
    /**
     * Gets the message id.
     * @return Rhumsaa\Uuid\Uuid
     */

    public function getId();

    /**
     * Gets the message hash signed by the id.
     * @return string
     */
    public function getHashSignedById();
}

?>