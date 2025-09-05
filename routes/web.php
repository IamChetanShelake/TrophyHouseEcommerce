<?php

use App\Models\SubCategory;
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\ValidUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\OccasionController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\OccasionProductController;
use App\Http\Controllers\PaymentController;

use App\Http\Controllers\Admin\PaymentAdminController;

use App\Models\CustomizationRequest;
use App\Models\PaymentItem;
use App\Models\CustomizationMessage;

use App\Models\Customization_image;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;




/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/about-us', [WebsiteController::class, 'Websiteindex'])->name('about.us');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');
Route::post('/contact', [WebsiteController::class, 'storeContact'])->name('contact.store');
Route::get('/gallery', [WebsiteController::class, 'gallery'])->name('gallery');
Route::get('/view-category/{id}', [WebsiteController::class, 'viewCategory'])->name('view.category');
// Show products under a subcategory
Route::get('/subcategory/{id}', [CategoryController::class, 'showSubcategory'])->name('view.subcategory');


Route::get('/subcategory-products/{id}', [ProductController::class, 'getProductsBySubcategory'])->name('subcategory.products');

//cartpage  routes
Route::get('/cart-page', [WebsiteController::class, 'cart'])->name('cartPage');


Route::get('/address', [WebsiteController::class, 'address'])->name('addressPage');
Route::get('/Deliveryaddress', [WebsiteController::class, 'Deliveryaddress'])->name('DeliveryaddressPage');
// Route::get('/contact', [WebsiteController::class, 'contact'])->name('contactPage');
// Route::get('/photoGallery', [WebsiteController::class, 'photoGallery'])->name('photoGalleryPage');
Route::get('/privacyPolicy', [WebsiteController::class, 'privacyPolicy'])->name('privacyPolicyPage');
Route::get('/termAndCond', [WebsiteController::class, 'termAndCond'])->name('termAndCondPage');
// Route::get('/returnPolicy', [WebsiteController::class, 'returnPolicy'])->name('returnPolicyPage');
Route::get('/refundPolicy', [WebsiteController::class, 'refundPolicy'])->name('refundPolicyPage');
Route::get('/payment', [WebsiteController::class, 'payment'])->name('payment');
Route::post('/generate-bill', [WebsiteController::class, 'generateBill'])->name('generate.bill');
// end-------------------------------------------------------------------------------------
Route::any('/ProductDetail/{id}', [CartItemController::class, 'productDetail'])->name('productDetail');

Route::any('/View-Products', [WebsiteController::class, 'viewProducts'])->name('viewproducts');

Route::post('/getintouch', [WebsiteController::class, 'sendGetintouch'])->name('getintouch.send');

Route::any('/PageDetail/{id}', [WebsiteController::class, 'pageDetail'])->name('pageDetail');

// Public filter for home page price filter
Route::get('/filterProducts', [ProductController::class, 'filterProducts'])->name('filterProducts');
// route for price dropdown in home blade 
Route::get('/products/filter', [ProductController::class, 'filterByPrice'])->name('products.filter');

Route::get('/', [WebsiteController::class, 'Websiteindex'])->name('Websitehome');
Route::middleware(['auth'])->group(function () {

    // designer--------------------------------------------------------------------------------------
    Route::get('Designer', [DesignerController::class, 'index'])->name('Designerinfo');
    Route::get('addDesigner', [DesignerController::class, 'create'])->name('designer.add');
    Route::post('store-Designer', [DesignerController::class, 'store'])->name('designer.store');
    Route::get('viewDesigner/{id?}', [DesignerController::class, 'show'])->name('designer.view');
    Route::get('editDesigner/{id?}', [DesignerController::class, 'edit'])->name('designer.edit');
    Route::put('update-Designer/{id?}', [DesignerController::class, 'update'])->name('designer.update');
    Route::delete('delete-Designer/{id?}', [DesignerController::class, 'destroy'])->name('designer.destroy');



    // Cart

    Route::any('/add-to-cart', [CartItemController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/{id}', [CartItemController::class, 'destroy'])->name('cart.delete');
    Route::post('cart/update/{id}', [WebsiteController::class, 'cartupdate'])->name('cart.update');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
    Route::post('/wishlist/update-quantity', [WishlistController::class, 'updateQuantity'])->name('wishlist.updateQuantity');
    Route::post('/wishlist/update', [WishlistController::class, 'updateQuantity'])->name('wishlist.update');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
    Route::get('/wishlist/get-item/{product_id}', [WishlistController::class, 'getWishlistItem'])->middleware('auth')->name('wishlist.getItem');
    Route::post('/wishlist/proceed-to-cart', [WishlistController::class, 'proceedToCart'])->name('wishlist.proceedToCart');

    // designer customization routes
    Route::prefix('designer')->group(function () {

        Route::get('/dashboard', [CustomizationController::class, 'showRequests'])->name('dashboard');
        Route::get('/requests', [CustomizationController::class, 'showRequests'])->name('requests');
        Route::get('/recustomizations', [CustomizationController::class, 'showRecustomizations'])->name('recustomizations');

        Route::get('/chats/{customizationRequestId?}', [CustomizationController::class, 'designerChats'])->name('chats');

        // Route::post('/chat/{userId}', [CustomizationController::class, 'sendDesignerMessage'])->name('send.message');

        Route::any('/test', function () {
            return "Server is working!";
        })->name('test');


        Route::post('/designer/chats/send/{customizationRequestId}', [CustomizationController::class, 'sendMessage'])
            ->name('send.message')
            ->middleware('auth');

        // Route::post('/accept/{id}', [CustomizationController::class, 'acceptRequest'])->name('accept');
        // Route::post('/reject/{id}', [CustomizationController::class, 'rejectRequest'])->name('reject');
        // Route::get('/workspace/{id}', [CustomizationController::class, 'workspace'])->name('workspace');

        Route::post('/workspace/{id}', [CustomizationController::class, 'completeRequest'])->name('submit');
    });
    // Order-level workspace
    Route::get('/workspace/order/{orderId}', [CustomizationController::class, 'orderWorkspace'])
        ->name('workspace.order');

    Route::post('/customization/request/{cartId}', [CartItemController::class, 'createCustomizationRequest'])->name('customization.request');
    Route::post('/customization/request/myorders/{itemId}', [CartItemController::class, 'createCustomizationRequestforOfflineOrders'])->name('customization.request.orders');

    Route::post('/customization/accept/{orderId}', [CustomizationController::class, 'acceptRequest'])->name('customization.accept');

    Route::post('/customization/reject/{orderId}', [CustomizationController::class, 'rejectRequest'])->name('customization.reject');

    Route::post('/customization/transfer/{orderId}', [CustomizationController::class, 'transferRequest'])->name('customization.transfer');

    Route::post('/customization/approve-image/{message}', [CustomizationController::class, 'approveImage'])
        ->name('customization.approveImage');

    Route::post('/customization/cancel-approval/{message}', [CustomizationController::class, 'cancelApproval'])->name('customization.cancelApproval');


    Route::post('/customization/finalize/{order_id}', [CustomizationController::class, 'finalize'])
        ->name('customization.finalize');





    Route::any('/customization/{id}/approve', [CustomizationController::class, 'approveRequest'])->name('customization.approve');

    Route::get('/customization/workspace/{id}', [CustomizationController::class, 'workspace'])->name('customization.workspace');

    Route::post('/customization/complete/{id}', [CustomizationController::class, 'completeRequest'])->name('customization.complete');

    Route::post('/customization/{id}/send-message', [CustomizationController::class, 'sendMessage'])->name('customization.sendMessage');

    Route::get('/customization/chat/{id?}', [CustomizationController::class, 'userChat'])->name('customization.userchat');
    Route::post('/customization/chat/send/{id}', [CustomizationController::class, 'sendUserMessage'])->name('customization.userchat.send');

    Route::post('/customization/{id}/request-edit', [CustomizationController::class, 'requestEdit'])->name('customization.request-edit');

    // Production Panel
    Route::get('/production/requests', [WebsiteController::class, 'productionRequests'])->name('production.requests');
    Route::post('/production/{id}/status', [ProductionController::class, 'updateStatus'])->name('production.updateStatus');



    // Address Management
    Route::post('/address/store', [WebsiteController::class, 'storeAddress'])->name('address.store');
    Route::get('/addnewaddress', [WebsiteController::class, 'addnewaddress'])->name('addnewaddress.new');
    Route::get('/address/edit/{id}', [WebsiteController::class, 'editAddress'])->name('address.edit');
    Route::put('/address/update/{id}', [WebsiteController::class, 'updateAddress'])->name('address.update');
    Route::delete('/address/delete/{id}', [WebsiteController::class, 'deleteAddress'])->name('address.delete');
    Route::post('/address/set-default/{id}', [WebsiteController::class, 'setDefaultAddress'])->name('address.setDefault');
    Route::get('/filter-products', [WebsiteController::class, 'filterProducts']);


    //profile---------------------------------
    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('changePassword');
    Route::put('/update-password', [ProfileController::class, 'updatePassword'])->name('passwordUpdate');
    Route::put('/update-profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/profile/upload-image', [ProfileController::class, 'uploadImage'])->name('profile.image.upload');

    // Orders
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my.orders');
    Route::get('/order-details/{id}', [OrderController::class, 'orderDetails'])->name('order.details');
    Route::get('/payment-details/{order_id}', [OrderController::class, 'paymentDetails'])->name('payment.details');
});

/*
|--------------------------------------------------------------------------
| Google auth
|--------------------------------------------------------------------------
*/
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google-auth');
Route::get('/auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle'])->name('google-callback');

Auth::routes();

/*
|--------------------------------------------------------------------------
| Admin area
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', isAdmin::class])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Users
    Route::get('users', [HomeController::class, 'users'])->name('users');
    Route::get('show-user/{id?}', [HomeController::class, 'show'])->name('user.show');

    // About
    Route::get('about', [AboutController::class, 'index'])->name('about');
    Route::get('addAbout', [AboutController::class, 'create'])->name('about.add');
    Route::post('store-about', [AboutController::class, 'store'])->name('about.store');
    Route::get('viewAbout/{id?}', [AboutController::class, 'show'])->name('about.view');
    Route::get('editAbout/{id?}', [AboutController::class, 'edit'])->name('about.edit');
    Route::put('update-about/{id?}', [AboutController::class, 'update'])->name('about.update');
    Route::delete('delete-about/{id?}', [AboutController::class, 'destroy'])->name('about.destroy');

    // Dynamic Subcategory Fetch
    Route::get('/get-subcategories/{category_id}', function ($category_id) {
        return SubCategory::where('category_id', $category_id)->get();
    });

    //Occasions CRUD---------------------------
    Route::get('occasions', [OccasionController::class, 'index'])->name('occasion');
    Route::get('add-occasions', [OccasionController::class, 'create'])->name('occasion.add');
    Route::post('store-occasions', [OccasionController::class, 'store'])->name('occasion.store');
    Route::get('view-occasions/{id}', [OccasionController::class, 'show'])->name('occasion.show');
    Route::get('edit-occasions/{id}', [OccasionController::class, 'edit'])->name('occasion.edit');
    Route::put('update-occasions/{id}', [OccasionController::class, 'update'])->name('occasion.update');
    Route::delete('destroy-occasions/{id}', [OccasionController::class, 'destroy'])->name('occasion.destroy');

    //occasional Products-------------------------------------------------------------------
    Route::get('occasional-products', [OccasionProductController::class, 'products'])->name('occproducts');
    Route::get('add-occasionalProducts', [OccasionProductController::class, 'addproducts'])->name('occProduct.add');
    Route::post('store-occasionalProducts', [OccasionProductController::class, 'storeproduct'])->name('occproduct.store');
    Route::get('edit-occasionalProduct/{id}', [OccasionProductController::class, 'editproduct'])->name('occproduct.edit');
    Route::get('show-occasionalProduct/{id}', [OccasionProductController::class, 'showproduct'])->name('occproduct.show');
    Route::any('update-occasionalProduct/{id}', [OccasionProductController::class, 'updateproduct'])->name('occproduct.update');
    Route::any('destroy-occasionalProduct/{id}', [OccasionProductController::class, 'destroyproduct'])->name('occproduct.destroy');
    Route::any('/occasional-product/image/{id}', [OccasionProductController::class, 'deleteImage'])->name('deleteOccProductImage');

    // excel upload -----------------------------------------------------------------------
    Route::any('occasional-product-import', [OccasionProductController::class, 'import'])->name('OccProducts.import');



    // Team
    Route::get('team', [TeamController::class, 'index'])->name('teams');
    Route::get('addTeam', [TeamController::class, 'create'])->name('team.add');
    Route::post('store-team', [TeamController::class, 'store'])->name('team.store');
    Route::get('editTeam/{id}', [TeamController::class, 'edit'])->name('team.edit');
    Route::get('viewTeam/{id}', [TeamController::class, 'show'])->name('team.view');
    Route::put('update-team/{id}', [TeamController::class, 'update'])->name('team.update');
    Route::delete('delete-team/{id}', [TeamController::class, 'destroy'])->name('team.destroy');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/addProducts', [ProductController::class, 'add'])->name('product.add');
    Route::post('/store-products', [ProductController::class, 'store'])->name('product.store');
    Route::get('/viewProducts/{id?}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/editProducts/{id?}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/update-products/{id?}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/destroy-products/{id?}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::post('/product/toggle/{id}', [ProductController::class, 'toggleField'])->name('product.toggleField');
    Route::any('/product/image/{id}', [ProductController::class, 'deleteImage'])->name('deleteProductImages');
    Route::post('/productsize/{id}/add-quantity', [ProductController::class, 'addQuantity'])->name('product.addQuantity');





    //excel upload------------------------------------------------------------------
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');

    // Cart
    Route::get('/cart', [ProductController::class, 'cart'])->name('cart');

    // Orders
    // Route::get('/orders', [ProductController::class, 'orders'])->name('orders');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');


    Route::get('orders/user/{orderId}', [OrderController::class, 'getUserDetails'])->name('user');
    Route::get('orders/{orderId}/products', [OrderController::class, 'showOrderProducts'])->name('orders.products');

    Route::get('/admin/orders/product/{productId}/chat', [OrderController::class, 'productChat']);



    // Single order details
    Route::get('orders/{payment}', [OrderController::class, 'show'])->name('orders.show');

    // Update per-item delivery status
    Route::any('orders/item/{id}/delivery_status', [OrderController::class, 'updateDeliveryStatus'])
        ->name('orders.item.delivery_status');

    Route::put('/updateStatus/{id}', [ProductController::class, 'updateStatus'])->name('update.status');
    Route::get('/ViewOrder/{id}', [OrderController::class, 'viewOrder'])->name('order.view');


    Route::get('/createorder', [OrderController::class, 'createorder'])->name('createorder');
    Route::post('/offlineorderstore', [OrderController::class, 'offlineorderstore'])->name('offlineorder.store');

    Route::get('/get-subcategories/{id}', [OrderController::class, 'getSubcategories']);
    Route::get('/get-products_list/{id}', [OrderController::class, 'getProducts']);
    Route::get('/get-sizes/{productId}', [OrderController::class, 'getSizes']);
    // web.php
    Route::post('/check-user', [OrderController::class, 'checkUser'])->name('checkUser');



    // Categories
    Route::get('/category', [CategoryController::class, 'index'])->name('category');
    Route::get('/addCategory', [CategoryController::class, 'create'])->name('category.add');
    Route::post('/store-category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/editCategory/{id?}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::get('/viewCategory/{id?}', [CategoryController::class, 'show'])->name('category.show');
    Route::put('/update-category/{id?}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/delete-category/{id?}', [CategoryController::class, 'destroy'])->name('category.destroy');

    // Subcategories
    Route::get('/subcat', [SubCategoryController::class, 'index'])->name('subCategory');
    Route::get('/addSubcat', [SubCategoryController::class, 'create'])->name('subCategory.add');
    Route::post('/store-subcat', [SubCategoryController::class, 'store'])->name('subCategory.store');
    Route::get('/showSubcat/{id?}', [SubCategoryController::class, 'show'])->name('subCategory.show');
    Route::get('/editSubcat/{id?}', [SubCategoryController::class, 'edit'])->name('subCategory.edit');
    Route::put('/update-subcat/{id?}', [SubCategoryController::class, 'update'])->name('subCategory.update');
    Route::delete('/destroy-subcat/{id?}', [SubCategoryController::class, 'destroy'])->name('subCategory.destroy');

    // Pages
    Route::get('/pages', [PageController::class, 'index'])->name('pages');
    Route::get('/addPage', [PageController::class, 'create'])->name('page.add');
    Route::post('/store-page', [PageController::class, 'store'])->name('page.store');
    Route::get('/editPage/{id?}', [PageController::class, 'edit'])->name('page.edit');
    Route::get('/viewPage/{id?}', [PageController::class, 'show'])->name('page.view');
    Route::put('/update-page/{id?}', [PageController::class, 'update'])->name('page.update');
    Route::delete('/delete-page/{id?}', [PageController::class, 'destroy'])->name('page.destroy');

    // Testimonials
    Route::get('testimonials', [TestimonialController::class, 'index'])->name('tests');
    Route::get('/addTestimonial', [TestimonialController::class, 'create'])->name('test.add');
    Route::post('/store-testimonial', [TestimonialController::class, 'store'])->name('test.store');
    Route::get('/editTestimonial/{id?}', [TestimonialController::class, 'edit'])->name('test.edit');
    Route::get('/viewTestimonial/{id?}', [TestimonialController::class, 'show'])->name('test.view');
    Route::put('/update-testimonial/{id?}', [TestimonialController::class, 'update'])->name('test.update');
    Route::delete('/delete-testimonial/{id?}', [TestimonialController::class, 'destroy'])->name('test.destroy');
    // Clients---------------------------------------------------------------------------------------------
    Route::get('clients', [ClientController::class, 'index'])->name('clients');
    Route::get('add-client', [ClientController::class, 'create'])->name('client.add');
    Route::post('store-client', [ClientController::class, 'store'])->name('client.store');
    Route::get('viewClient/{id?}', [ClientController::class, 'show'])->name('client.view');
    Route::get('editClient/{id?}', [ClientController::class, 'edit'])->name('client.edit');
    Route::put('update-Client/{id?}', [ClientController::class, 'update'])->name('client.update');
    Route::delete('delete-Client/{id?}', [ClientController::class, 'destroy'])->name('client.destroy');

    // gallery--------------------------------------------------------------------------------------
    Route::get('Gallery', [GalleryController::class, 'index'])->name('Admingallery');
    Route::get('addGallery', [GalleryController::class, 'create'])->name('gallery.add');
    Route::post('store-Gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('viewGallery/{id?}', [GalleryController::class, 'show'])->name('gallery.view');
    Route::get('editGallery/{id?}', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::put('update-Gallery/{id?}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('delete-Gallery/{id?}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
});

Route::get('/clean-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:cache');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('event:cache');
    $exitCode = Artisan::call('event:clear');
    $exitCode = Artisan::call('optimize');
    return '<h1>Cache facade value cleared</h1>';
});

Route::post('/pay', 'App\Http\Controllers\PaymentController@createOrder')->name('pay');
Route::get('/payment-callback', 'App\Http\Controllers\PaymentController@paymentCallback');
Route::post('/payment-webhook', 'App\Http\Controllers\PaymentController@paymentWebhook');

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/payments', 'App\Http\Controllers\Admin\PaymentAdminController@index')->name('admin.payments');
    Route::get('/admin/payments/{order_id}/details', 'App\Http\Controllers\Admin\PaymentAdminController@details')->name('admin.payments.details');
    Route::get('/admin/payments/{order_id}/show', 'App\Http\Controllers\Admin\PaymentAdminController@show')->name('admin.payments.show');
    Route::get('/admin/payments/{order_id}/invoice', 'App\Http\Controllers\Admin\PaymentAdminController@invoice')->name('admin.payments.invoice');
    Route::get('/admin/payments/analytics', 'App\Http\Controllers\Admin\PaymentAdminController@analytics')->name('admin.payments.analytics');
});
// Route::middleware(['auth',isAdmin::class])->group(function()
//         {
//             Route::get('/home', [HomeController::class, 'index'])->name('home');

//                 // users table---------------------------------------------------------------------------
//                 Route::get('users',[HomeController::class,'users'])->name('users');
//                 Route::get('show-user/{id?}',[HomeController::class,'show'])->name('user.show');

//                 // about--------------------------------------------------------------------------------------
//                 Route::get('about',[AboutController::class,'index'])->name('about');
//                 Route::get('addAbout',[AboutController::class,'create'])->name('about.add');
//                 Route::post('store-about',[AboutController::class,'store'])->name('about.store');
//                 Route::get('viewAbout/{id?}',[AboutController::class,'show'])->name('about.view');
//                 Route::get('editAbout/{id?}',[AboutController::class,'edit'])->name('about.edit');
//                 Route::put('update-about/{id?}',[AboutController::class,'update'])->name('about.update');
//                 Route::delete('delete-about/{id?}',[AboutController::class,'destroy'])->name('about.destroy');

//                 Route::get('/get-subcategories/{category_id}', function ($category_id) {
//                     return SubCategory::where('category_id', $category_id)->get();
//                 });



//                 // team-------------------------------------------------------------------------------------------
//                 Route::get('team',[TeamController::class,'index'])->name('teams');
//                 Route::get('addTeam',[TeamController::class,'create'])->name('team.add');
//                 Route::post('store-team',[TeamController::class,'store'])->name('team.store');
//                 Route::get('editTeam/{id}',[TeamController::class,'edit'])->name('team.edit');
//                 Route::get('viewTeam/{id}',[TeamController::class,'show'])->name('team.view');
//                 Route::put('update-team/{id}',[TeamController::class,'update'])->name('team.update');
//                 Route::delete('delete-team/{id}',[TeamController::class,'destroy'])->name('team.destroy');


//                 // products controller -------------------------------------------------------
//                 Route::get('/products', [ProductController::class, 'index'])->name('products');
//                 Route::get('/addProducts', [ProductController::class, 'add'])->name('product.add');
//                 Route::post('/store-products', [ProductController::class, 'store'])->name('product.store');
//                 Route::get('/viewProducts/{id?}', [ProductController::class, 'show'])->name('product.show');
//                 Route::get('/editProducts/{id?}', [ProductController::class, 'edit'])->name('product.edit');
//                 Route::put('/update-products/{id?}', [ProductController::class, 'update'])->name('product.update');
//                 Route::delete('/destroy-products/{id?}', [ProductController::class, 'destroy'])->name('product.destroy');
//                 // Route::post('/product/toppick/{id}', [ProductController::class, 'toppick'])->name('product.toppick');
//                 // Route::post('/product/bestseller/{id}', [ProductController::class, 'bestseller'])->name('product.bestseller');
//                 // Route::post('/product/newarrival/{id}', [ProductController::class, 'newarrival'])->name('product.newarrival');

//                 Route::post('/product/toggle/{id}', [ProductController::class, 'toggleField'])->name('product.toggleField');

//                 //cart -----------------------------------------------------------------------------------
//                 Route::get('/cart', [ProductController::class, 'cart'])->name('cart');

//                 Route::get('/orders', [ProductController::class, 'orders'])->name('orders');
//                 Route::put('/updateStatus/{id}', [ProductController::class, 'updateStatus'])->name('update.status');
//                 Route::get('/ViewOrder/{id}', [OrderController::class, 'viewOrder'])->name('order.view');




//                 //category-------------------------------------------------------------------
//                 Route::get('/category',[CategoryController::class,'index'])->name('category');
//                 Route::get('/addCategory',[CategoryController::class,'create'])->name('category.add');
//                 Route::post('/store-category',[CategoryController::class,'store'])->name('category.store');
//                 Route::get('/editCategory/{id?}',[CategoryController::class,'edit'])->name('category.edit');
//                 Route::get('/viewCategory/{id?}',[CategoryController::class,'show'])->name('category.show');
//                 Route::put('/update-category/{id?}',[CategoryController::class,'update'])->name('category.update');
//                 Route::delete('/delete-category/{id?}',[CategoryController::class,'destroy'])->name('category.destroy');

//                 // sub-cateegory --------------------------------------------------------------------------------
//                 Route::get('/subcat',[SubCategoryController::class,'index'])->name('subCategory');
//                 Route::get('/addSubcat',[SubCategoryController::class,'create'])->name('subCategory.add');
//                 Route::post('/store-subcat',[SubCategoryController::class,'store'])->name('subCategory.store');
//                 Route::get('/showSubcat/{id?}',[SubCategoryController::class,'show'])->name('subCategory.show');
//                 Route::get('/editSubcat/{id?}',[SubCategoryController::class,'edit'])->name('subCategory.edit');
//                 Route::put('/update-subcat/{id?}',[SubCategoryController::class,'update'])->name('subCategory.update');
//                 Route::delete('/destroy-subcat/{id?}',[SubCategoryController::class,'destroy'])->name('subCategory.destroy');


//                 // pages----------------------------------------------------------------------------------------
//                 Route::get('/pages',[PageController::class,'index'])->name('pages');
//                 Route::get('/addPage',[PageController::class,'create'])->name('page.add');
//                 Route::post('/store-page',[PageController::class,'store'])->name('page.store');
//                 Route::get('/editPage/{id?}',[PageController::class,'edit'])->name('page.edit');
//                 Route::get('/viewPage/{id?}',[PageController::class,'show'])->name('page.view');
//                 Route::put('/update-page/{id?}',[PageController::class,'update'])->name('page.update');
//                 Route::delete('/delete-page/{id?}',[PageController::class,'destroy'])->name('page.destroy');


//                 // testimonials-------------------------------------------------------------------------------
//                 Route::get('testimonials',[TestimonialController::class,'index'])->name('tests');
//                 Route::get('/addTestimonial',[TestimonialController::class,'create'])->name('test.add');
//                 Route::post('/store-testimonial',[TestimonialController::class,'store'])->name('test.store');
//                 Route::get('/editTestimonial/{id?}',[TestimonialController::class,'edit'])->name('test.edit');
//                 Route::get('/viewTestimonial/{id?}',[TestimonialController::class,'show'])->name('test.view');
//                 Route::put('/update-testimonial/{id?}',[TestimonialController::class,'update'])->name('test.update');
//                 Route::delete('/delete-testimonial/{id?}',[TestimonialController::class,'destroy'])->name('test.destroy');







//         });
