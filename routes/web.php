<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudyMaterialController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Models\rise\Posts;



Route::get('/', function () {
    return view('index');
});


// user details
Route::get('/user-login', [HomeController::class, 'login'])->name('front.login');
Route::post('/user-logout', [App\Http\Controllers\HomeController::class, 'frontLogout'])->name('front.logout');
Route::get('/user-signup', [App\Http\Controllers\HomeController::class, 'signup'])->name('front.signup');
Route::post('/UserRegistration', [App\Http\Controllers\HomeController::class, 'registration'])->name('front.registration');
Route::post('/frontlogin', [App\Http\Controllers\HomeController::class, 'frontlogin'])->name('front.frontlogin');

Route::get('/', [HomeController::class, 'userDashboard'])->name('user.dashboard');
Route::get('/', [HomeController::class, 'index'])->name('user.index');

Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('user.contactUs');
Route::get('/about-us', [HomeController::class, 'aboutus'])->name('user.aboutus');

Route::Post('/contact-us-add', [HomeController::class, 'ContactUsadd'])->name('user.ContactUsadd');

//front courses
Route::get('/courses', [HomeController::class, 'courses'])->name('users.courses');

Route::middleware(['web'])->group(function () {
    Route::post('/admin/login', [App\Http\Controllers\AdminController::class, 'login'])->name('admin.login');
    
    // **FIX 5: Change to POST request and remove unnecessary 'any'**
    Route::post('/admin/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
});

Route::get('admin/index', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
Route::get('admin/login', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
Route::get('admin/index', [App\Http\Controllers\AdminController::class, 'index'])->name('login');
// Route::post('/admin/verify-otp', [AdminController::class, 'verifyAdminOtp'])->name('admin.verifyOtp');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('admin/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // rise civils
    Route::get('admin/types', [AdminController::class, 'typesOf'])->name('admin.types');
    Route::get('admin/add-types', [AdminController::class, 'addTypes'])->name('admin.addTypes');
    Route::post('admin/store-types', [AdminController::class, 'storeTypes'])->name('admin.storeTypes');
    Route::get('admin/edit-types/{id}', [AdminController::class, 'editTypes'])->name('admin.editTypes');
    Route::post('admin/update-types/{id}', [AdminController::class, 'updateTypes'])->name('admin.updateTypes');
    Route::delete('admin/type/delete/{id}', [AdminController::class, 'deleteType'])->name('type.delete');
    
    Route::get('admin/category', [AdminController::class, 'category'])->name('admin.category');
    Route::get('admin/add-category', [AdminController::class, 'addCategory'])->name('admin.addCategory');
    Route::post('admin/store-category', [AdminController::class, 'storeCategory'])->name('admin.storeCategory'); 
    Route::get('admin/category/edit/{id}', [AdminController::class, 'editCategory'])->name('admin.editCategory');
    Route::post('admin/category/update/{id}', [AdminController::class, 'updateCategory'])->name('admin.updateCategory');
    Route::delete('/admin/delete-category/{id}', [AdminController::class, 'deleteCategory'])->name('admin.deleteCategory');
    Route::get('/admin/get-order-no-by-category', [AdminController::class, 'getOrderNoByCategory'])->name('admin.getOrderNoByCategory');
    
    
    Route::get('/admin/chapter', [AdminController::class, 'chapter'])->name('admin.chapter');
    Route::get('/admin/add-chapter', [AdminController::class, 'addChapter'])->name('admin.addChapter');
    Route::post('/admin/store-chapter', [AdminController::class, 'storeChapter'])->name('admin.storeChapter');
    Route::get('/admin/chapter/edit/{id}', [AdminController::class, 'editChapter'])->name('admin.editChapter');
    Route::put('/admin/chapter/update/{id}', [AdminController::class, 'updateChapter'])->name('admin.updateChapter');
    Route::delete('/admin/delete-chapter/{id}', [AdminController::class, 'deleteChapter'])->name('admin.deleteChapter');
    Route::get('/admin/get-order-no-by-chapter', [AdminController::class, 'getOrderNoByChapter'])->name('admin.getOrderNoByChapter');
    
    Route::get('admin/subject', [AdminController::class, 'subjects'])->name('admin.subject');
    Route::get('admin/add-subject', [AdminController::class, 'addSubjects'])->name('admin.addSubjects');
    Route::get('/admin/categories/by-type/{type}', [AdminController::class, 'getCategoriesByType'])->name('admin.categories.byType');
    Route::post('/admin/store-subject', [AdminController::class, 'storeSubject'])->name('admin.storeSubject');
    

    Route::get('admin/posts', [AdminController::class, 'postsList'])->name('admin.posts');
    Route::get('admin/add-posts', [AdminController::class, 'addPosts'])->name('admin.addPosts');
    Route::post('admin/store-posts', [AdminController::class, 'storePosts'])->name('admin.storePosts');
    Route::get('admin/edit-posts/{id}', [AdminController::class, 'editPosts'])->name('admin.editPosts');
    Route::put('admin/update-posts/{id}', [AdminController::class, 'updatePosts'])->name('admin.updatePosts');
    Route::delete('/admin/delete-post/{id}', [AdminController::class, 'deletePost'])->name('post.delete');
    Route::get('/download-pdf/{slug}', [AdminController::class, 'downloadPdf'])->name('pdf.download');
    Route::post('/ckeditor/upload', [AdminController::class, 'uploadPDF'])->name('ckeditor.upload');
    
    Route::get('/link-page/{slug}', function($slug){
        $post = Posts::with(['category.parent.parent'])
                     ->where('slug', $slug)
                     ->firstOrFail(); // fetch single post
    
        return view('admin.Rise.index', [
            'post' => $post,
            'category' => $post->category // pass related category
        ]);
    });
    
    Route::get('/study-posts/{categorySlug}/{chapterSlug}/{slug}', [StudyMaterialController::class, 'showPost'])->name('study.post.view');


   
    
    //Study material
    Route::get('/{slug}', [StudyMaterialController::class, 'viewBlog'])->name('admin.viewBlog');
    // Route::get('/category/{id}', [StudyMaterialController::class, 'categoryBlogs'])->name('category.blog');

    // bhavesh
    Route::get('/study-material/{slug}', [StudyMaterialController::class, 'categoryBlogs'])->name('category.blog');
    Route::get('/study-material/{parentSlug}/{slug}', [StudyMaterialController::class, 'innerSubCategory'])->name('category.innerSubCategory');
    
    // Route::get('/study-posts/{parentSlug}/{slug}', [StudyMaterialController::class, 'postPageViewDetail'])->name('category.posts');
    Route::get('/study-posts/{categorySlug}/{parentSlug}/{slug}', [StudyMaterialController::class, 'postPageViewDetail'])->name('category.posts');



    //courses
    Route::get('/admin/courses', [AdminController::class, 'coursesList'])->name('admin.courses');
    Route::get('/admin/create-courses', [AdminController::class, 'createCourse'])->name('admin.createCourse');
    Route::post('/admin/store-courses', [AdminController::class, 'storeCourse'])->name('admin.storeCourse');
    Route::get('/admin/edit-courses/{id}', [AdminController::class, 'editCourse'])->name('admin.editCourse');
    Route::put('/admin/update-courses/{id}', [AdminController::class, 'updateCourse'])->name('admin.updateCourse');
    Route::delete('/admin/delete-courses/{id}', [AdminController::class, 'deleteCourse'])->name('admin.deleteCourse');
    
    Route::get('/admin/users', [AdminController::class, 'usersList'])->name('admin.users');
    Route::delete('/admin/delete-users/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    
    //setting
    Route::get('/admin/page-setting', [AdminController::class, 'pageSetting'])->name('admin.page-setting');
    Route::put('/admin/page-setting', [AdminController::class, 'updatePageSetting'])->name('admin.page.setting.update');
    
    
    Route::get('/admin/slider', [AdminController::class, 'pageSlider'])->name('admin.page-slider');
    Route::get('/admin/slider-list', [AdminController::class, 'pageSliderList'])->name('admin.pageSliderList');
    Route::post('/admin/add-slider', [AdminController::class, 'storePageSliders'])->name('admin.storePageSliders');
    Route::get('/admin/edit-slider/{id}', [AdminController::class, 'editPageSlider'])->name('admin.editPageSlider');
    Route::put('/admin/update-slider/{id}', [AdminController::class, 'updatePageSlider'])->name('admin.updatePageSlider');
    Route::delete('/admin/delete-slider/{id}', [AdminController::class, 'deletePageSlider'])->name('admin.deletePageSlider');
    
    //home section 
    Route::get('/admin/headings', [AdminController::class, 'listHeading'])->name('admin.listHeading');
    Route::get('/admin/add-heading', [AdminController::class, 'addHeading'])->name('admin.addHeading');
    // Add Heading
    Route::post('/admin/store-heading', [AdminController::class, 'storeHeading'])->name('admin.storeHeading');
    // Get Heading for Edit (AJAX)
    Route::get('/admin/edit-heading/{id}', [AdminController::class, 'editHeading'])->name('admin.editHeading');
    // Update Heading
    Route::post('/admin/update-heading/{id}', [AdminController::class, 'updateHeading'])->name('admin.updateHeading');
    Route::delete('/admin/delete-heading/{id}', [AdminController::class, 'deleteHeading'])->name('admin.deleteHeading');

    // about
    Route::get('/admin/about-us', [AdminController::class, 'aboutUs'])
        ->name('admin.aboutUs');
    Route::put('/admin/about-us/update/{id}', [AdminController::class, 'updateAboutUs'])
        ->name('admin.about.update');
    
    // contact-us
    Route::get('/admin/contact-us', [AdminController::class, 'contactUs'])
        ->name('admin.contactUs');
    Route::put('/admin/contact-us/update/{id}', [AdminController::class, 'updateContactUs'])
        ->name('admin.contact.update');
    
});

Route::post('/logout', function () { // Changed to POST for security
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return response()->json(['message' => 'Logged out successfully'], 200);
})->name('logout');

Route::get('/index', [App\Http\Controllers\HomeController::class, 'index'])->name('front.index');
