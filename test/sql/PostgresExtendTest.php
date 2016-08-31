<?php
namespace sql;


class PostgresExtendTest extends \PHPUnit_Framework_TestCase
{

    protected $object = null;

    public function setup()
    {
        $this->object = new Order();
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf("sql\Postgres", $this->object);
    }

    public function testConfig()
    {
        $this->assertEquals(__FILE__, $this->object->config());
        $this->assertEquals(__FILE__, $this->object->config("name"));
        $this->assertEquals(__FILE__, $this->object->config("name", "value"));
        $this->assertEquals(__FILE__, $this->object->config(["name" => "value"]));
    }

}

class Data extends Postgres
{

    public function config($name = null, $value = null)
    {
        return __FILE__;
    }
}

class Order extends Data {}
