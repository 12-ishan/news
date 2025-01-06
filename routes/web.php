<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\PermissionHeadController;

use App\Http\Controllers\admin\NewsController;
use App\Http\Controllers\admin\NewsCategoryController;
use App\Http\Controllers\admin\GeneralSettingsController;
use App\Http\Controllers\admin\LandingPagesController;
use App\Http\Controllers\admin\ContactLeadsController;
use App\Http\Controllers\admin\LargeFileUploadController;
use App\Http\Controllers\admin\NewsSubCategoryController;
use App\Http\Controllers\admin\MenuManagerController;
use App\Http\Controllers\admin\MenuManagerUnitController;
use App\Http\Controllers\admin\MediaCategoryController;
use App\Http\Controllers\admin\MediaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/activity', [UserActivityController::class, 'activity'])->name('activity');

//Registration Routing
Route::get('/registration', [RegistrationController::class, 'index'])->name('studentRegistration');
Route::post('/doRegistration', [RegistrationController::class, 'insert'])->name('doRegistration');

Route::get('/student/logout', [StudentController::class, 'logout'])->name('studentLogout');



Route::group(['middleware' => ['auth:student']], function () {

Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('studentDashboard');



});


//Registration Routing ends

//Login Routing
Route::get('/login', [StudentController::class, 'index'])->name('studentLogin');

Route::post('/doStudentLogin',[StudentController::class, 'doStudentLogin'])->name('doStudentLogin');
//Login Routing ends

Route::get('/login',[AdminController::class, 'login'])->name('adminLogin');
Route::get('/logout',[AdminController::class, 'logout'])->name('adminLogout');
Route::get('/register',[AdminController::class, 'register'])->name('adminRegister');
Route::post('register',[AdminController::class, 'createUser'])->name('adminRegisterPost');
Route::post('login',[AdminController::class, 'doLogin'])->name('doLogin');


Route::group(['middleware' => ['auth']], function () {
    // demo for role based API
    Route::get('emp-role', [EmployeeController::class, 'index'])->name('emp-role')->middleware('can:add.blog');
    Route::get('user/{id}/edit',[UserController::class, 'edit'])->name('user.edit');
    Route::put('user/{id}',[UserController::class, 'update'])->name('user.update');
    Route::get('/dashboard',[DashboardController::class, 'home'])->name('dashboard');
    Route::resource('user', UserController::class);
    Route::post('user/updateSortorder', [UserController:: class, 'updateSortorder']);
     Route::post('user/destroyAll', [UserController:: class, 'destroyAll']);
     Route::post('user/updateStatus', [UserController:: class, 'updateStatus']);


      //Program Routings
    
      Route::post('news/updateSortorder',[NewsController::class, 'updateSortorder']);
      Route::post('news/destroyAll',[NewsController::class, 'destroyAll']);
      Route::post('news/updateStatus',[NewsController::class, 'updateStatus']);
    Route::get('/get-media-by-category/{categoryId}', [NewsController::class, 'getMediaByCategory']);
    Route::get('/preview-image', [NewsController::class, 'previewSelectedMedia']);
    Route::post('/delete-media', [NewsController::class, 'deleteMedia'])->name('delete.media');
      Route::resource('news', NewsController::class);
    
   

     //News Category Routings
         
     Route::post('news-category/updateSortorder', [NewsCategoryController:: class, 'updateSortorder']);
     Route::post('news-category/destroyAll', [NewsCategoryController:: class, 'destroyAll']);
     Route::post('news-category/updateStatus', [NewsCategoryController:: class, 'updateStatus']);
     Route::resource('news-category', NewsCategoryController::class);

 
     //news Category Routings ends



      //Media Routings
         
      Route::post('media/updateSortorder', [MediaController:: class, 'updateSortorder']);
      Route::post('media/destroyAll', [MediaController:: class, 'destroyAll']);
      Route::post('media/updateStatus', [MediaController:: class, 'updateStatus']);
      Route::resource('media', MediaController::class);
 
      //Media Routings ends




     //Media Category Routings
         
     Route::post('media-category/updateSortorder', [MediaCategoryController:: class, 'updateSortorder']);
     Route::post('media-category/destroyAll', [MediaCategoryController:: class, 'destroyAll']);
     Route::post('media-category/updateStatus', [MediaCategoryController:: class, 'updateStatus']);
     Route::resource('media-category', MediaCategoryController::class);

     //Media Category Routings ends






     //Menu Manager Routings
         
     Route::post('menu/updateSortorder', [MenuManagerController:: class, 'updateSortorder']);
     Route::post('menu/destroyAll', [MenuManagerController:: class, 'destroyAll']);
     Route::post('menu/updateStatus', [MenuManagerController:: class, 'updateStatus']);
     Route::get('menu/menu-items/{id}', [MenuManagerController::class, 'menu_items'])->name('menu.menu-items');
     Route::post('menu/add-menu-items', [MenuManagerController::class, 'addMenuItems'])->name('menu.addMenuItems');
     Route::resource('menu', MenuManagerController::class);

 
     //Menu Manager Routings ends


      //Menu Manager Routings
         
      Route::post('menu-unit/updateSortorder', [MenuManagerUnitController:: class, 'updateSortorder']);
      Route::post('menu-unit/destroyAll', [MenuManagerUnitController:: class, 'destroyAll']);
      Route::post('menu-unit/updateStatus', [MenuManagerUnitController:: class, 'updateStatus']);
      Route::get('menu-unit/menu-items/{id}', [MenuManagerUnitController::class, 'menu_items'])->name('menu-unit.menu-items');
      Route::get('menu-unit/add-menu-items/{id}', [MenuManagerUnitController::class, 'addMenuItems'])->name('menu-unit.addMenuItems');
      Route::post('menu-unit/store-menu-items', [MenuManagerUnitController::class, 'storeMenuItems'])->name('menu-unit.storeMenuItems');
      Route::get('menu-unit/edit-menu-items/{id}', [MenuManagerUnitController::class, 'editMenuItems'])->name('menu-unit.editMenuItems');
      Route::put('menu-unit/update-menu-items', [MenuManagerUnitController::class, 'updateMenuItems'])->name('menu-unit.updateMenuItems');
      Route::delete('menu-unit/delete-menu-items/{id}', [MenuManagerUnitController::class, 'deleteMenuItems'])->name('menu-unit.deleteMenuItems');
      Route::resource('menu-unit', MenuManagerUnitController::class);
 
  
      //Menu Manager Routings ends


     //Landing pages Routings
         
     Route::post('landing-page/updateSortorder', [LandingPagesController:: class, 'updateSortorder']);
     Route::post('landing-page/destroyAll', [LandingPagesController:: class, 'destroyAll']);
     Route::post('landing-page/updateStatus', [LandingPagesController:: class, 'updateStatus']);
     Route::resource('landing-page', LandingPagesController::class);
 
     //Landing pages Routings ends



       //contact Leads Routings
       Route::post('contact/leads/updateSortorder',[ ContactLeadsController::class, 'updateSortorder']);
       Route::post('contact/leads/destroyAll',[ ContactLeadsController::class, 'destroyAll']);
       Route::post('contact/leads/updateStatus',[ ContactLeadsController::class, 'updateStatus']);
       Route::resource('contact/leads', ContactLeadsController::class);
       Route::get('/search-export-contact-leads', [ContactLeadsController::class, 'searchExport'])->name('search-export');

        //contact Leads Routings ends

        
         //contact Leads Routings
         Route::get('/file-uploads', [LargeFileUploadController::class, 'store']); 
        //contact Leads Routings ends


               //General Settings Routings
      Route::get('general-settings/home-page-setting', [GeneralSettingsController::class, 'index'])->name('home');
      Route::put('generalSettings', [GeneralSettingsController::class, 'update'])->name('update');

      Route::get('general-settings/website-logo-setting', [GeneralSettingsController::class, 'websiteLogo'])->name('websiteLogo');
      Route::put('generalSettings/website-logo', [GeneralSettingsController::class, 'updateLogo'])->name('updateLogo');
      //General Settings Routings ends

             
         //Contact Routings

    
         Route::post('contact/updateSortorder',[ContactController:: class,  'updateSortorder']);
         Route::post('contact/destroyAll',[ContactController:: class,  'destroyAll']);
         Route::post('contact/updateStatus',[ContactController:: class,  'updateStatus']);
         Route::resource('contact',ContactController::class);
     
         //Contact Routings ends

         //Role Routings
         Route::post('role/updateSortorder',[RoleController::class,  'updateSortorder']);
         Route::post('role/destroyAll',[RoleController::class,  'destroyAll']);
         Route::post('role/updateStatus',[RoleController::class,'updateStatus']); 
         Route::resource('role',RoleController::class);
         //Role Routings ends

          //PermissionHead Routings
          Route::post('permission/updateSortorder',[PermissionHeadController::class,  'updateSortorder']);
          Route::post('permission/destroyAll',[PermissionHeadController::class,  'destroyAll']);
          Route::post('permission/updateStatus',[PermissionHeadController::class,'updateStatus']); 
          Route::resource('permission',PermissionHeadController::class);
          //PermissionHead Routings ends
  

});


// Route::get('/dashboard', 'admin\DashboardController@home');


//Route::get('/login', 'admin\AdminController@login')->name('adminLogin');
// Route::post('login', 'admin\AdminController@doLogin')->name('customeLogin');
//Route::get('/register', 'admin\AdminController@register');
//Route::post('register', 'admin\AdminController@createUser');

Route::get('/', function () {
    return view('welcome');
});
