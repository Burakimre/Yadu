<?php
namespace App\Traits;

trait CrossEnvironmentDirectoryNames
{
    public function FormatDirectoryName($separator, $path)
    {
        return str_replace($separator, DIRECTORY_SEPARATOR, $path);
    }
}