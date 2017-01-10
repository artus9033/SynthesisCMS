<?php

namespace App\SynthesisCMS\API;

use Illuminate\Http\Request;

abstract class RequestMethod
{
	const POST = "POST";
	const GET = "GET";
	const ANY = "ANY";
}

abstract class ResponseMethod
{
	const VIEW = "VIEW";
	const CONTROLLER = "CONTROLLER";
}

class SynthesisRouter {

	public $request;
	public $slug;
	public $module;

	private $routesGet = Array();
	private $routesPost = Array();

	/**
	* Contructor of the SynthesisRouter class
	* @param {Request} request the request
	* @param {string} mod module name
	* @return void
	*/
	function __construct($request, $slug, $parent, $mod) {
		$this->request = $request;
		$this->slug = $slug;
		$this->namespc = (new \ReflectionObject($parent))->getNamespaceName();
		$this->module = $mod;
	}

	/**
	* Get type of request
	* @return string
	*/
	function getType(){
		return $this->request->method();
	}

	/**
	* Register a new route
	* @param {RequestMethod} method method of the request, RequestMethod
	* @param {string} slug slug of the route
	* @return void
	*/
	function registerRoute($method, $slug, $type, $response, $params = ["api_sample" => "SynthesisCMS API"]){
		$slug = str_replace("\\", "/", $slug);
		if(!starts_with($slug, "/")){
			$slug_bak = $slug;
			$slug = "/" . $slug_bak;
		}
		switch($method){
			case RequestMethod::GET:
				if(!in_array($slug, $this->routesGet)){
					array_push($this->routesGet, [$slug, $type, $response, $params]);
				}else{
					abort(500, "SynthesisCMS internal error with module " . $this->module . ": 'route " . $slug . " with method " . $method . " already defined' thrown at SynthesisCMS/API/SynthesisRouter");
				}
				break;
				case RequestMethod::POST:
					if(!in_array($slug, $this->routesGet)){
						array_push($this->routesPost, [$slug, $type, $response, $params]);
					}else{
						abort(500, "SynthesisCMS internal error with module " . $this->module . ": 'route " . $slug . " with method " . $method . " already defined' thrown at SynthesisCMS/API/SynthesisRouter");
					}
					break;
		}
	}

	/**
	* Return a view if any matching the current url has been previously registered
	* or, if none matching found, return a 404 http error response
	* @return void
	*/
	function react(){
		$path = $this->request->path();
		$path = str_replace("\\", "/", $path);
		if(!starts_with($path, "/")){
			$path_bak = $path;
			$path = "/" . $path_bak;
		}
		$path = strtok($path, '/') . '/' . strtok('/');
		if(!starts_with($path, "/")){
			$path_bak = $path;
			$path = "/" . $path_bak;
		}
		if(ends_with($path, "/")){
			$path = substr($path, 0, -1);
		}
		$path = substr($path, strlen($this->slug));
		if(strlen($path) == 0){
			$path = "/";
		}
		switch($this->request->method()){
			case RequestMethod::GET:
				$found = false;
				$mKey;
				foreach ($this->routesGet as $key => $value) {
					if($value[0] == $path){
						$mKey = $key;
						$found = true;
					}
				}
				if($found){
					switch($this->routesGet[$mKey][1]){
						case ResponseMethod::VIEW:
							echo view($this->routesGet[$mKey][2])->with($this->routesGet[$mKey][3]);
						break;
						case ResponseMethod::CONTROLLER:
							echo \App::call($this->namespc . "\\" . $this->routesGet[$mKey][2], $this->routesGet[$mKey][3]);
						break;
					}
					exit;
				}
				break;

				case RequestMethod::POST:
					$found = false;
					$mKey;
					foreach ($this->routesPost as $key => $value) {
						if($value[0] == $path){
							$mKey = $key;
							$found = true;
						}
					}
					if($found){
						switch($this->routesPost[$mKey][1]){
							case ResponseMethod::VIEW:
								echo view($this->routesPost[$mKey][2])->with($this->routesPost[$mKey][3]);
							break;
							case ResponseMethod::CONTROLLER:
								echo \App::call($this->namespc . "\\" . $this->routesPost[$mKey][2], $this->routesPost[$mKey][3]);
							break;
						}
						exit;
					}
					break;
		}
		// If any view was found, exit was called; otherwise 404 will be thrown:
		abort(404);
	}
}
?>
