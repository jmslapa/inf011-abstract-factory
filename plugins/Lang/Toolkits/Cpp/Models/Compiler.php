<?php

namespace Plugins\Lang\Toolkits\Cpp\Models;

use Support\Contracts\Models\CompilerContract;
use Support\Exceptions\FailedCompilationException;

class Compiler implements CompilerContract
{
    public function compile(string $filePath): string
    {
        $outputFileName = str_replace('.cpp', '', $filePath);

        exec("g++ $filePath -o $outputFileName", $output, $error);
        if ($error) {
            throw new FailedCompilationException('Could not compile the .cpp file.', $error);
        }

        return $outputFileName;
    }
}
