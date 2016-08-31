<?php
namespace sql;


class Mysql implements DbInterface
{

    protected $config = [
        "host" => "localhost",
        "port" => 3306,
        "user" => "root",
        "pass" => "root",
        "db"   => "test",
    ];

    protected $connection = null;

    public static function fromConfig(array $config)
    {
        return new static($config);
    }

    public static function fromUrl($url)
    {
        $config = parse_url($url);
        $config["db"] = trim($config["path"], "/");
        return self::fromConfig($config);
    }

    public function __construct(array $config = [])
    {
        $this->config($config);
    }

    public function config($key = null, $value = null)
    {
        if ($key === null) {
            return $this->config;
        }

        if (is_array($key)) {
            $this->config = array_merge($this->config, $key);
            return;
        }

        if ($value === null) {
            return isset($this->config[$key]) ? $this->config[$key] : $default;
        }

        $old = $this->config[$key];
        $this->config[$key] = $value;

        return $old;
    }

    public function read($sql)
    {
        $rows = [];
        $res  = $this->exec($sql);
        while ($row = $res->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function write($sql)
    {
        $this->exec($sql);
        return $this->connection->affected_rows;
    }

    public function insertId()
    {
        return $this->connection->insert_id;
    }

    protected function connect()
    {
        if ($this->connection) {
            return;
        }

        $this->connection = new \mysqli(
            $this->config["host"],
            $this->config["user"],
            $this->config["pass"],
            $this->config["db"],
            $this->config["port"]
        );
    }

    protected function exec($sql)
    {
        $this->connect();

        $res = $this->connection->query($sql);
        if ($res === false) {
            throw new \RuntimeException(sprintf(
                "%s from query <%s>.",
                $this->connection->error,
                $sql
            ));
        }

        return $res;
    }

}
