<?php
namespace App\Http\Services;
use Archive7z\Archive7z;

class Archive7zService extends Archive7z
{
    protected ?float $timeout = 1200.0;
    protected int $compressionLevel = 9;
    protected string $overwriteMode = self::OVERWRITE_MODE_S;
    protected string $outputDirectory = '';
}
