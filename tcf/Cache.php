<?php 
namespace TCF;

class Cache {

    protected static $instance;
    
    protected $driver;
    protected $config;

    public function __construct($driver, $config){
        $this->setConfig($config);
        $this->setDriver($driver);
    }
    public function setDriver($driver){
        if( is_string($driver) ){
            if( !class_exists($driver) ){
                $driver = "TCF\\Cache\\$driver";
            }
            $driver = new $driver($this->config);
        }

        $this->driver = $driver;
    }
    public function setConfig($config){
        $this->config = array_merge([
            'ttl' => strtotime('+ 1 day'),
            'prefix' => 'tcf_',
        ], $config);
    }

    public static function init($driver, $config = []){
        return static::$instance = new static($driver, $config);
    }

    public static function getInstance(){
        if( !static::$instance ){
            throw new \Exception(static::class . ' has not been initiated');
        }

        return static::$instance;
    }

    public static function __callStatic($method, $args){
        $instance = static::getInstance();
        if( method_exists($instance->driver, $method) ){
            return call_user_func_array([$instance->driver, $method], $args);
        }

        throw new \Exception(static::class . '::' . $method . '(), method does not exist');
    }
}
