<?php

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/backend', function () {
    return redirect('/admin');
});

Route::group(['middleware' => 'admin'], function () {
	Route::get('/admin', ['as' => 'admin', 'uses' => 'Backend\\BackendController@index']);

	Route::get('/admin/manage_routes', ['as' => 'manage_routes', 'uses' => 'Content\\RouteController@manageRoutesGet']);
	Route::get('/admin/manage_routes/edit/{id}', ['as' => 'manage_routes_edit', 'uses' => 'Content\\RouteController@editRouteGet']);
	Route::post('/admin/manage_routes/edit/{id}', ['as' => 'manage_routes_edit_post', 'uses' => 'Content\\RouteController@editRoutePost']);
	Route::get('/admin/manage_routes/delete/{id}', ['as' => 'manage_routes_delete', 'uses' => 'Content\\RouteController@deleteRoute']);
	Route::get('/admin/manage_routes/create_route', ['as' => 'create_route', 'uses' => 'Content\\RouteController@createRouteGet']);
	Route::post('/admin/manage_routes/create_route', ['as' => 'create_route_post', 'uses' => 'Content\\RouteController@createRoutePost']);

	Route::get('/admin/manage_molecules', ['as' => 'manage_molecules', 'uses' => 'Content\\MoleculeController@manageMoleculesGet']);
	Route::get('/admin/manage_molecules/delete/{id},{atoms}', ['as' => 'manage_molecules_delete', 'uses' => 'Content\\MoleculeController@deleteMolecule']);
	Route::get('/admin/manage_molecules/edit/{id}', ['as' => 'manage_molecules_edit', 'uses' => 'Content\\MoleculeController@editMoleculeGet']);
	Route::post('/admin/manage_molecules/edit/{id}', ['as' => 'manage_molecules_edit_post', 'uses' => 'Content\\MoleculeController@editMoleculePost']);
	Route::post('/admin/manage_molecules/mass_delete', ['as' => 'manage_molecules_mass_delete_post', 'uses' => 'Content\\MoleculeController@massDeleteMolecule']);
	Route::post('/admin/manage_molecules/mass_copy/{childrenAtomsToo}', ['as' => 'manage_molecules_mass_copy_post', 'uses' => 'Content\\MoleculeController@massCopyMolecule']);
	Route::get('/admin/manage_molecules/create_molecule', ['as' => 'create_molecule', 'uses' => 'Content\\MoleculeController@createMoleculeGet']);
	Route::post('/admin/manage_molecules/create_molecule', ['as' => 'create_molecule_post', 'uses' => 'Content\\MoleculeController@createMoleculePost']);

	Route::get('/admin/manage_atoms', ['as' => 'manage_atoms', 'uses' => 'Content\\AtomController@manageAtomsGet']);
	Route::get('/admin/manage_atoms/delete/{id}', ['as' => 'manage_atoms_delete', 'uses' => 'Content\\AtomController@deleteAtom']);
	Route::post('/admin/manage_atoms/mass_delete', ['as' => 'manage_atoms_mass_delete_post', 'uses' => 'Content\\AtomController@massDeleteAtom']);
	Route::post('/admin/manage_atoms/mass_copy', ['as' => 'manage_atoms_mass_copy_post', 'uses' => 'Content\\AtomController@massCopyAtom']);
	Route::post('/admin/manage_atoms/mass_move/{molecule}', ['as' => 'manage_atoms_mass_move_post', 'uses' => 'Content\\AtomController@massMoveAtom']);
	Route::get('/admin/manage_atoms/edit/{id}', ['as' => 'manage_atoms_edit', 'uses' => 'Content\\AtomController@editAtomGet']);
	Route::post('/admin/manage_atoms/edit/{id}', ['as' => 'manage_atoms_edit_post', 'uses' => 'Content\\AtomController@editAtomPost']);
	Route::get('/admin/manage_atoms/create_atom', ['as' => 'create_atom', 'uses' => 'Content\\AtomController@createAtomGet']);
	Route::post('/admin/manage_atoms/create_atom', ['as' => 'create_atom_post', 'uses' => 'Content\\AtomController@createAtomPost']);

	Route::get('/admin/user-privileges/{id}', ['as' => 'profile', 'uses' => 'Auth\\ProfileController@privilegesGet']);
	Route::post('/admin/user-privileges/{id}', ['as' => 'profile_post', 'uses' => 'Auth\\ProfileController@changePrivilegesGet']);
	Route::get('/admin/manage_users', ['as' => 'manage_users', 'uses' => 'Auth\\ProfileController@manageUsersGet']);
	Route::post('/admin/manage_users', ['as' => 'manage_users_post', 'uses' => 'Auth\\ProfileController@manageUsersPost']);

	Route::get('/admin/settings', ['as' => 'settings', 'uses' => 'Backend\\BackendController@settings']);
	Route::post('/admin/settings', ['as' => 'settings_post', 'uses' => 'Backend\\BackendController@settingsPost']);
});

Route::group(['middleware' => 'web'], function () {
	Auth::routes();
	Route::auth();

	Route::get('/lang/{language}', [ 'as' => 'lang', 'uses' => 'Content\\HomeController@lang']);

	Route::get('/profile', ['as' => 'profile', 'uses' => 'Auth\\ProfileController@infoGet']);
	Route::get('/profile/delete/{id}', ['as' => 'profile', 'uses' => 'Auth\\ProfileController@delete']);
     Route::get('/profile/password', ['as' => 'profile', 'uses' => 'Auth\\ProfileController@editGet']);
     Route::post('/profile/password', ['as' => 'profile_password', 'uses' => 'Auth\\ProfileController@editPost']);

     Route::get('/home', ['as' => 'home', 'uses' => 'Content\\HomeController@index']);
});

//Route::any('/{slug}', array('as' => 'page.show', 'uses' => 'PageController@show'))->where(['slug' => '(.*)']);
