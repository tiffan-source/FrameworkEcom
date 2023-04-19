<?php

namespace Framework\Session;

use Framework\Session\PHPSession;

class PHPSessionFactory
{
    public function __invoke() : PHPSession
    {
        return new PHPSession();
    }
}