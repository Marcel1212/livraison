<?php

namespace App\Logging;
use Monolog\Logger;

class AuditLogger
{
    public function __invoke(array $config): Logger
    {
        $logger = new Logger("AuditLoggingHandler");
        return $logger->pushHandler(new AuditLoggingHandler());
    }
}
