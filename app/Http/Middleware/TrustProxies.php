<?php
 
namespace App\Http\Middleware;
 
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class TrustProxies extends Middleware
{
    protected $proxies = '*';
    protected $headers = Request:: HEADER_X_FORWARDED_AWS_ELB;
}