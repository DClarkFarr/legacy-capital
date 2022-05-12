<?php

namespace TCF;

class Pdo
{
    private static $instance;

    private $pdo;
    private function __construct()
    {
        $host = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $this->pdo = new \PDO($host, DB_USER, DB_PASSWORD);
    }

    public function pdo()
    {
        return $this->pdo;
    }

    public static function __callStatic($method, $args)
    {
        $instance = static::getInstance();

        if (method_exists($instance->pdo, $method)) {
            return call_user_func_array([$instance->pdo, $method], $args);
        }

        throw new \Exception(static::class . ' does not have method: ' . $method);
    }

    public function __call($method, $args)
    {
        if (method_exists($this->pdo, $method)) {
            return call_user_func_array([$this->pdo, $method], $args);
        }

        throw new \Exception(static::class . ' does not have method: ' . $method);
    }

    public static function getInstance()
    {
        if (static::$instance) {
            return static::$instance;
        }

        return static::$instance = new static;
    }

    private function __wakeup()
    {
    }
    private function __clone()
    {
    }
}
