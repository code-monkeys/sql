<?php
namespace sql;


class MysqlTest extends \PHPUnit_Framework_TestCase
{

    protected $object = null;

    public function setup()
    {
        $this->object = new Mysql();
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf("sql\Mysql", $this->object);
    }

    public function testConfigGetArray()
    {
        $return = $this->object->config();
        $this->assertTrue(is_array($return));
        $this->assertTrue(isset($return["user"]));
    }

    public function testConfigGetOneValue()
    {
        $return = $this->object->config("user");
        $this->assertNotNull($return);
    }

    public function testConfigMergeArray()
    {
        $name  = "user";
        $value = __FILE__;
        $this->object->config([$name => $value]);
        $this->assertEquals($value, $this->object->config($name));
    }

    public function testConfigOneValue()
    {
        $name  = "host";
        $value = "test";
        $this->object->config($name, $value);
        $this->assertEquals($value, $this->object->config($name));
    }

    public function testConfigSetGetOldValue()
    {
        $name = "host";
        $old  = "old";
        $new  = "new";

        $ignored  = $this->object->config($name, $old);
        $returned = $this->object->config($name, $new);
        $this->assertEquals($old, $returned);
    }

    public function testFromUrl()
    {
        $url = "mysql://username:passord@some-host:3344/some-db";
        $obj = Mysql::fromUrl($url);

        $this->assertEquals("username",   $obj->config("user"));
        $this->assertEquals("passord",    $obj->config("pass"));
        $this->assertEquals("some-host",  $obj->config("host"));
        $this->assertEquals(3344,         $obj->config("port"));
        $this->assertEquals("some-db",    $obj->config("db"));
    }

    public function testCrud()
    {
        $this->object->write("DROP TABLE IF EXISTS tests");

        $sql = "CREATE TABLE tests (a INT, b CHAR(10))";
        $num = $this->object->write($sql);
        $this->assertEquals(0, $num);

        $sql = "INSERT INTO tests VALUES (1, 'OK')";
        $num = $this->object->write($sql);
        $this->assertEquals(1, $num);

        $sql = "SELECT * FROM tests";
        $arr = $this->object->read($sql);
        $this->assertEquals([["a" => 1, "b" => "OK"]], $arr);

        $this->object->write("DROP TABLE IF EXISTS tests");
    }

    /**
     * @expectedException RuntimeException
     */
    public function testNonExistingTable()
    {
        $sql = "SELECT * FROM tests_123";
        $arr = $this->object->read($sql);
    }

}
