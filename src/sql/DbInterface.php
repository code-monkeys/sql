<?php
namespace sql;


interface DbInterface
{
    public static function fromConfig(array $config);
    public static function fromUrl($url);

    public function read($sql);
    public function write($sql);
    public function config($key = null, $value = null);
}
