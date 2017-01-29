<?php

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/backend', function () {
    return redirect('/admin');
});

Route::group(['middleware' => 'admin'], function () {
	Route::get('/admin', ['as' => 'admin', 'uses' => 'BackendController@index']);

	Route::get('/admin/manage_users', ['as' => 'manage_users', 'uses' => 'BackendController@manageUsersGet']);
     Route::post('/admin/manage_users', ['as' => 'manage_users_post', 'uses' => 'BackendController@manageUsersPost']);

	Route::get('/admin/manage_routes', ['as' => 'manage_routes', 'uses' => 'BackendController@manageRoutesGet']);
	Route::get('/admin/manage_routes/edit/{id}', ['as' => 'manage_routes_edit', 'uses' => 'BackendController@editRouteGet']);
	Route::post('/admin/manage_routes/edit/{id}', ['as' => 'manage_routes_edit_post', 'uses' => 'BackendController@editRoutePost']);
	Route::get('/admin/manage_routes/delete/{id}', ['as' => 'manage_routes_delete', 'uses' => 'BackendController@deleteRoute']);
	Route::get('/admin/manage_routes/create_route', ['as' => 'create_route', 'uses' => 'BackendController@createRouteGet']);
	Route::post('/admin/manage_routes/create_route', ['as' => 'create_route_post', 'uses' => 'BackendController@createRoutePost']);

	Route::get('/admin/manage_molecules', ['as' => 'manage_molecules', 'uses' => 'BackendController@manageMoleculesGet']);
	Route::get('/admin/manage_molecules/delete/{id},{atoms}', ['as' => 'manage_molecules_delete', 'uses' => 'BackendController@deleteMolecule']);
	Route::get('/admin/manage_molecules/edit/{id}', ['as' => 'manage_molecules_edit', 'uses' => 'BackendController@editMoleculeGet']);
	Route::post('/admin/manage_molecules/edit/{id}', ['as' => 'manage_molecules_edit_post', 'uses' => 'BackendController@editMoleculePost']);
	Route::post('/admin/manage_molecules/mass_delete', ['as' => 'manage_molecules_mass_delete_post', 'uses' => 'BackendController@massDeleteMolecule']);
	Route::post('/admin/manage_molecules/mass_copy/{childrenAtomsToo}', ['as' => 'manage_molecules_mass_copy_post', 'uses' => 'BackendController@massCopyMolecule']);
	Route::get('/admin/manage_molecules/create_molecule', ['as' => 'create_molecule', 'uses' => 'BackendController@createMoleculeGet']);
	Route::post('/admin/manage_molecules/create_molecule', ['as' => 'create_molecule_post', 'uses' => 'BackendController@createMoleculePost']);

	Route::get('/admin/manage_atoms', ['as' => 'manage_atoms', 'uses' => 'BackendController@manageAtomsGet']);
	Route::get('/admin/manage_atoms/delete/{id}', ['as' => 'manage_atoms_delete', 'uses' => 'BackendController@deleteAtom']);
	Route::post('/admin/manage_atoms/mass_delete', ['as' => 'manage_atoms_mass_delete_post', 'uses' => 'BackendController@massDeleteAtom']);
	Route::post('/admin/manage_atoms/mass_copy', ['as' => 'manage_atoms_mass_copy_post', 'uses' => 'BackendController@massCopyAtom']);
	Route::post('/admin/manage_atoms/mass_move/{molecule}', ['as' => 'manage_atoms_mass_move_post', 'uses' => 'BackendController@massMoveAtom']);
	Route::get('/admin/manage_atoms/edit/{id}', ['as' => 'manage_atoms_edit', 'uses' => 'BackendController@editAtomGet']);
	Route::post('/admin/manage_atoms/edit/{id}', ['as' => 'manage_atoms_edit_post', 'uses' => 'BackendController@editAtomPost']);
	Route::get('/admin/manage_atoms/create_atom', ['as' => 'create_atom', 'uses' => 'BackendController@createAtomGet']);
	Route::post('/admin/manage_atoms/create_atom', ['as' => 'create_atom_post', 'uses' => 'BackendController@createAtomPost']);

	Route::get('/admin/user-privileges/{id}', ['as' => 'profile', 'uses' => 'BackendController@privileges']);
	Route::post('/admin/user-privileges/{id}', ['as' => 'profile_post', 'uses' => 'BackendController@privileges_change']);

	Route::get('/admin/settings', ['as' => 'settings', 'uses' => 'BackendController@settings']);
	Route::post('/admin/settings', ['as' => 'settings_post', 'uses' => 'BackendController@settingsPost']);
});

Route::group(['middleware' => 'web'], function () {
	Auth::routes();
	Route::auth();

	Route::get('/lang/{language}', [ 'as' => 'lang', 'uses' => 'HomeController@lang']);

	Route::get('/profile', ['as' => 'profile', 'uses' => 'ProfileController@info']);

	Route::get('/profile/delete/{id}', ['as' => 'profile', 'uses' => 'ProfileController@delete']);

     Route::get('/profile/password', ['as' => 'profile', 'uses' => 'ProfileController@info_edit']);

     Route::post('/profile/password', ['as' => 'profile_password', 'uses' => 'ProfileController@edit']);

     Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);
});

//Route::any('/{slug}', array('as' => 'page.show', 'uses' => 'PageController@show'))->where(['slug' => '(.*)']);
