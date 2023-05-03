<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Vendor\VendorAuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MenuTypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\Vendor\FoodController as VendorFoodController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FoodCartController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ElectricalServiceController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\User\BookingsController as BookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Vendor\ShopController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BasicdetailController;
use Illuminate\Http\Request;
use App\Http\Controllers\ShopdetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JobsCompletedController;
use App\Notifications\OrderPlacedNotification;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::get('test-mail', function (){
//     Notification::route('mail', 'princezonik@gmail.com')->notify(new OrderPlacedNotification());
//     return 'Sent';
// });

// Route::get('getVendors', [AdminController::class, 'AllVendors']);
// Route::get('getUsers', [AdminController::class, 'allUsers']);
// Route::get('vendorCount', [AdminController::class, 'getVendorCount']);
// Route::get('userCount', [AdminController::class, 'getUserCount']);
// Route::get('jobs', [JobsCompletedController::class, 'complete']);
// Route::get('basic/{id}', [BasicdetailController::class, 'getVendorBasicDetail']);
// Route::patch('type', [VendorAuthController::class, 'storeVendorType']);
// Route::get('getType/{id}', [AdminController::class, 'getType']);

// Route::post('uploads', [ImageController::class, 'upload']);

// Route::get('service-items', [ItemController::class, 'index']);
// Route::get('service-items/store', [ItemController::class, 'store']);
// Route::get('service-items/update', [ItemController::class, 'update']);
// Route::get('service-items/delete', [ItemController::class, 'delete']);



Route::group(['prefix' => 'vendor'], function(){

    Route::post('login', [VendorAuthController::class, 'login'])->name('vendorLogin');
    Route::post('register', [VendorAuthController::class, 'register']);

    Route::group(['middleware' => ['auth:vendor']], function(){

        Route::put('store-service', [VendorAuthController::class, 'storeVendorType']);
        
        Route::get('authenticated-user', [VendorAuthController::class, 'getAuthVendor']);
        Route::put('basic-detail/update', [VendorAuthController::class, 'update']);
        Route::post('logout', [VendorAuthController::class, 'logout']);
        Route::put('update-password', [VendorAuthController::class, 'updatePassword']);
        Route::put('verify-otp', [VendorAuthController::class, 'verifyOTP']);
        Route::put('resend-otp', [VendorAuthController::class, 'resendOTP']);

        //SHOP ROUTES
        Route::post('create-shop', [ShopController::class, 'createShop']);
        Route::patch('shop/update/{id}', [ShopController::class, 'update']);
        Route::get('shop/show/{id}', [ShopdetailController::class, 'show']);
        Route::get('shop/{id}', [ShopController::class, 'show']);
        Route::delete('shop/delete/{id}', [ShopController::class, 'destroy']);
        
        //REVIEWS
        // Route::post('reviews/store', [ReviewController::class, 'store']);
        
        
        Route::get('find-nearest-restaurants/{latitude}/{longitude}/{radius}', [RestaurantController::class, 'findNearestRestaurants']);
        Route::post('create-restaurant/{id}', [RestaurantController::class, 'store']);
        Route::post('restaurant-image-upload', [RestaurantController::class, 'restaurantImageUpload']);
    
        Route::get('technical-services', [ElectricalServiceController::class, 'index']);


        //CATEGORY ROUTES
        Route::get('categories', [CategoryController::class, 'index']);
        Route::post('categories/create', [CategoryController::class, 'store']);
        Route::put('categories/update/{id}', [CategoryController::class, 'update']);
        Route::put('categories/show/{id}', [CategoryController::class, 'show']);
        Route::get('categories/categories-in-shop/{id}', [CategoryController::class, 'categoryInShop']);
        Route::get('category/{id}', [CategoryController::class, 'show']);
        Route::delete('category/delete/{id}', [CategoryController::class, 'delete']);


        //PRODUCTS ROUTE
        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/show/{id}', [ProductController::class, 'show']);
        Route::post('products/store', [ProductController::class, 'store']);
        Route::put('products/update/{id}', [ProductController::class, 'update']);
        Route::delete("products/delete/{id}", [ProductController::class, 'destroy']);
        Route::get('products/show/{id}', [ProductController::class, 'show']);
        Route::get('products/products-of-shop/{shop_id}', [ProductController::class, 'productsOfShop']);
        Route::get('products/products-in-category/{category_id}', [ProductController::class, 'productsinCategory']);
        Route::delete('products/delete/{id}', [ProductController::class, 'destroy']);



        //CheckoutStatusUpdate
        Route::put('order/order-update/{checkoutId}', [CheckoutController::class, 'updateOrder']);
        //CheckoutCanceled
        Route::put('order/show/{id}', [CheckoutController::class, 'show']);


        // Bookings
        Route::put('bookings/accept/{id}', [BookingsController::class, 'acceptBooking']);
    }); 
    
});


//CUSTOMER USER ROUTES
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => ['auth:api']], function(){


    //USER ROUTES
    Route::get('user', [AuthController::class, 'user']); //gets the current logged in user
    Route::put('users/update-info', [AuthController::class, 'updateInfo']); //updates user information
    Route::put('users/update-password', [AuthController::class, 'updatePassword']); //updates user password
    Route::apiResource('users', UserController::class); //lists all registered user
    Route::get('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail']);
    Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');


    
    Route::post('forgot-password', [PasswordResetController::class, 'forgotPassword']);
    Route::post('reset-password', [PasswordResetController::class, 'resetPassword']);

    Route::post('logout', [AuthController::class, 'logout']);
    // Route::apiResource('permissions', PermissionController::class);
    // Route::apiResource('roles', RoleController::class);


    //User Address ROUTES
    Route::get('myaddress', [AddressController::class, 'myAddress']); //List the address saved by specific user for delivery
    Route::get('addressbyuser/{id}', [AddressController::class, 'addressByUser']); 
    Route::post('addaddress', [AddressController::class, 'addAddress']); //User adds an address manually
    Route::delete('removeaddress/{id}', [AddressController::class, 'removeAddress']);     //Removes Address
    

   
    Route::get('food', [FoodController::class, 'getFoods']); //Get
    Route::get('foodofrestaurant/{id}', [FoodController::class, 'foodOfRestaurant']);  //List the foods available in a specific restaurant
    Route::get('foodbycategory/{id}',[FoodController::class,'foodByCategory']);  //List the foods available in a specific category

    Route::get('restaurants/around-you/{longitude}/{latitude}/radius=400', [RestaurantController::class, 'findNearestRestaurants']);
 
  
    Route::get('offers', [VendorController::class, 'offers']);

    //Carts
    Route::get('cart/my-cart', [CartController::class, 'myCart']);   //List the cart issued by specific user
    Route::post('cart/add-to-cart/{id}', [CartController::class, 'addToCart']);     //Add item to the cart issued by specific user
    Route::post('cart/reduce-from-cart/{id}', [CartController::class, 'decreaseAQuantity']);     //Remove a quantity of a specific item issued by specific user from the cart
    Route::delete('cart/delete-from-cart/{id}', [CartController::class, 'deleteAnItem']);     //Delete a specific item issued by specific user from the cart

    //CHECKOUTS
    Route::post('checkout', [CheckoutController::class, 'store']);
    Route::get('checkout/show/{id}', [CheckoutController::class, 'show']);
    
    //PRODUCTS ROUTE
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/products-of-shop/{shop_id}', [ProductController::class, 'productsOfShop']);
    Route::get('products/products-in-category/{category_id}', [ProductController::class, 'productsinCategory']);


    //Orders
    
    Route::get('order/my-order', [OrderController::class, 'myOrder']);     //List the order issued by specific user
    Route::post('order/store', [OrderController::class,'store']);     //Add item to the Order issued by specific user
    Route::post('order/update/status', [OrderController::class,'updateStatus']);     //Add item to the Order issued by specific user
    Route::get('order/order-by-user/{id}', [OrderController::class,'orderByUser']);     //Add item to the Order issued by specific user
    Route::delete('order/cancel/{id}', [CheckoutController::class, 'cancelOrder']);     //Cancel Specific Order issued by specific user

    //PendingCheckouts
    Route::get('orders/pending', [CheckoutController::class, 'getUserPendingOrders']);
    //ActiveOrders
    Route::get('orders/active', [CheckoutController::class, 'getUserActiveOrders']);
    Route::get('orders/completed', [CheckoutController::class, 'getUserCompletedOrders']);
    //CanOrders
    Route::get('orders/rejected', [CheckoutController::class, 'getUserRejectedOrders']);
    
    //UserCancelOrder
    Route::delete('order/cancel/{id}', [CheckoutController::class, 'cancelOrder']);     //Cancel Specific Order issued by specific user
    
   
    //Services Routes
    Route::apiResource('services', ServiceController::class);
   
   
    Route::get('rated', [ShopController::class, 'topRatedShops']);
    Route::get('shops', [ShopController::class, 'getShops']);
    Route::get('business/{id}', [BusinessController::class, 'show']);
       
 

    Route::get('grocery-shopping/categories', [ServiceController::class, 'getGroceryShopping']);
    Route::post('upload', [ImageController::class, 'upload']);
    Route::get('electrical', [ElectricalServiceController::class, 'electrical']);

    Route::post('bookings/create', [BookingsController::class, 'store']);

    
    //FAVOURITE
    Route::get('myfavouriterestaurant', [FavouritesController::class, 'myFavouriteRestaurant']);     //List the favourite restaurant and food item by specific user

    Route::get('myfavouritefood', [FavouriteController::class, 'myFavouriteFood']);     //List the favourite restaurant and food item by specific user

    Route::post('favouritefood/{id}', [FavouriteController::class, 'food']); //List the favourite restaurant and food item by specific user

    Route::post('favouriterestaurant/{id}', [FavouriteController::class, 'restaurant']);  //List the favourite restaurant and food item by specific user

    Route::delete('deletefavouritefood/{id}', [FavouriteController::class, 'deleteFavouriteFood']);  //Delete a specific item issued by specific user from the cart

    Route::delete('deletefavouriterestaurant/{id}', [FavouriteController::class, 'deleteFavouriteRestaurant']); //Delete a specific item issued by specific user from the cart


    // BOOKINGS ROUTE
    Route::get('bookings', [BookingsController::class, 'index']);

    Route::get('bookings/user/{id}',[BookingsController::class, 'BookingForParticularUser']); //bookings for a particular user
    Route::get("bookings/single-bookings/{id}",[BookingsController::class,'getBooking']);
    Route::post("bookings/{booking_id}/set-status/{status_id}","BookingsController@setBookingStatusId");


    Route::get("bookings/artisan/{id}/{pagination?}","BookingsController@BookingForParticularArtisan");
    Route::get("bookings/pending-artisan/{artisan_id}/get-status/{status}","BookingsController@getPendingBookingForArtisan");
    Route::get("bookings/pending-artisan/{user_id}/get-status/{status}","BookingsController@getPendingBookingForUser");
    Route::get("bookings/get-approved/{customers_id}","BookingsController@getAllwhereUsersIdEqualsCustomersIdAndIsApproved");

    
    // Route::apiResource('menus', MenuController::class);
    // Route::apiResource('menu-types', MenuTypeController::class);
    
   
    //Review
    Route::get('reviews', [ReviewController::class, 'reviews']);
    Route::post("reviews/store",[ReviewController::class, "store"]);
    Route::get("reviews/shop/{id}",[ReviewController::class, 'getReviewsForShopId']);
    // Route::get("reviews/all-reviews",[ReviewController::class, 'getReviews']);
    Route::get("reviews/vendor/{id}", [ReviewController::class, 'getReviewsForVendorId']);
    
    
    

    Route::get('offers', [VendorController::class, 'offers']);



    //TECHNICAL SERVICE ROUTES
    Route::get('technical-services', [ElectricalServiceController::class, 'index']);

    Route::get('items-of-service', [ServiceItemController::class, 'itemsOfService']);
    Route::post('items/store', [ServiceItemController::class, 'store']);
    Route::put('items/update', [ServiceItemController::class, 'update']);
    Route::delete('items/delete', [ServiceItemController::class, 'destroy']);
});


// //GENERAL ROUTES
// Route::group(['prefix' => 'general', 'middleware' => ['auth:api']], function(){

//     Route::get('menus', [HomeController::class, 'menus']);
//     Route::get('menus/{id}', [HomeController::class, 'showMenu']);
//     Route::get('menu-types', [HomeController::class, 'menuTypes']);
//     Route::get('menu-types/{id}', [HomeController::class, 'showMenuType']);
//     Route::get('vendors', [HomeController::class, 'vendors']);
//     Route::get('vendors/{id}', [HomeController::class, 'showVendor']);

//     //Business Routes General
//     
//     Route::get('business/{id}', [BusinessController::class, 'showBusiness']);
//     Route::post('business/create', [BusinessController::class, 'store']);
//     Route::get('offers', [VendorController::class, 'offers']);


//     //BOOKINGS ROUTES GENERAL
//     Route::get('bookings', [BookingsController::class, 'index']);
//     Route::get('bookings/user/{id}',[BookingsController::class, 'BookingForParticularUser']); //bookings for a particular user
//     Route::get('bookings/vendor/{id}',[BookingsController::class, 'BookingForParticularVendor']); //bookings for a particular vendor
//     Route::get("bookings/single-bookings/{id}",[BookingsController::class,'getBooking']);
//     Route::post("bookings/{booking_id}/set-status/{status_id}", [BookingsController::class, 'setBookingStatusId']);
//     Route::get("bookings/pending-user/{user_id}/get-status/{status}", [BookingsController::class, 'getPendingBookingForUser']);
//     Route::get("bookings/pending-artisan/{artisan_id}/get-status/{status}",[ BookingsController::class, 'getPendingBookingForArtisan']);
//     Route::get("bookings/get-approved/{customers_id}",[BookingsController::class, 'getAllwhereUsersIdEqualsCustomersIdAndIsApproved']);


//    
//      //display admin profile
//     Route::post("/profilephoto/add","AdminAuthController@AddProfilePicture");
//     Route::post("/profile","AdminAuthController@getAuthadmin");

// });

//     
// });