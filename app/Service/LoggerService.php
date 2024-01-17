<?php
namespace Service;
class LoggerService
{
    public function error($throwable): bool|int
    {
        $file = '../Storage/logs/error.txt';
        $log = date('Y-m-d H:i:s') . ', ' . $throwable->getMessage() . ', file: ' . $throwable->getFile() . ', line: ' . $throwable->getLine();
        return file_put_contents(  $file, "\n" . $log, FILE_APPEND);
    }
}