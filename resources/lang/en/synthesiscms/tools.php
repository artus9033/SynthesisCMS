<?php

return [
	'tool_compile_cms_resources' => 'Compile CMS Resources',
	'toast_compilation_finished' => 'Compilation finished! Please read the compiler log.',
	'toast_error_trying_to_run_compiler' => 'Error while trying to run the compiler! Please try manually from the console...',
	'btn_compile_now' => 'Compile Resources',
	'btn_rebuild_node_sass_now' => 'Rebuild Node SASS',
	'tooltip_btn_rebuild_node_sass_now' => 'This may be necessary if You migrated the site to a new server, updated/changed the server OS, or resource compilation throws an error with the node SASS binding.',
	'btn_npm_install_now' => 'Install modules',
	'tooltip_btn_npm_install' => 'This simply runs `npm install`. It may be helpful if there are some errors while trying to compile resources or if You deleted the node_modules directory.',
	'btn_delete_node_modules_now' => 'Delete node_modules directory',
	'tooltip_btn_delete_node_modules_now' => 'Deletes the node_modules directory. WARNING: after this you will be unable to compile the resources unless you install the modules again. May be helpful when errors happen during compilation.',
	'header_compiler_log' => 'Compiler Log',
	'info_compilation_may_take_some_time' => 'Compilation may take some time. As soon as it finishes, it\'s result will be displayed here.',
	'toast_optimization_finished' => 'Optimization finished! Please read the optimizer log.',
	'toast_error_trying_to_run_optimizer' => 'Error while trying to run the optimizer...',
	'btn_optimize_now' => 'Optimize',
	'header_optimizer_log' => 'Optimizer Log',
	'info_optimization_may_take_some_time' => 'Optimization boosts performance of SynthesisCMS. It is advised when it takes much time for the server to respond (in simple words - when the website loads too long). Optimization can take some time. As soon as it finishes, it\'s result will be displayed here. NOTE: after optimization currently logged in users may be logged out.',
];

?>
