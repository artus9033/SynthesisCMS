<?php

namespace App\SynthesisCMS\API\Positions;

use App\SynthesisCMS\API\Positions\SynthesisPositions;

class SynthesisPositionManager
{

	function __construct(){
		$class = new \ReflectionClass('App\\SynthesisCMS\\API\\Positions\\SynthesisPositions');
		$staticMembers = $class->getStaticProperties();
		$this->standardPositions = array_fill(1, count($staticMembers), array());
	}

	/**
	* Function to register a standard position
	* @param $position SynthesisPosition::const name of position
	* @param $callbackFunction this callback this reference
	* @param $callbackFunction String callback function name
	* @return nothing
	**/
	public function addStandard($position, $callbackClass, $callbackFunction){
		array_push($this->standardPositions, [$position, $callbackClass, $callbackFunction]);
	}

	/**
	* Function to register a position defined in a custom extension
	* @param $extension String source extension that defines the position
	* @param $name String name of the position
	* @param $callback callback function
	* @return nothing
	**/
	public function addCustom($extension, $name, $callback){
		// TODO: implement this
	}

	/**
	* Function to retrieve a standard position
	* @param $position SynthesisPosition::const name of position
	* @return String all registered hooks' output
	**/
	public function getStandard($position, $slug){
		$out = "";
		foreach($this->standardPositions as $ref){
			$pos = $ref[0];
			if($pos == $position){
				$class = $ref[1];
				$func = $ref[2];
				$out .= $class->$func($slug);
			}
		}
		return $out;
	}

	/**
	* Function to retrieve a standard position
	* @param $position String name of position
	* @return String all registered hooks' output
	**/
	public function getCustom($position){
		//TODO: implement this
	}
}
