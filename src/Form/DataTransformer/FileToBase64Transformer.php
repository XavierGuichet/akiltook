<?php 

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileToBase64Transformer implements DataTransformerInterface
{
    public function transform($value)
    {
    }

    public function reverseTransform($value)
    {
        $tmpFilePath = tempnam(sys_get_temp_dir(), 'allegato_');

        $tmp = fopen($tmpFilePath, 'wb+');

        $matches = [];
        preg_match('/^data:([\w-]+\/[\w-]+);base64,(.+)$/', $value, $matches);

        $size = fwrite($tmp, base64_decode($matches[2]));
        fclose($tmp);
        
        $name = preg_replace('/\./','_',uniqid('akiltook', true));
        $filename = $name.'.'.explode('/', $matches[1] )[1];        

        return new UploadedFile($tmpFilePath, $filename, $matches[1], $size, 0, true);
    }
}