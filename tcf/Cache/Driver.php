<?php 
namespace TCF\Cache;

abstract class Driver {

    protected $ttl;
    protected $prefix;

    abstract function set($key, $value, $ttl = null);

    abstract function get($key);

    abstract function clear($key = null);

    abstract function clearAll();

    public function configure($config){
        $this->ttl = !empty($config['ttl']) ? $config['ttl'] : strtotime('+ 1 day');
        $this->prefix = !empty($config['prefix']) ? $config['prefix'] : '';
    }

    public function prepareKey($key){
        $key = preg_replace('/[^a-z0-9_]/', '_', strtolower(trim($key)));
        $key = trim(preg_replace('/_{2,}/', '_', $key), '_');

        return $key;
    }
    public function encodeValue($value){
        return serialize($value);
    }
    public function decodeValue($value){
        return unserialize($value);
    }
}