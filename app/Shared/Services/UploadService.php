<?php

namespace App\Shared\Services;

use Nyholm\Psr7\UploadedFile;

final class UploadService
{
    private $directory;
    /**
     * @var UploadedFile
     */
    private $uploadedFile;

    public function __construct($directory, UploadedFile $uploadedFile)
    {
        $this->directory = $directory;
        $this->uploadedFile = $uploadedFile;
    }

    private function checkDir(): bool
    {
        if (!is_dir($this->directory)) {
            return mkdir($this->directory, 0777, true);
        }

        return true;
    }

    public function upload(): ?string
    {
        if ($this->checkDir()) {
            $extension = pathinfo($this->uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
            $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
            $filename = sprintf('%s.%0.8s', $basename, $extension);

            $this->uploadedFile->moveTo($this->directory . DIRECTORY_SEPARATOR . $filename);

            return $filename;
        }

        return null;
    }
}
