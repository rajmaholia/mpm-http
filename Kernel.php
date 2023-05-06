<?php
namespace Mpm\Http;
use Mpm\Routing\Router;
use Mpm\Http\Response;
use Mpm\Http\Request;


class Kernel {
  
  
  /**
   * @param array $middlewares 
   */
  private $middlewares = [];
  
  /**
   * Reference Class Object 
   */
  private static $obj;
  
  private function __construct(){
    
  }
  
  public function handle(Request $request){
    $request = $this->middleware($request);
   
    if($request instanceof Response) {
      return $request;
    }
    
    $content = Router::run($request);
    return new Response(content:$content);
  }
  
  public static function make(){
    if(!isset(self::$obj)) self::$obj = new static;
    return self::$obj;
  }
  
  /**
   * Middlewares 
   */
  public function middleware(Request &$request){
    foreach($this->middlewares as $name=>$handler){
      $handler = new ($handler);
      $request_or_response = $handler->handle($request);
      if($request_or_response instanceof Response) return $request_or_response;
      else $request = $request_or_response;
    }
    return $request;
  }
  
  public function addMiddleware($name,$middleware){
    $this->$middlewares[$name] = $middleware;
    return $this;
  }
  
  public static function middlewares(array $middlewares){
    self::make();
    self::$obj->middlewares = $middlewares;
    return self::$obj;
  }
  
  public function terminate($request,$response){
      return;
  }
}