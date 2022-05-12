<?php 
namespace TCF\Cache;

class FileSystem extends Driver {

    protected $path;
    protected $directory;

    public function __construct($config){
        $this->configure($config);
        
        if(!$this->path){
           $this->setPath();
        }

        $this->checkPath();
    }

    public function configure($config){
        $config = array_merge([
            'directory' => 'tcf-cache',
        ], $config);

        $this->directory = $config['directory'];

        if(!empty($config['path'])){
            $this->path = $config['path'];
        }

        parent::configure($config);
    }

    public function setPath(){
        $this->path = realpath( get_template_directory() . '/../../') . '/' . $this->directory . '/';
    }

    public function checkPath(){
        if( !is_dir($this->path) && !mkdir($this->path, 0775, true) ){
            throw new \Exception(static::class .'::setPath(), could not create cache directory: ' . $path);
        }
    }

    public function getFilename($key){
        return $this->path . $this->prefix . $this->prepareKey($key) . '.json';
    }

    public function set($key, $value, $ttl = null){
        return file_put_contents($this->getFilename($key), json_encode([
			'ttl' => $ttl ?: $this->ttl,
			'data' => $this->encodeValue($value),	
		]));
    }
    public function get($key){
        $file = $this->getFilename($key);

        if( is_file($file) ){
            $json = json_decode( file_get_contents($file), 1 );
            if( $json['ttl'] < time() ){
                $this->clear($key);
                return false;
            }

            return $this->decodeValue($json['data']);
        }

        return false;
    }
    public function clear($key = null){
        if($key){
            $file = $this->getFilename($key);
            if( is_file( $file ) ){
                unlink($file);
            }
            return true;
        }

        $this->clearAll();
    }

    public function clearAll(){
        array_map('unlink', array_filter((array) glob($this->path . "*")));
    }
}
