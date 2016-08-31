<?php
namespace sql;


class Postgres implements DbInterface
{

    protected $config = [
        // "host" => "localhost",
        // "port" => 5432,
        // "user" => "root",
        // "pass" => "root",
        // "db"   => "test",
        "host" => "horton.elephantsql.com",
        "port" => 5432,
        "user" => "xlsamzvk",
        "pass" => "FvHV2xFsgi_KTkSOWGjhQ_nCYdwbAFdr",
        "db"   => "xlsamzvk",
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
        while ($row = \pg_fetch_assoc($res)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function write($sql)
    {
        $res = $this->exec($sql);
        return \pg_affected_rows($res);
    }

    public function insertId()
    {
        return \pg_last_oid($this->res);
    }

    protected function connect()
    {
        if ($this->connection) {
            return;
        }

        $this->connection = \pg_connect(sprintf(
            "host=%s port=%d user=%s password=%s dbname=%s",
            $this->config["host"],
            $this->config["port"],
            $this->config["user"],
            $this->config["pass"],
            $this->config["db"]
        ));
    }

    protected function exec($sql)
    {
        $this->connect();

        try {
            $this->res = \pg_query($this->connection, $sql);
            if ($this->res === false) {
                throw new \RuntimeException(sprintf(
                    "%s from query <%s>.",
                    \pg_last_error($this->connection),
                    $sql
                ));
            }
        } catch (\Exception $e) {
            throw new \RuntimeException(sprintf(
                "Error: %s from query <%s>.",
                $e->getMessage(),
                $sql
            ));
        }

        return $this->res;
    }

}
