<?php

Route::get('/admin', ['as' => 'admin', 'uses' => 'Backend\\BackendController@index']);

Route::get('/admin/uploads_list', ['as' => 'list', 'uses' => 'Backend\\SynthesisFilesystemController@files_list']);
Route::post('/admin/upload', ['as' => 'upload', 'uses' => 'Backend\\SynthesisFilesystemController@uploadPost']);

Route::post('/synthesis-route-check', ['as' => 'synthesis_route_check', 'uses' => 'Content\\RouteController@checkRoute']);

Route::post('/admin/file-picker', function (\App\Http\Requests\BackendRequest $request) {
	return view('partials/file-picker')->with(['picker_modal_id' => $request->get('picker_modal_id'), 'callback_function_name' => $request->get('callback_function_name'), 'followIframeParentHeight' => $request->get('followIframeParentHeight'), 'fileExtensions' => $request->get('fileExtensions')])->render();
});

Route::get('/admin/manage_routes', ['as' => 'manage_routes', 'uses' => 'Content\\RouteController@manageRoutesGet']);
Route::get('/admin/manage_routes/edit/{id}', ['as' => 'manage_routes_edit', 'uses' => 'Content\\RouteController@editRouteGet']);
Route::post('/admin/manage_routes/edit/{id}', ['as' => 'manage_routes_edit_post', 'uses' => 'Content\\RouteController@editRoutePost']);
Route::get('/admin/manage_routes/delete/{id}', ['as' => 'manage_routes_delete', 'uses' => 'Content\\RouteController@deleteRoute']);
Route::get('/admin/manage_routes/create_route', ['as' => 'create_route', 'uses' => 'Content\\RouteController@createRouteGet']);
Route::post('/admin/manage_routes/create_route', ['as' => 'create_route_post', 'uses' => 'Content\\RouteController@createRoutePost']);

Route::get('/admin/manage_molecules', ['as' => 'manage_molecules', 'uses' => 'Content\\MoleculeController@manageMoleculesGet']);
Route::get('/admin/manage_molecules/delete/{id},{articles}', ['as' => 'manage_molecules_delete', 'uses' => 'Content\\MoleculeController@deleteMolecule']);
Route::get('/admin/manage_molecules/edit/{id}', ['as' => 'manage_molecules_edit', 'uses' => 'Content\\MoleculeController@editMoleculeGet']);
Route::post('/admin/manage_molecules/edit/{id}', ['as' => 'manage_molecules_edit_post', 'uses' => 'Content\\MoleculeController@editMoleculePost']);
Route::post('/admin/manage_molecules/mass_delete', ['as' => 'manage_molecules_mass_delete_post', 'uses' => 'Content\\MoleculeController@massDeleteMolecule']);
Route::post('/admin/manage_molecules/mass_copy/{childrenArticlesToo}', ['as' => 'manage_molecules_mass_copy_post', 'uses' => 'Content\\MoleculeController@massCopyMolecule']);
Route::get('/admin/manage_molecules/create_molecule', ['as' => 'create_molecule', 'uses' => 'Content\\MoleculeController@createMoleculeGet']);
Route::post('/admin/manage_molecules/create_molecule', ['as' => 'create_molecule_post', 'uses' => 'Content\\MoleculeController@createMoleculePost']);

Route::get('/admin/manage_articles', ['as' => 'manage_articles', 'uses' => 'Content\\ArticleController@manageArticlesGet']);
Route::get('/admin/manage_articles/delete/{id}', ['as' => 'manage_articles_delete', 'uses' => 'Content\\ArticleController@deleteArticle']);
Route::post('/admin/manage_articles/mass_delete', ['as' => 'manage_articles_mass_delete_post', 'uses' => 'Content\\ArticleController@massDeleteArticle']);
Route::post('/admin/manage_articles/mass_copy', ['as' => 'manage_articles_mass_copy_post', 'uses' => 'Content\\ArticleController@massCopyArticle']);
Route::post('/admin/manage_articles/mass_move/{molecule}', ['as' => 'manage_articles_mass_move_post', 'uses' => 'Content\\ArticleController@massMoveArticle']);
Route::get('/admin/manage_articles/edit/{id}', ['as' => 'manage_articles_edit', 'uses' => 'Content\\ArticleController@editArticleGet']);
Route::post('/admin/manage_articles/edit/{id}', ['as' => 'manage_articles_edit_post', 'uses' => 'Content\\ArticleController@editArticlePost']);
Route::get('/admin/manage_articles/create_article', ['as' => 'create_article', 'uses' => 'Content\\ArticleController@createArticleGet']);
Route::post('/admin/manage_articles/create_article', ['as' => 'create_article_post', 'uses' => 'Content\\ArticleController@createArticlePost']);

Route::get('/admin/user-privileges/{id}', ['as' => 'profile', 'uses' => 'Auth\\ProfileController@privilegesGet']);
Route::post('/admin/user-privileges/{id}', ['as' => 'profile_post', 'uses' => 'Auth\\ProfileController@changePrivilegesGet']);
Route::get('/admin/manage_users', ['as' => 'manage_users', 'uses' => 'Auth\\ProfileController@manageUsersGet']);
Route::post('/admin/manage_users', ['as' => 'manage_users_post', 'uses' => 'Auth\\ProfileController@manageUsersPost']);

Route::get('/admin/settings', ['as' => 'settings', 'uses' => 'Backend\\BackendController@settingsGet']);
Route::post('/admin/settings', ['as' => 'settings_post', 'uses' => 'Backend\\BackendController@settingsPost']);

Route::get('/admin/manage_applets', ['as' => 'manage_applets', 'uses' => 'Backend\\BackendController@manageAppletsGet']);
Route::get('/admin/manage_applets/{extension}', ['as' => 'applet_settings', 'uses' => 'Backend\\BackendController@appletSettingsGet']);
Route::post('/admin/manage_applets/{extension}', ['as' => 'applet_settings_post', 'uses' => 'Backend\\BackendController@appletSettingsPost']);

?>
