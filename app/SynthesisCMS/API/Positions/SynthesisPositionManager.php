<?php

namespace App\SynthesisCMS\API\Positions;

class SynthesisPositionManager
{

	/**
	 * Class constructor
	 **/
	public function __construct()
	{
		$class = new \ReflectionClass('App\\SynthesisCMS\\API\\Positions\\SynthesisPositions');
		$staticMembers = $class->getStaticProperties();
		$this->standardPositions = array_fill(1, count($staticMembers), array());
		$this->customPositions = [];
	}

	/**
	 * Function to register a standard position
	 * @param $position SynthesisPosition::const name of position
	 * @param $callbackClass $this callback class reference
	 * @param $callbackFunction String callback function name
	 * @return nothing
	 **/
	public function addStandard($position, $callbackClass, $callbackFunction)
	{
		array_push($this->standardPositions, [$position, $callbackClass, $callbackFunction]);
	}

	/**
	 * Function to register a position defined in a custom extension
	 * @param $extension String source extension that defines the position
	 * @param $name String name of the position
	 * @param $callbackClass $this callback class reference
	 * @param $callbackFunction String callback function name
	 * @return nothing
	 **/
	public function addCustom($extension, $name, $callbackClass, $callbackFunction)
	{
		array_push($this->customPositions, [$extension, $name, $callbackClass, $callbackFunction]);
	}

	/**
	 * Function to retrieve a standard position
	 * @param $position SynthesisPosition::const name of position
	 * @param $slug String current URL
	 * @return String all registered hooks' output
	 **/
	public function getStandard($position, $slug)
	{
		$out = "";
		foreach ($this->standardPositions as $ref) {
			$pos = $ref[0];
			if ($pos == $position) {
				$class = $ref[1];
				$func = $ref[2];
				$out .= $class->$func($slug);
			}
		}
		return $out;
	}

	/**
	 * Function to retrieve a standard position
	 * @param $positionName String name of extension which defines the position
	 * @param $positionName String name of position
	 * @param $params Array parameters for target function
	 * @return String all registered hooks' output
	 **/
	public function getCustom($extensionName, $positionName, $params = [])
	{
		$out = "";
		foreach ($this->customPositions as $ref) {
			if ($ref[0] == $extensionName && $ref[1] == $positionName) {
				$class = $ref[2];
				$func = $ref[3];
				$out .= call_user_func_array(array($class, $func), $params);
			}
		}
		return $out;
	}
}
