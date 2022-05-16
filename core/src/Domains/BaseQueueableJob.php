<?php

namespace Core\Domains;

use Lucid\Units\QueueableJob;

abstract class BaseQueueableJob extends QueueableJob
{
    abstract public function handle();
}
