<?php
namespace Mpm\Http;

class Request {
  /**
   * @var string 
   * 
   */
    public  $method;
    
    /**
     * @var string
     */
    public $uri;
     
    /** 
     * 
     * Request Headers 
     * 
     * @var array
     */
    private $headers;
    
    /**
     * @var string
     */
    protected $body;
    
   /** 
    * Equivalent to $_POST
    * @var array 
    */
    public  $post;
    
    /**
     * Equivalent to $_GET 
     * 
     * @var Array 
     * 
     */
    public  $get;
    
    /**
     * Equivalent to $_SERVER 
     * 
     * @var array 
     */
    public  $server;
    
    /**
     * Equivalent to $_COOKIE
     * @var array 
     */
    public  $cookies;
    
    /** 
     * Equivalent to $_ENV
     * 
     * @var array
     */
    public  $env;
    
    /**
     * Current User
     * 
     * @var array 
     * 
     */
    public  $user;
    
    /**
     * Equivalent to $_FILES 
     * 
     * @var array 
     */
     public $files;

    public function __construct($method, $uri, $headers, $body) {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
        $this->post = $_POST;
        $this->get = $_GET;
        $this->cookies = $_COOKIE;
        $this->server = (object)$_SERVER;
        $this->env = (object)$_ENV;
        $this->files = (object)$_FILES;
        //$this->user = (object)$_SESSION["user"];
    }
    
    public function getMethod() {
        return $this->method;
    }
    
    public function method(){
      return $this->method;
    }

    public function getUri() {
        return $this->uri;
    }
    
    public function uri(){
      return $this->uri;
    }

    public function getHeaders() {
        return $this->headers;
    }
    
    public function headers(){
      return $this->headers;
    }
    
    public function getBody() {
        return $this->body;
    }
    
    public function getFiles(){
      return $this->files;
    }
    
    public function files(){
      return $this->getFiles();
    }
    
    public function isAjax() {
        return isset($this->headers['X-Requested-With']) && $this->headers['X-Requested-With'] === 'XMLHttpRequest';
    }
    
    
    public static function init(){
      return new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], getallheaders(), file_get_contents('php://input'));
    }
}