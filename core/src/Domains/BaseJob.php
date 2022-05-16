<?php

namespace Core\Domains;

use Lucid\Units\Job;

abstract class BaseJob extends Job
{
    abstract public function handle();
}
