<?php
 
namespace App\Http\Middleware;
 
use Illuminate\Http\Request;
use Inertia\Middleware;
 
class TrustProxies extends Middleware
{
    protected $proxies = '*';
    protected $headers = Request:: HEADER_X_FORWARDED_AWS_ELB;
}