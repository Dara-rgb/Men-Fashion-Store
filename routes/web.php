<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClotheController;
use App\Http\Controllers\CategoryClotheController;
use App\Http\Controllers\CategoryFabricController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\InformationCustomerController;
use App\Http\Controllers\AnnouncementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/phpinfo', function () {
    return phpinfo();
});

Route::get('/', function () {
    return view('welcome');
});

//Back_end

//Register
Route::get('/Back_end/show_register', [AuthController::class, 'showRegister'])->name('Back_end.show_register');
Route::post('/Back_end/register', [AuthController::class, 'register'])->name('Back_end.register');

//Login
Route::get('/Back_end/show_login', [AuthController::class, 'showLogin'])->name('Back_end.show_login');
Route::post('/Back_end/login', [AuthController::class, 'login'])->name('Back_end.login');

//Security
Route::get('/Back_end/show_form_security', [AuthController::class, 'showFormSecurity'])->name('Back_end.show_form_security');
Route::get('/Back_end/show_form_edit/{id}', [AuthController::class, 'showFormEdit'])->name('Back_end.show_form_edit');
Route::put('/Back_end/security_update/{id}', [AuthController::class, 'securityUpdate'])->name('Back_end.security_update');
Route::get('/Back_end/show_form_edit_new/{id}', [AuthController::class, 'showFormEditNew'])->name('Back_end.show_form_edit_new');
Route::put('/Back_end/security_update_new/{id}', [AuthController::class, 'securityUpdateNew'])->name('Back_end.security_update_new');


//Forgot
Route::get('/Back_end/show_form_for_forgot', [AuthController::class, 'Showformforforgot'])->name('Back_end.show_form_for_forgot');
Route::post('/Back_end/send_Otp_To_Admin', [AuthController::class, 'sendOtpToAdmin'])->name('Back_end.send_Otp_To_Admin');
Route::get('/Back_end/show_form_pincode', [AuthController::class, 'showFromPincode'])->name('Back_end.show_form_pincode');
Route::post('/Back_end/verify_pincode', [AuthController::class, 'verifyPincode'])->name('Back_end.verify_pincode');

//Login_Confirm
Route::get('/Back_end/show_login_confirm', [AuthController::class, 'showLoginConfirm'])->name('Back_end.show_login_confirm');
Route::post('/Back_end/login_confirm', [AuthController::class, 'login_confirm'])->name('Back_end.login_confirm');

//Logout
Route::get('/Back_end/show_logout', [AuthController::class, 'showLogout'])->name('Back_end.show_logout');
Route::post('/Back_end/logout', [AuthController::class, 'logout'])->name('Back_end.logout');

//Index
Route::get('/Back_end', [AdminController::class, 'admin'])->name('Back_end.index')->middleware('auth');
Route::get('/Back_end/index_create', [AdminController::class, 'admin_create'])->name('Back_end.index_create')->middleware('auth');
Route::post('/Back_end/index_store', [AdminController::class, 'admin_store'])->name('Back_end.index_store')->middleware('auth');
Route::get('/Back_end/index_edit/{id}', [AdminController::class, 'admin_edit'])->name('Back_end.index_edit')->middleware('auth');
Route::put('/Back_end/index_update/{id}', [AdminController::class, 'admin_update'])->name('Back_end.index_update')->middleware('auth');
Route::get('/Back_end/index_destroy/{id}', [AdminController::class, 'admin_destroy'])->name('Back_end.index_destroy')->middleware('auth');
Route::delete('/Back_end/index_delete/{id}', [AdminController::class, 'admin_delete'])->name('Back_end.index_delete')->middleware('auth');
Route::get('/Back_end/index_alldestroy', [AdminController::class, 'admin_alldestroy'])->name('Back_end.index_alldestroy')->middleware('auth');
Route::delete('/Back_end/index_alldelete', [AdminController::class, 'admin_alldelete'])->name('Back_end.index_alldelete')->middleware('auth');
Route::get('/Back_end/search', [AdminController::class, 'search'])->name('Back_end.search')->middleware('auth');

//Clothe
Route::get('/Back_end/clothe', [ClotheController::class, 'clothe'])->name('Back_end.clothe')->middleware('auth');
Route::get('/Back_end/clothe_create', [ClotheController::class, 'clothe_create'])->name('Back_end.clothe_create')->middleware('auth');
Route::post('/Back_end/clothe_store', [ClotheController::class, 'clothe_store'])->name('Back_end.clothe_store')->middleware('auth');
Route::get('/Back_end/clothe_edit/{id}', [ClotheController::class, 'clothe_edit'])->name('Back_end.clothe_edit')->middleware('auth');
Route::put('/Back_end/clothe_update/{id}', [ClotheController::class, 'clothe_update'])->name('Back_end.clothe_update')->middleware('auth');
Route::get('/Back_end/clothe_destroy/{id}', [ClotheController::class, 'clothe_destroy'])->name('Back_end.clothe_destroy')->middleware('auth');
Route::delete('/Back_end/clothe_delete/{id}', [ClotheController::class, 'clothe_delete'])->name('Back_end.clothe_delete')->middleware('auth');
Route::get('/Back_end/clothe_alldestroy', [ClotheController::class, 'clothe_alldestroy'])->name('Back_end.clothe_alldestroy')->middleware('auth');
Route::delete('/Back_end/clothe_alldelete', [ClotheController::class, 'clothe_alldelete'])->name('Back_end.clothe_alldelete')->middleware('auth');
Route::get('/Back_end/category_clotheID/{id}', [ClotheController::class, 'category_clotheID'])->name('Back_end.category_clotheID')->middleware('auth');
Route::get('/Back_end/category_clotheID_create/{id}', [ClotheController::class, 'category_clotheID_create'])->name('Back_end.category_clotheID_create')->middleware('auth');
Route::post('/Back_end/category_clotheID_store', [ClotheController::class, 'category_clotheID_store'])->name('Back_end.category_clotheID_store')->middleware('auth');
Route::get('/Back_end/category_clotheID_edit/{id}/{ID}', [ClotheController::class, 'category_clotheID_edit'])->name('Back_end.category_clotheID_edit')->middleware('auth');
Route::put('/Back_end/category_clotheID_update/{id}', [ClotheController::class, 'category_clotheID_update'])->name('Back_end.category_clotheID_update')->middleware('auth');
Route::get('/Back_end/category_clotheID_destroy/{id}/{ID}', [ClotheController::class, 'category_clotheID_destroy'])->name('Back_end.category_clotheID_destroy')->middleware('auth');
Route::delete('/Back_end/category_clotheID_delete/{id}', [ClotheController::class, 'category_clotheID_delete'])->name('Back_end.category_clotheID_delete')->middleware('auth');
Route::get('/Back_end/category_clotheID_alldestroy/{id}', [ClotheController::class, 'category_clotheID_alldestroy'])->name('Back_end.category_clotheID_alldestroy')->middleware('auth');
Route::delete('/Back_end/category_clotheID_alldelete/{clothe_id}', [ClotheController::class, 'category_clotheID_alldelete'])->name('Back_end.category_clotheID_alldelete')->middleware('auth');
Route::get('/Back_end/search_clothe', [ClotheController::class, 'search_clothe'])->name('Back_end.search_clothe')->middleware('auth');

//Category_clothe
Route::get('/Back_end/category_clothe', [CategoryClotheController::class, 'category_clothe'])->name('Back_end.category_clothe')->middleware('auth');
Route::get('/Back_end/category_clothe_create', [CategoryClotheController::class, 'category_clothe_create'])->name('Back_end.category_clothe_create')->middleware('auth');
Route::post('/Back_end/category_clothe_store', [CategoryClotheController::class, 'category_clothe_store'])->name('Back_end.category_clothe_store')->middleware('auth');
Route::get('/Back_end/category_clothe_edit/{id}/{ID}', [CategoryClotheController::class, 'category_clothe_edit'])->name('Back_end.category_clothe_edit')->middleware('auth');
Route::put('/Back_end/category_clothe_update/{id}', [CategoryClotheController::class, 'category_clothe_update'])->name('Back_end.category_clothe_update')->middleware('auth');
Route::get('/Back_end/category_clothe_destroy/{id}/{ID}', [CategoryClotheController::class, 'category_clothe_destroy'])->name('Back_end.category_clothe_destroy')->middleware('auth');
Route::delete('/Back_end/category_clothe_delete/{id}', [CategoryClotheController::class, 'category_clothe_delete'])->name('Back_end.category_clothe_delete')->middleware('auth');
Route::get('/Back_end/category_clothe_alldestroy', [CategoryClotheController::class, 'category_clothe_alldestroy'])->name('Back_end.category_clothe_alldestroy')->middleware('auth');
Route::delete('/Back_end/category_clothe_alldelete', [CategoryClotheController::class, 'category_clothe_alldelete'])->name('Back_end.category_clothe_alldelete')->middleware('auth');
Route::get('/Back_end/postID_category_clothe/{id}', [CategoryClotheController::class, 'postID_category_clothe'])->name('Back_end.postID_category_clothe')->middleware('auth');
Route::get('/Back_end/postID_category_clothe_create/{id}', [CategoryClotheController::class, 'postID_category_clothe_create'])->name('Back_end.postID_category_clothe_create')->middleware('auth');
Route::post('/Back_end/postID_category_clothe_store', [CategoryClotheController::class, 'postID_category_clothe_store'])->name('Back_end.postID_category_clothe_store')->middleware('auth');
Route::get('/Back_end/postID_category_clothe_edit/{id}/{Id}/{ID}', [CategoryClotheController::class, 'postID_category_clothe_edit'])->name('Back_end.postID_category_clothe_edit')->middleware('auth');
Route::put('/Back_end/postID_category_clothe_update/{id}', [CategoryClotheController::class, 'postID_category_clothe_update'])->name('Back_end.postID_category_clothe_update')->middleware('auth');
Route::get('/Back_end/postID_category_clothe_destroy/{id}/{Id}/{ID}', [CategoryClotheController::class, 'postID_category_clothe_destroy'])->name('Back_end.postID_category_clothe_destroy')->middleware('auth');
Route::delete('/Back_end/postID_category_clothe_delete/{id}', [CategoryClotheController::class, 'postID_category_clothe_delete'])->name('Back_end.postID_category_clothe_delete')->middleware('auth');
Route::get('/Back_end/postID_category_clothe_alldestroy/{id}', [CategoryClotheController::class, 'postID_category_clothe_alldestroy'])->name('Back_end.postID_category_clothe_alldestroy')->middleware('auth');
Route::delete('/Back_end/postID_category_clothe_alldelete/{category_clothe_id}', [CategoryClotheController::class, 'postID_category_clothe_alldelete'])->name('Back_end.postID_category_clothe_alldelete')->middleware('auth');
Route::get('/Back_end/search_category_clothe', [CategoryClotheController::class, 'search_category_clothe'])->name('Back_end.search_category_clothe')->middleware('auth');

//Category_fabric
Route::get('/Back_end/category_fabric', [CategoryFabricController::class, 'category_fabric'])->name('Back_end.category_fabric')->middleware('auth');
Route::get('/Back_end/category_fabric_create', [CategoryFabricController::class, 'category_fabric_create'])->name('Back_end.category_fabric_create')->middleware('auth');
Route::post('/Back_end/category_fabric_store', [CategoryFabricController::class, 'category_fabric_store'])->name('Back_end.category_fabric_store')->middleware('auth');
Route::get('/Back_end/category_fabric_edit/{id}', [CategoryFabricController::class, 'category_fabric_edit'])->name('Back_end.category_fabric_edit')->middleware('auth');
Route::put('/Back_end/category_fabric_update/{id}', [CategoryFabricController::class, 'category_fabric_update'])->name('Back_end.category_fabric_update')->middleware('auth');
Route::get('/Back_end/category_fabric_destroy/{id}', [CategoryFabricController::class, 'category_fabric_destroy'])->name('Back_end.category_fabric_destroy')->middleware('auth');
Route::delete('/Back_end/category_fabric_delete/{id}', [CategoryFabricController::class, 'category_fabric_delete'])->name('Back_end.category_fabric_delete')->middleware('auth');
Route::get('/Back_end/category_fabric_alldestroy', [CategoryFabricController::class, 'category_fabric_alldestroy'])->name('Back_end.category_fabric_alldestroy')->middleware('auth');
Route::delete('/Back_end/category_fabric_alldelete', [CategoryFabricController::class, 'category_fabric_alldelete'])->name('Back_end.category_fabric_alldelete')->middleware('auth');
Route::get('/Back_end/postID_category_fabric/{id}', [CategoryFabricController::class, 'postID_category_fabric'])->name('Back_end.postID_category_fabric')->middleware('auth');
Route::get('/Back_end/postID_category_fabric_create/{id}', [CategoryFabricController::class, 'postID_category_fabric_create'])->name('Back_end.postID_category_fabric_create')->middleware('auth');
Route::post('/Back_end/postID_category_fabric_store', [CategoryFabricController::class, 'postID_category_fabric_store'])->name('Back_end.postID_category_fabric_store')->middleware('auth');
Route::get('/Back_end/postID_category_fabric_edit/{id}/{Id}/{ID}', [CategoryFabricController::class, 'postID_category_fabric_edit'])->name('Back_end.postID_category_fabric_edit')->middleware('auth');
Route::put('/Back_end/postID_category_fabric_update/{id}', [CategoryFabricController::class, 'postID_category_fabric_update'])->name('Back_end.postID_category_fabric_update')->middleware('auth');
Route::get('/Back_end/postID_category_fabric_destroy/{id}/{Id}/{ID}', [CategoryFabricController::class, 'postID_category_fabric_destroy'])->name('Back_end.postID_category_fabric_destroy')->middleware('auth');
Route::delete('/Back_end/postID_category_fabric_delete/{id}', [CategoryFabricController::class, 'postID_category_fabric_delete'])->name('Back_end.postID_category_fabric_delete')->middleware('auth');
Route::get('/Back_end/postID_category_fabric_alldestroy/{id}', [CategoryFabricController::class, 'postID_category_fabric_alldestroy'])->name('Back_end.postID_category_fabric_alldestroy')->middleware('auth');
Route::delete('/Back_end/postID_category_fabric_alldelete/{category_fabric_id}', [CategoryFabricController::class, 'postID_category_fabric_alldelete'])->name('Back_end.postID_category_fabric_alldelete')->middleware('auth');
Route::get('/Back_end/search_category_fabric', [CategoryFabricController::class, 'search_category_fabric'])->name('Back_end.search_category_fabric')->middleware('auth');

//Post
Route::get('/Back_end/post', [PostController::class, 'post'])->name('Back_end.post')->middleware('auth');
Route::get('/Back_end/post_create', [PostController::class, 'post_create'])->name('Back_end.post_create')->middleware('auth');
Route::post('/Back_end/post_store', [PostController::class, 'post_store'])->name('Back_end.post_store')->middleware('auth');
Route::get('/Back_end/post_edit/{id}/{Id}/{ID}', [PostController::class, 'post_edit'])->name('Back_end.post_edit')->middleware('auth');
Route::put('/Back_end/post_update/{id}', [PostController::class, 'post_update'])->name('Back_end.post_update')->middleware('auth');
Route::get('/Back_end/post_destroy/{id}/{Id}/{ID}', [PostController::class, 'post_destroy'])->name('Back_end.post_destroy')->middleware('auth');
Route::delete('/Back_end/post_delete/{id}', [PostController::class, 'post_delete'])->name('Back_end.post_delete')->middleware('auth');
Route::get('/Back_end/post_alldestroy', [PostController::class, 'post_alldestroy'])->name('Back_end.post_alldestroy')->middleware('auth');
Route::delete('/Back_end/post_alldelete', [PostController::class, 'post_alldelete'])->name('Back_end.post_alldelete')->middleware('auth');
Route::get('/Back_end/pictureID_post/{id}', [PostController::class, 'pictureID_post'])->name('Back_end.pictureID_post')->middleware('auth');
Route::get('/Back_end/pictureID_post_create/{id}', [PostController::class, 'pictureID_post_create'])->name('Back_end.pictureID_post_create')->middleware('auth');
Route::post('/Back_end/pictureID_post_store', [PostController::class, 'pictureID_post_store'])->name('Back_end.pictureID_post_store')->middleware('auth');
Route::get('/Back_end/pictureID_post_edit/{id}/{Id}/{ID}/{sid}', [PostController::class, 'pictureID_post_edit'])->name('Back_end.pictureID_post_edit')->middleware('auth');
Route::put('/Back_end/pictureID_post_update/{id}', [PostController::class, 'pictureID_post_update'])->name('Back_end.pictureID_post_update')->middleware('auth');
Route::get('/Back_end/pictureID_post_destroy/{id}/{Id}/{ID}/{sid}', [PostController::class, 'pictureID_post_destroy'])->name('Back_end.pictureID_post_destroy')->middleware('auth');
Route::delete('/Back_end/pictureID_post_delete/{id}', [PostController::class, 'pictureID_post_delete'])->name('Back_end.pictureID_post_delete')->middleware('auth');
Route::get('/Back_end/pictureID_post_alldestroy/{id}', [PostController::class, 'pictureID_post_alldestroy'])->name('Back_end.pictureID_post_alldestroy')->middleware('auth');
Route::delete('/Back_end/pictureID_post_alldelete/{post_id}', [PostController::class, 'pictureID_post_alldelete'])->name('Back_end.pictureID_post_alldelete')->middleware('auth');
Route::get('/Back_end/search_post', [PostController::class, 'search_post'])->name('Back_end.search_post')->middleware('auth');

//Contact
Route::get('/Back_end/contact', [ContactController::class, 'contact'])->name('Back_end.contact')->middleware('auth');
Route::get('/Back_end/contact_create', [ContactController::class, 'contact_create'])->name('Back_end.contact_create')->middleware('auth');
Route::post('/Back_end/contact_store', [ContactController::class, 'contact_store'])->name('Back_end.contact_store')->middleware('auth');
Route::get('/Back_end/contact_edit/{id}', [ContactController::class, 'contact_edit'])->name('Back_end.contact_edit')->middleware('auth');
Route::put('/Back_end/contact_update/{id}', [ContactController::class, 'contact_update'])->name('Back_end.contact_update')->middleware('auth');
Route::get('/Back_end/contact_destroy/{id}', [ContactController::class, 'contact_destroy'])->name('Back_end.contact_destroy')->middleware('auth');
Route::delete('/Back_end/contact_delete/{id}', [ContactController::class, 'contact_delete'])->name('Back_end.contact_delete')->middleware('auth');
Route::get('/Back_end/contact_alldestroy', [ContactController::class, 'contact_alldestroy'])->name('Back_end.contact_alldestroy')->middleware('auth');
Route::delete('/Back_end/contact_alldelete', [ContactController::class, 'contact_alldelete'])->name('Back_end.contact_alldelete')->middleware('auth');
Route::get('/Back_end/pictureID_contact/{id}', [ContactController::class, 'pictureID_contact'])->name('Back_end.pictureID_contact')->middleware('auth');
Route::get('/Back_end/pictureID_contact_create/{id}', [ContactController::class, 'pictureID_contact_create'])->name('Back_end.pictureID_contact_create')->middleware('auth');
Route::post('/Back_end/pictureID_contact_store', [ContactController::class, 'pictureID_contact_store'])->name('Back_end.pictureID_contact_store')->middleware('auth');
Route::get('/Back_end/pictureID_contact_edit/{id}/{Id}/{ID}/{sid}', [ContactController::class, 'pictureID_contact_edit'])->name('Back_end.pictureID_contact_edit')->middleware('auth');
Route::put('/Back_end/pictureID_contact_update/{id}', [ContactController::class, 'pictureID_contact_update'])->name('Back_end.pictureID_contact_update')->middleware('auth');
Route::get('/Back_end/pictureID_contact_destroy/{id}/{Id}/{ID}/{sid}', [ContactController::class, 'pictureID_contact_destroy'])->name('Back_end.pictureID_contact_destroy')->middleware('auth');
Route::delete('/Back_end/pictureID_contact_delete/{id}', [ContactController::class, 'pictureID_contact_delete'])->name('Back_end.pictureID_contact_delete')->middleware('auth');
Route::get('/Back_end/pictureID_contact_alldestroy/{id}', [ContactController::class, 'pictureID_contact_alldestroy'])->name('Back_end.pictureID_contact_alldestroy')->middleware('auth');
Route::delete('/Back_end/pictureID_contact_alldelete/{contact_id}', [ContactController::class, 'pictureID_contact_alldelete'])->name('Back_end.pictureID_contact_alldelete')->middleware('auth');
Route::get('/Back_end/search_contact', [ContactController::class, 'search_contact'])->name('Back_end.search_contact')->middleware('auth');

//Size
Route::get('/Back_end/size', [SizeController::class, 'size'])->name('Back_end.size')->middleware('auth');
Route::get('/Back_end/size_create', [SizeController::class, 'size_create'])->name('Back_end.size_create')->middleware('auth');
Route::post('/Back_end/size_store', [SizeController::class, 'size_store'])->name('Back_end.size_store')->middleware('auth');
Route::get('/Back_end/size_edit/{id}', [SizeController::class, 'size_edit'])->name('Back_end.size_edit')->middleware('auth');
Route::put('/Back_end/size_update/{id}', [SizeController::class, 'size_update'])->name('Back_end.size_update')->middleware('auth');
Route::get('/Back_end/size_destroy/{id}', [SizeController::class, 'size_destroy'])->name('Back_end.size_destroy')->middleware('auth');
Route::delete('/Back_end/size_delete/{id}', [SizeController::class, 'size_delete'])->name('Back_end.size_delete')->middleware('auth');
Route::get('/Back_end/size_alldestroy', [SizeController::class, 'size_alldestroy'])->name('Back_end.size_alldestroy')->middleware('auth');
Route::delete('/Back_end/size_alldelete', [SizeController::class, 'size_alldelete'])->name('Back_end.size_alldelete')->middleware('auth');
Route::get('/Back_end/pictureID_size/{id}', [SizeController::class, 'pictureID_size'])->name('Back_end.pictureID_size')->middleware('auth');
Route::get('/Back_end/pictureID_size_create/{id}', [SizeController::class, 'pictureID_size_create'])->name('Back_end.pictureID_size_create')->middleware('auth');
Route::post('/Back_end/pictureID_size_store', [SizeController::class, 'pictureID_size_store'])->name('Back_end.pictureID_size_store')->middleware('auth');
Route::get('/Back_end/pictureID_size_edit/{id}/{Id}/{ID}/{sid}', [SizeController::class, 'pictureID_size_edit'])->name('Back_end.pictureID_size_edit')->middleware('auth');
Route::put('/Back_end/pictureID_size_update/{id}', [SizeController::class, 'pictureID_size_update'])->name('Back_end.pictureID_size_update')->middleware('auth');
Route::get('/Back_end/pictureID_size_destroy/{id}/{Id}/{ID}/{sid}', [SizeController::class, 'pictureID_size_destroy'])->name('Back_end.pictureID_size_destroy')->middleware('auth');
Route::delete('/Back_end/pictureID_size_delete/{id}', [SizeController::class, 'pictureID_size_delete'])->name('Back_end.pictureID_size_delete')->middleware('auth');
Route::get('/Back_end/pictureID_size_alldestroy/{id}', [SizeController::class, 'pictureID_size_alldestroy'])->name('Back_end.pictureID_size_alldestroy')->middleware('auth');
Route::delete('/Back_end/pictureID_size_alldelete/{size_id}', [SizeController::class, 'pictureID_size_alldelete'])->name('Back_end.pictureID_size_alldelete')->middleware('auth');
Route::get('/Back_end/search_size', [SizeController::class, 'search_size'])->name('Back_end.search_size')->middleware('auth');

//Picture
Route::get('/Back_end/picture', [PictureController::class, 'picture'])->name('Back_end.picture')->middleware('auth');
Route::get('/Back_end/picture_create', [PictureController::class, 'picture_create'])->name('Back_end.picture_create')->middleware('auth');
Route::post('/Back_end/picture_store', [PictureController::class, 'picture_store'])->name('Back_end.picture_store')->middleware('auth');
Route::get('/Back_end/picture_edit/{id}/{Id}/{ID}/{sid}', [PictureController::class, 'picture_edit'])->name('Back_end.picture_edit')->middleware('auth');
Route::put('/Back_end/picture_update/{id}', [PictureController::class, 'picture_update'])->name('Back_end.picture_update')->middleware('auth');
Route::get('/Back_end/picture_destroy/{id}/{Id}/{ID}/{sid}', [PictureController::class, 'picture_destroy'])->name('Back_end.picture_destroy')->middleware('auth');
Route::delete('/Back_end/picture_delete/{id}', [PictureController::class, 'picture_delete'])->name('Back_end.picture_delete')->middleware('auth');
Route::get('/Back_end/picture_alldestroy', [PictureController::class, 'picture_alldestroy'])->name('Back_end.picture_alldestroy')->middleware('auth');
Route::delete('/Back_end/picture_alldelete', [PictureController::class, 'picture_alldelete'])->name('Back_end.picture_alldelete')->middleware('auth');
Route::get('/Back_end/Information_customerID_picture/{id}', [PictureController::class, 'Information_customerID_picture'])->name('Back_end.Information_customerID_picture')->middleware('auth');
Route::get('/Back_end/Information_customerID_edit_picture/{id}/{ID}', [PictureController::class, 'Information_customerID_edit_picture'])->name('Back_end.Information_customerID_edit_picture')->middleware('auth');
Route::put('/Back_end/Information_customerID_update_picture/{id}', [PictureController::class, 'Information_customerID_update_picture'])->name('Back_end.Information_customerID_update_picture')->middleware('auth');
Route::get('/Back_end/Information_customerID_destroy_picture/{id}/{ID}', [PictureController::class, 'Information_customerID_destroy_picture'])->name('Back_end.Information_customerID_destroy_picture')->middleware('auth');
Route::delete('/Back_end/Information_customerID_delete_picture/{id}', [PictureController::class, 'Information_customerID_delete_picture'])->name('Back_end.Information_customerID_delete_picture')->middleware('auth');
Route::get('/Back_end/Information_customerID_alldestroy_picture/{id}', [PictureController::class, 'Information_customerID_alldestroy_picture'])->name('Back_end.Information_customerID_alldestroy_picture')->middleware('auth');
Route::delete('/Back_end/Information_customerID_alldelete_picture/{picture_id}', [PictureController::class, 'Information_customerID_alldelete_picture'])->name('Back_end.Information_customerID_alldelete_picture')->middleware('auth');
Route::get('/Back_end/search_picture', [PictureController::class, 'search_picture'])->name('Back_end.search_picture')->middleware('auth');



//Information_customer
Route::get('/Back_end/Information_customer', [InformationCustomerController::class, 'Information_customer'])->name('Back_end.Information_customer')->middleware('auth');
Route::post('/Back_end/Information_customer_store', [InformationCustomerController::class, 'Information_customer_store'])->name('Back_end.Information_customer_store')->middleware('auth');
Route::get('/Back_end/Information_customer_edit/{id}/{ID}', [InformationCustomerController::class, 'Information_customer_edit'])->name('Back_end.Information_customer_edit')->middleware('auth');
Route::put('/Back_end/Information_customer_update/{id}', [InformationCustomerController::class, 'Information_customer_update'])->name('Back_end.Information_customer_update')->middleware('auth');
Route::get('/Back_end/Information_customerr_destroy/{id}/{ID}', [InformationCustomerController::class, 'Information_customerr_destroy'])->name('Back_end.Information_customerr_destroy')->middleware('auth');
Route::delete('/Back_end/Information_customerr_delete/{id}', [InformationCustomerController::class, 'Information_customerr_delete'])->name('Back_end.Information_customerr_delete')->middleware('auth');
Route::get('/Back_end/Information_customerr_alldestroy', [InformationCustomerController::class, 'Information_customerr_alldestroy'])->name('Back_end.Information_customerr_alldestroy')->middleware('auth');
Route::delete('/Back_end/Information_customerr_alldelete', [InformationCustomerController::class, 'Information_customerr_alldelete'])->name('Back_end.Information_customerr_alldelete')->middleware('auth');
Route::get('/Back_end/search_Information_customer', [InformationCustomerController::class, 'search_Information_customer'])->name('Back_end.search_Information_customer')->middleware('auth');
Route::get('/send-telegram/{id}', [InformationCustomerController::class, 'sendToTelegram'])->name('Back_end.send_telegram')->middleware('auth');


//Announcement
Route::get('/Back_end/announcement', [AnnouncementController::class, 'announcement'])->name('Back_end.announcement')->middleware('auth');
Route::get('/Back_end/announcement_create', [AnnouncementController::class, 'announcement_create'])->name('Back_end.announcement_create')->middleware('auth');
Route::post('/Back_end/announcement_store', [AnnouncementController::class, 'announcement_store'])->name('Back_end.announcement_store')->middleware('auth');
Route::get('/Back_end/announcement_edit/{id}', [AnnouncementController::class, 'announcement_edit'])->name('Back_end.announcement_edit')->middleware('auth');
Route::put('/Back_end/announcement_update/{id}', [AnnouncementController::class, 'announcement_update'])->name('Back_end.announcement_update')->middleware('auth');
Route::get('/Back_end/announcement_destroy/{id}', [AnnouncementController::class, 'announcement_destroy'])->name('Back_end.announcement_destroy')->middleware('auth');
Route::delete('/Back_end/announcement_delete/{id}', [AnnouncementController::class, 'announcement_delete'])->name('Back_end.announcement_delete')->middleware('auth');
Route::get('/Back_end/announcement_alldestroy', [AnnouncementController::class, 'announcement_alldestroy'])->name('Back_end.announcement_alldestroy')->middleware('auth');
Route::delete('/Back_end/announcement_alldelete', [AnnouncementController::class, 'announcement_alldelete'])->name('Back_end.announcement_alldelete')->middleware('auth');
Route::patch('/Back_end/announcement_toggle/{id}', [AnnouncementController::class, 'toggleStatus'])->name('Back_end.announcement_toggle')->middleware('auth');




//Front_end

//Index


Route::get('/Front_end', [AdminController::class, 'admin_front_end'])->name('Front_end.index');
Route::get('/Front_end/all', [AdminController::class, 'admin_all_front_end'])->name('Front_end.index_all');
Route::get('/Front_end/clothe/{id}', [AdminController::class, 'clothe_front_end'])->name('Front_end.clothe');
Route::get('/Front_end/category_clothe/{id}', [AdminController::class, 'category_clothe_front_end'])->name('Front_end.category_clothe');
Route::get('/Front_end/category_fabric/{ID}/{id}', [AdminController::class, 'category_fabric_front_end'])->name('Front_end.category_fabric');
Route::get('/Front_end/search', [AdminController::class, 'search_front_end'])->name('Front_end.search');

//Route::get('/Front_end/picture/{id}', [AdminController::class, 'picture_front_end'])->name('Front_end.picture');
Route::get('/Front_end/picture/{id}', [AdminController::class, 'picture_front_end'])->name('Front_end.picture')->where('id', '[0-9,]+'); // អនុញ្ញាតឱ្យមានតែលេខ និងសញ្ញាក្បៀស
Route::get('/Front_end/customer_identity/{id}', [AdminController::class, 'customer_identity_front_end'])->name('Front_end.customer_identity');
Route::post('/Front_end/customer-identity-multiple', [AdminController::class, 'customerIdentityMultiple'])->name('Front_end.customer_identity_multiple');





    Route::post('/Front_end/qr_code', [AdminController::class, 'checkout'])->name('Front_end.qr_code');
    Route::post('/payment/check-status', [AdminController::class, 'checkStatus'])->name('payment.verify');
    // ... route ផ្សេងៗ
    Route::get('/order-success', function() {
    return "<h1>Success! Your order is now in our system.</h1>";
})->name('order.success');


