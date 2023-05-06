<?php
namespace Mpm\Http\Middleware;
use Mpm\Http\Response;

class CsrfMiddleware {
  
    public function handle($request)
    {
        if ($this->isReading($request)) {
          $_SESSION['token'] = bin2hex(random_bytes(35));
          return $request;
        }

        
        if (!$this->tokensMatch($request)) {
          return new Response("Invalid Request",403);
        }

        return $request;
    }

    protected function isReading($request)
    {
      return in_array($request->method(), ['HEAD', 'GET', 'OPTIONS']);
    }
    
    protected function tokensMatch($request)
    { 
      
      return ($request->input('csrf_token')!=null && isset($_SESSION["token"]))
            ? $request->input('csrf_token')==$_SESSION["token"]
            : false;
      
    }
}
