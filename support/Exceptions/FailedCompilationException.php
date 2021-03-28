<?php

namespace Support\Exceptions;

use Support\Abstracts\Exception\BaseException;

class FailedCompilationException extends BaseException
{
    private string $error;

    public function __construct($message, $error = '')
    {
        parent::__construct($message, 1);
        $this->error = $error;
    }
}