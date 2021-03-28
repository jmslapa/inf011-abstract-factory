<?php

namespace Plugins\Lang\Toolkits\Java\Models;

use Support\Contracts\Models\CompilerContract;
use Support\Exceptions\FailedCompilationException;

class Compiler implements CompilerContract
{
    public function compile(string $filePath): string
    {
        exec("javac $filePath", $output, $error);
        
        if($error) {
            throw new FailedCompilationException('Não foi possível compilar o arquivo .java', $error);
        }

        return str_replace('.java', '.class', $filePath);
    }
}