<?php

namespace Core\Services;

use Lucid\Units\QueueableOperation;

class BaseQueueableOperation extends QueueableOperation
{
    use RunInQueue;
    use ServiceSupport;
}
