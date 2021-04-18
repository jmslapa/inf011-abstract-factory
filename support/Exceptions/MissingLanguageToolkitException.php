<?php

namespace Support\Exceptions;

use Support\Abstracts\Exception\BaseException;

class MissingLanguageToolkitException extends BaseException
{
    public function __construct($message)
    {
        parent::__construct($message, 1);
    }
}
