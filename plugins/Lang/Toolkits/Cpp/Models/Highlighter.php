<?php

namespace Plugins\Lang\Toolkits\Cpp\Models;

use Highlight\Highlighter as BaseHighlighter;
use Support\Contracts\Models\HighlighterContract;

class Highlighter implements HighlighterContract
{
    const LANG = 'cpp';

    private $highlighter;

    public function __construct()
    {
        $this->highlighter = new BaseHighlighter;
    }

    public function highlight(string $filePath): object
    {
        $code = file_get_contents($filePath);
        return $this->highlighter->highlight(self::LANG, $code);
    }
}