<?php
namespace Mpm\Http;

class Request {
  /**
   * @var string 
   * 
   */
    private  $method;
    
    /**
     * @var string
     */
    private $uri;
     
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
    private  $post;
    
    /**
     * Equivalent to $_GET 
     * 
     * @var Array 
     * 
     */
    private  $get;
    
    /**
     * Equivalent to $_REQUEST 
     */
     private $input;
     
     
    /**
     * Equivalent to $_SERVER 
     * 
     * @var array 
     */
    private  $server;
    
    /**
     * Equivalent to $_COOKIE
     * @var array 
     */
    private  $cookies;
    
    /** 
     * Equivalent to $_ENV
     * 
     * @var array
     */
    private  $env;
    
    /**
     * Current User
     * 
     * @var array 
     * 
     */
    private  $user;
    
    /**
     * Equivalent to $_FILES 
     * 
     * @var array 
     */
     private $files;
    
    /**
     * Session
     */
    private $session;
    
    public function __construct($method, $uri, $headers, $body) {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
        $this->post = (object)$_POST;
        $this->get = (object)$_GET;
        $this->input = $_REQUEST;
        $this->cookies = $_COOKIE;
        $this->server = (object)$_SERVER;
        $this->env = (object)$_ENV;
        $this->files = (object)$_FILES;
        
    }
/*
  public function __call($name, $arguments)
    {
        return call_user_func($this->{$name}, $arguments);
    }*/
    
    public function getMethod() {
        return $this->method;
    }
    
    public function method(){
      return $this->method;
    }
    
    public function uri(){
      return $this->uri;
    }
    
    public function cookies(){
      return $this->cookies;
    }
    
    public function server(){
      return $this->server;
    }
    
    public function body(){
      return $this->body;
    }
    
    public function post($arg=null){
     if($arg==null) return $this->post;
     else return $this->post->$arg;
    }
    
    public function get(){
      return $this->get;
    }
    
    public function input($arg=null){
      if($arg==null) return $this->input;
      else return isset($this->input[$arg])?$this->input[$arg]:null;
    }
    
    public function env(){
      return $this->env;
    }
    
    public function getUri() {
        return $this->uri;
    }
    
   public function user(){
     return isset($_SESSION["user"])?(object)$_SESSION["user"]:null;
   }

    public function getHeaders() {
        return $this->headers;
    }
    
    public function session(){
      return $this->session;
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
    
    public function addMethod($name, $method)
    {
        $this->{$name} = $method;
    }
}