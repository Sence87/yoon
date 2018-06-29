<?php
namespace Yoon\YoonMvp;

use Rhumsaa\Uuid\Uuid;

interface WriteRepository extends Repository
{
    /**
     * Saves the aggregate root.
     * @return void
     */
    public function save(AggregateRoot $aggregate);
}