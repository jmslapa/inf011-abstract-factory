<?php

namespace Support\Contracts\Models;

interface CompilerContract
{
    public function compile(string $filePath) : string;
}
