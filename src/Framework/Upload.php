<?php
namespace Framework;

use Aura\Router\Rule\Path;
use GuzzleHttp\Psr7\UploadedFile;
use Psr\Http\Message\UploadedFileInterface;

class Upload{
    protected $path;

    protected $formats;

    public function __construct(?string $path = null)
    {
        if (!is_null($path)) {
            $this->path = $path;
        }
    }

    public function upload(UploadedFileInterface $file):string
    {
        $filename = $file->getClientFilename();

        $targetPath = $this->addSuffix($this->path . '/' . $filename);

        $file->moveTo($targetPath);

        return pathinfo($targetPath)['basename'];
    }

    public function addSuffix(string $target):string 
    {
        if(file_exists($target)){
            $info = pathinfo($target);

            $target = $info['dirname'] . '/' . $info['filename'] . '_copy.' . $info['extension'];

            return $this->addSuffix($target);
        }
        return $target;
    }
}