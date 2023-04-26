<?php
namespace Mpm\Http;
use Mpm\Routing\Router;
use Mpm\Http\Response;
use Mpm\Http\Request;


class Kernel {
  
  public function handle(Request $request){
    $content = Router::run($request);
    return new Response(content:$content);
  }
  
  public static function make(){
    return new static;
  }
  
  /**
   * Middlewares 
   */
  public function middleware(){
    
  }
}