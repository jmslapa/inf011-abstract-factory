<?php

namespace Support\Contracts\Models;

interface HighlighterContract
{
    public function highlight(string $filePath) : object;
}