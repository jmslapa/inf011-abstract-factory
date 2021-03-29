<?php

namespace Plugins\Lang\Toolkits\Java\Models;

use Highlight\Highlighter as BaseHighlighter;
use Support\Contracts\Models\HighlighterContract;

class Highlighter implements HighlighterContract
{
    const LANG = 'java';

    private BaseHighlighter $highlighter;

    public function __construct()
    {
        $this->highlighter = new BaseHighlighter();
    }

    public function highlight(string $filePath): object
    {
        $code = file_get_contents($filePath);
        return $this->highlighter->highlight(self::LANG, $code);
    }
}
