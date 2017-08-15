<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 13.08.2017
 * Time: 16:36
 */

namespace App\Extensions\Ferrum;


class FerrumIdManager
{
	/**
	 * Class constructor
	 **/
	public function __construct()
	{
		$this->ferrumIdRandomizedPart = str_random(10);
		$this->ferrumIdCounter = 0;
		$this->ferrumIdsTable = Array();
	}


	public function ferrumGenerateNextUniqueId()
	{
		$this->ferrumIdCounter++;
		$newUniqueId = $this->ferrumIdRandomizedPart . $this->ferrumIdCounter;
		array_push($this->ferrumIdsTable, $newUniqueId);
		return $newUniqueId;
	}

	public function ferrumGetCurrentUniqueId()
	{
		return $this->ferrumIdRandomizedPart . $this->ferrumIdCounter;
	}

	public function ferrumGetAllIdsAsJson()
	{
		return json_encode($this->ferrumIdsTable);
	}
}