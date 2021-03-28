<?php

namespace Support\Abstracts\Exception;

use Highlight\Highlighter;
use RuntimeException;

abstract class BaseException extends RuntimeException
{
    public function getError() : string
    {
        return $this->error;
    }

    public function content()
    {
        require_once src('/app/Views/exceptions/default.phtml');
    }

    public function render()
    {
        $highlighter = new Highlighter();

        $code = print_r($this, true);

        $this->view->highlighted = $highlighter->highlight('php', $code);

        require_once src('app/Views/layouts/default.phtml');
    }
}