<?php

// use Illuminate\Support\Facades\Route;

// Route::get('/testapi', function () {
//     return response()->json(['status' => 'api route loaded']);
// });


// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use App\Http\Middleware\ValidUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CartApiController;
use App\Http\Controllers\api\ProfileController;
use App\Http\Controllers\api\galleryApicontroller;
use App\Http\Controllers\api\addressApiController;
use App\Http\Controllers\api\ProductApiController;
use App\Http\Controllers\api\CategoryApiController;
use App\Http\Controllers\api\wishlistApiController;
use App\Http\Controllers\api\occProductApiController;
use App\Http\Controllers\api\subCategoryApiController;
use App\Http\Controllers\api\orderApiController;
use App\Http\Controllers\api\customizationApiController;



Route::get('/testapi', function () {
    return 'API working';
});



// api routes-------------------------------------------------

//authentication------------------------------------------------
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


//product----------------------------------------------------------------

Route::post('/storeProduct', [ProductApiController::class, 'storeproduct']);
Route::get('/products', [ProductApiController::class, 'allproducts']);
Route::get('/product/{id}', [ProductApiController::class, 'showproduct']);
Route::put('/updateProduct/{id}', [ProductApiController::class, 'updateproduct']);
Route::delete('/deleteProduct/{id}', [ProductApiController::class, 'deleteProduct']);
Route::get('/searchProduct', [ProductApiController::class, 'search']);
Route::get('/products/filter', [ProductApiController::class, 'filterProducts']);

// getProductsByCategoryAndSubcategory-------------------------------------------------
Route::any('/getProductsByCategoryAndSubcategory', [ProductApiController::class, 'getProductsByCategoryAndSubcategory']);

//occasional product ---------------------------------------------------------
Route::get('/occasionalProducts', [occProductApiController::class, 'allproducts']);
Route::post('/storeOccasionalProduct', [occProductApiController::class, 'storeproduct']);
Route::get('/OccProduct/{id}', [occProductApiController::class, 'showOccproduct']);
Route::put('/updateProduct/{id}', [occProductApiController::class, 'updateproduct']);
Route::delete('/deleteProduct/{id}', [occProductApiController::class, 'deleteProduct']);
Route::get('/searchOccasionalProduct', [occProductApiController::class, 'search']);

//categories----------------------------------------------------------------
Route::get('/categories', [CategoryApiController::class, 'allcat']);
Route::post('storeCategory/', [CategoryApiController::class, 'storeCategory']);         // Create
Route::get('show-Category/{id}', [CategoryApiController::class, 'showCategory']);       // Single category
Route::put('updatecategory/{id}', [CategoryApiController::class, 'updateCategory']);     // Update
Route::delete('deletecategory/{id}', [CategoryApiController::class, 'destroyCategory']);                      // delete category

// sub-categories----------------------------------------------------------------
Route::get('/subcategories', [subCategoryApiController::class, 'index']);
Route::post('/storeSubcategory', [subCategoryApiController::class, 'store']);
Route::get('/showSubcategory/{id}', [subCategoryApiController::class, 'show']);
Route::put('/updateSubcategories/{id}', [subCategoryApiController::class, 'update']);
Route::delete('/deleteSubcategories/{id}', [subCategoryApiController::class, 'destroy']);

Route::post('/getsubcategories', [subCategoryApiController::class, 'getsubcategories']);



// orders api----------------------------------------------------------------
  Route::post('/my-orders', [orderApiController::class, 'myOrders']);

// gallery api----------------------------------------------------------------

Route::get('/gallery', [galleryApicontroller::class, 'gallery']);

// wishlist----------------------------------------------------------------

Route::post('/wishlist/add', [wishlistApiController::class, 'addToWishlist']);
Route::post('/wishlist', [wishlistApiController::class, 'index']);
Route::post('/wishlist/remove', [wishlistApiController::class, 'removeFromWishlist']);


    Route::post('/editprofile', [ProfileController::class, 'editProfile']);
    Route::post('/getProfile', [ProfileController::class, 'getProfile']);
    Route::post('/getProfile', [ProfileController::class, 'getProfile']);
  

//cart-----------------------------------------------------------------------
// Route::middleware('auth')->group(function () {



// Route::middleware(['auth'])->group(function () {
    
    Route::get('/user', function (Request $request) {
    return $request->user();
    });
    
     Route::post('/user', function (Request $request) {
   // $userId =  $request->user_id;
    
    $user = User::find($request->user_id);
    
        if(isset($user)){
         return response()->json([
            'status' => true,
            'status_code' => 200,
            'user' => $user,
        ], 200);
        }else{
             return response()->json([
            'status' => true,
            'status_code' => 400,
            'user' => $user,
        ], 200);
        }
     });
    
    



    // View all items in cart
    Route::post('/cart', [CartApiController::class, 'index']);

    // Add item to cart
    Route::post('/cart/add', [CartApiController::class, 'addToCart']);

    // Update quantity or variant of a cart item
    // Route::put('/cart/update/{cart_item_id}', [CartApiController::class, 'updateCart']);

    // Remove an item from the cart
    Route::post('/cart/remove', [CartApiController::class, 'removeFromCart']);


    Route::post('/addresses', [addressApiController::class, 'index']);
    Route::post('/addresses/store', [addressApiController::class, 'store']);
    Route::post('/addresses/show', [addressApiController::class, 'show']);
    Route::post('/addresses/update', [addressApiController::class, 'update']);
    Route::delete('/addresses/{id}', [addressApiController::class, 'destroy']);


    // customizations-------------------------------------------------------- 
    Route::post('customization/store',[customizationApiController::class,'store']);
    
    
    
// });
