<?php

namespace App\SynthesisCMS\API\Extensions;

abstract class SynthesisExtensionType
{
	const Module = 1; // Modules are assigned to Pages
	const Applet = 2; // Applets are not assigned to anything, they work as part of the SynthesisCMS server
	const Both = 3; // This type combines both functionalities, so the extension is both a Module and an Applet in the same time
}

?>
