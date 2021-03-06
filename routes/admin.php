<?php

Route::get('/admin/admin_stats_charts', 'Backend\\BackendController@feedAdminStatsTrackerCharts')->name('admin_stats_charts');
Route::get('/admin/admin_stats_charts_check_for_updates', 'Backend\\BackendController@checkAdminStatsTrackerChartsUpdates')->name('admin_stats_charts_check_for_updates');

Route::get('/admin', 'Backend\\BackendController@index')->name('admin');

Route::get('/admin/uploads_list', 'Backend\\SynthesisFilesystemController@files_list')->name('admin_uploads_list');
Route::post('/admin/upload', 'Backend\\SynthesisFilesystemController@uploadPost')->name('admin_upload_post');
Route::post('/admin/uploads_create_directory', 'Backend\\SynthesisFilesystemController@createDir')->name('admin_uploads_create_dir');
Route::post('/admin/uploads_move_file', 'Backend\\SynthesisFilesystemController@moveFile')->name('admin_uploads_move_file');

Route::post('/synthesis-route-check', 'Content\\RouteController@checkRoute')->name('synthesis_route_check');

Route::post('/admin/file-picker', 'Backend\\BackendController@filePicker')->name('file-picker');

Route::get('/admin/manage_routes', 'Content\\RouteController@manageRoutesGet')->name('manage_routes');
Route::get('/admin/manage_routes/edit/{id}', 'Content\\RouteController@editRouteGet')->name('manage_routes_edit');
Route::post('/admin/manage_routes/edit/{id}', 'Content\\RouteController@editRoutePost')->name('manage_routes_edit_post');
Route::get('/admin/manage_routes/delete/{id}', 'Content\\RouteController@deleteRoute')->name('manage_routes_delete');
Route::get('/admin/manage_routes/create_route', 'Content\\RouteController@createRouteGet')->name('create_route');
Route::post('/admin/manage_routes/create_route', 'Content\\RouteController@createRoutePost')->name('create_route_post');

Route::get('/admin/manage_article_categories', 'Content\\ArticleCategoryController@manageArticleCategoriesGet')->name('manage_article_categories');
Route::get('/admin/manage_article_categories/delete/{id},{articles}', 'Content\\ArticleCategoryController@deleteArticleCategory')->name('manage_article_categories_delete');
Route::get('/admin/manage_article_categories/edit/{id}', 'Content\\ArticleCategoryController@editArticleCategoryGet')->name('manage_article_categories_edit');
Route::post('/admin/manage_article_categories/edit/{id}', 'Content\\ArticleCategoryController@editArticleCategoryPost')->name('manage_article_categories_edit_post');
Route::post('/admin/manage_article_categories/mass_delete', 'Content\\ArticleCategoryController@massDeleteArticleCategory')->name('manage_article_categories_mass_delete_post');
Route::post('/admin/manage_article_categories/mass_copy/{childrenArticlesToo}', 'Content\\ArticleCategoryController@massCopyArticleCategory')->name('manage_article_categories_mass_copy_post');
Route::get('/admin/manage_article_categories/create_article_category', 'Content\\ArticleCategoryController@createArticleCategoryGet')->name('create_article_category');
Route::post('/admin/manage_article_categories/create_article_category', 'Content\\ArticleCategoryController@createArticleCategoryPost')->name('create_article_category_post');

Route::get('/admin/manage_articles', 'Content\\ArticleController@manageArticlesGet')->name('manage_articles');
Route::get('/admin/manage_articles/delete/{id}', 'Content\\ArticleController@deleteArticle')->name('manage_articles_delete');
Route::post('/admin/manage_articles/mass_delete', 'Content\\ArticleController@massDeleteArticle')->name('manage_articles_mass_delete_post');
Route::post('/admin/manage_articles/mass_copy', 'Content\\ArticleController@massCopyArticle')->name('manage_articles_mass_copy_post');
Route::post('/admin/manage_articles/mass_move/{articleCategory}', 'Content\\ArticleController@massMoveArticle')->name('manage_articles_mass_move_post');
Route::get('/admin/manage_articles/edit/{id}', 'Content\\ArticleController@editArticleGet')->name('manage_articles_edit');
Route::post('/admin/manage_articles/edit/{id}', 'Content\\ArticleController@editArticlePost')->name('manage_articles_edit_post');
Route::get('/admin/manage_articles/create_article', 'Content\\ArticleController@createArticleGet')->name('create_article');
Route::post('/admin/manage_articles/create_article', 'Content\\ArticleController@createArticlePost')->name('create_article_post');

Route::get('/admin/user-privileges/{id}', 'Auth\\ProfileController@privilegesGet')->name('user_privileges');
Route::post('/admin/user-privileges/{id}', 'Auth\\ProfileController@changePrivilegesPost')->name('user_privileges_post');
Route::get('/admin/manage_users', 'Auth\\ProfileController@manageUsersGet')->name('manage_users');

Route::get('/admin/manage_applets', 'Backend\\BackendController@manageAppletsGet')->name('manage_applets');
Route::get('/admin/manage_applets/{extension}', 'Backend\\BackendController@appletSettingsGet')->name('applet_settings');
Route::get('/admin/manage_applets/{extension}{url}', 'Backend\\BackendController@appletSettingsGet')->name('applet_settings_with_url');
Route::post('/admin/manage_applets/{extension}', 'Backend\\BackendController@appletSettingsPost')->name('applet_settings_post');

Route::get('/admin/settings', 'Backend\\BackendController@settingsGet')->name('settings');
Route::post('/admin/settings', 'Backend\\BackendController@settingsPost')->name('settings_post');
Route::post('/admin/settings/favicon_upload', 'Backend\\BackendController@settingsAjaxFaviconConvert')->name('settings_favicon_post');

Route::get('/admin/tools/resources_compiler', 'Backend\\BackendController@toolResourcesCompilerGet')->name('tools_resources_compiler');
Route::post('/admin/tools/resources_compiler_execute', 'Backend\\BackendController@toolResourcesCompilerExecutePost')->name('tools_resources_compiler_execute_post');
Route::post('/admin/tools/resources_compiler_rebuild_node_sass_post', 'Backend\\BackendController@toolResourcesCompilerRebuildSassExecutePost')->name('tools_resources_compiler_rebuild_node_sass_post');
Route::post('/admin/tools/resources_compiler_npm_install_post', 'Backend\\BackendController@toolResourcesCompilerNpmInstallExecutePost')->name('tools_resources_compiler_npm_install_post');
Route::post('/admin/tools/resources_compiler_node_modules_delete_post', 'Backend\\BackendController@toolResourcesCompilerNodeModulesDeleteExecutePost')->name('tools_resources_compiler_node_modules_delete_post');

Route::get('/admin/tools/optimizer', 'Backend\\BackendController@toolOptimizerGet')->name('tools_optimizer');
Route::post('/admin/tools/optimizer_execute', 'Backend\\BackendController@toolOptimizerExecutePost')->name('tools_optimizer_execute_post');

Route::get('/update', 'Backend\\UpdateController@index')->name('update');
