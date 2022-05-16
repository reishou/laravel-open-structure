<?php

namespace Core\Services;

use Lucid\Units\Operation;

class BaseOperation extends Operation
{
    use RunInQueue;
    use ServiceSupport;
}
