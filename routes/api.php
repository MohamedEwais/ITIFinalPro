<?php


use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FreelancerController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProposalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Route::group(['prefix' => 'freelancers'], function () {
//    Route::get('/', [FreelancerController::class, 'index']);
//    Route::get('/{id}', [FreelancerController::class, 'show']);
//    Route::post('/', [FreelancerController::class, 'store']);
//    Route::put('/{id}', [FreelancerController::class, 'update']);
//    Route::delete('/{id}', [FreelancerController::class, 'destroy']);
//});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    // Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

//Route::get("freelancer", [FreelancerController::class,'index']);
//Route::get("jobs", [JobController::class,'index']);
//Route::get("job/{id}", [JobController::class,'show']);
//Route::post("/job", [JobController::class, "store"]);




Route::get('/locations', [LocationController::class, 'index']);
Route::get('/locations/{id}', [LocationController::class, 'show']);
Route::post('/locations', [LocationController::class, 'store']);
Route::put('/locations/{id}', [LocationController::class, 'update']);
Route::delete('/locations/{id}', [LocationController::class, 'destroy']);


Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/{id}', [JobController::class, 'show']);
Route::post('/jobs', [JobController::class, 'store']);
Route::put('/jobs/{id}', [JobController::class, 'update']);
Route::delete('/jobs/{id}', [JobController::class, 'destroy']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
// Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// Route::apiResource('proposals', ProposalController::class);
// use App\Http\Controllers\Api\ProposalController;

// Route::get('/proposals', [ProposalController::class, 'index']);
// Route::get('/proposals/{id}', [ProposalController::class, 'show']);
// Route::post('/proposals', [ProposalController::class, 'store']);
// Route::put('/proposals/{id}', [ProposalController::class, 'update']);
// Route::delete('/proposals/{id}', [ProposalController::class, 'destroy']);

// //-------------------- sanctum-------------------------//
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
 
Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);
 
    $user = User::where('email', $request->email)->first();
 
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
 
    return $user->createToken($request->device_name)->plainTextToken;
});
// logout
Route::post("/logout",function(Request $request){
    $user =Auth::guard('sanctum')->user();
    $token=$user->currentAccessToken();
    $token->delete();
    return response("تم تسجيل الخروج",200);
});

Route::apiResource('proposals', ProposalController::class);