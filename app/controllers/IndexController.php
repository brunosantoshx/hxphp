<?php
namespace App\Controllers;

use HXPHP\System\Controller;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    public function testAction()
    {
    	$response = new Response();

		$response->setContent(json_encode(array(
		    'data' => new \stdClass(),
		)));
		
		$response->headers->set('Content-Type', 'application/json');

		return $response;
    }
}