<?php
namespace sql;


class MysqlExtendTest extends \PHPUnit_Framework_TestCase
{

    protected $object = null;

    public function setup()
    {
        $this->object = new Cart();
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf("sql\Mysql", $this->object);
    }

    public function testConfig()
    {
        $this->assertEquals(__FILE__, $this->object->config());
        $this->assertEquals(__FILE__, $this->object->config("name"));
        $this->assertEquals(__FILE__, $this->object->config("name", "value"));
        $this->assertEquals(__FILE__, $this->object->config(["name" => "value"]));
    }

}

class Dao extends Mysql
{

    public function config($name = null, $value = null)
    {
        return __FILE__;
    }
}

class Cart extends Dao {}
