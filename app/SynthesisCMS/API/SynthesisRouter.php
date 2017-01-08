<?php

namespace App\SynthesisCMS\API;

use Illuminate\Http\Request;

abstract class RequestMethod
{
    const POST = "POST";
    const GET = "GET";
    const ANY = "ANY";
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
	function __construct($request, $slug, $mod) {
		$this->request = $request;
		$this->slug = $slug;
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
	function registerRoute($method, $slug){
		$slug = str_replace("\\", "/", $slug);
		if(!starts_with($slug, "/")){
			$slug_bak = $slug;
			$slug = "/" . $slug_bak;
		}
		if($method == RequestMethod::GET){
			if(!in_array($slug, $this->routesGet)){
				array_push($this->routesGet, $slug);
			}else{
				abort(500, "SynthesisCMS internal error with module " . $this->module . ": 'route " . $slug . " with method " . $method . " already defined' thrown at SynthesisCMS/API/SynthesisRouter");
			}
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
		$path = substr($path, 2);
		echo($path);

		if($this->request->method() == RequestMethod::GET){
			if(in_array($path, $this->routesGet)){
				echo view('lithium::dummy');
				exit;
			}
		}

		if($this->request->method() == RequestMethod::POST){
			if(in_array($path, $this->routesPost)){
				echo view('lithium::dummy');
				exit;
			}
		}
		// If any view was found, exit was called, otherwise 404 will be thrown:
		abort(404);
	}
}
?>
