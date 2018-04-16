<?php


 
Route::group(['prefix' => 'admin','namespace' => 'Adminin\Admin\Http\Controllers','middleware' => ['web']], function()
	{
    	Route::get('/auth/login','AuthController@adminGetLogin');
       	Route::post('/auth/login','AuthController@adminPostLogin');	
       	Route::get('/dashboard','AuthController@dashboard');
	});

Route::group(['prefix' => 'admin','namespace' => 'Adminin\Admin\Http\Controllers','middleware' => ['web','admin']],function()
    {   
        Route::get('/auth/logout','AdminController@adminLogout');
        Route::get('dashboard', 'AdminController@index');

        //**********************************USER MANAGEMENT ROUTES**************************************************************/
        Route::resource('users', 'UserManagementController');        
        Route::post('get-username', 'UserManagementController@fetchUserName');
        Route::get('get-users', 'UserManagementController@getUsers');
        Route::post('get-edit-username', 'UserManagementController@fetchUserNameEdit');
        Route::post('user-disable', 'UserManagementController@disableUserStatus');
        Route::post('user-enable', 'UserManagementController@enableUserStatus');
        Route::post('change-password', 'UserManagementController@resetPassword');
        Route::get('view-users', 'UserManagementController@viewUsers');
        Route::post('delete-user', 'UserManagementController@deleteuser');

        //**********************************CATEGORY MANAGEMENT ROUTES**************************************************************/
        
        Route::resource('category', 'CategoryManagementController');
        Route::get('get-categories', 'CategoryManagementController@getCategories');
        Route::post('category-update','CategoryManagementController@categoryUpdate');
        Route::post('category-disable', 'CategoryManagementController@disableCategoryStatus');
        Route::post('category-enable', 'CategoryManagementController@enableCategoryStatus');
        Route::post('category-delete', 'CategoryManagementController@deleteSite');
        Route::post('sub-category', 'CategoryManagementController@addSubCategory');
        Route::post('get-sub-categories', 'CategoryManagementController@getSubCategories');
        Route::post('update-sub-category', 'CategoryManagementController@updateSubCategories');
        Route::post('delete-category', 'CategoryManagementController@deleteCategory');
        Route::post('delete-sub-category', 'CategoryManagementController@deleteSubCategory');

        //**********************************PRODUCT MANAGEMENT ROUTES**************************************************************/
        Route::resource('products', 'ProductManagementController');        
        Route::post('find-category', 'ProductManagementController@fetchCategory');
        Route::post('find-subcategory', 'ProductManagementController@fetchSubCategories');
        Route::get('fetch-products', 'ProductManagementController@fetchProducts');
        Route::post('product-photo-upload','ProductManagementController@uploadProductPhotos');
        Route::post('edit-products','ProductManagementController@editCategory');
        Route::post('product-update','ProductManagementController@productUpdate');
        Route::post('get-product-category','ProductManagementController@getProductCategory');
        Route::post('get-product-photos','ProductManagementController@getProductPhotos');
        Route::post('product-delete/{id}','ProductManagementController@ProductPhotoDelete');

        // Route::post('user-disable', 'UserManagementController@disableUserStatus');
        // Route::post('user-enable', 'UserManagementController@enableUserStatus');
        // Route::post('change-password', 'UserManagementController@resetPassword');
        // Route::get('view-users', 'UserManagementController@viewUsers');


    });