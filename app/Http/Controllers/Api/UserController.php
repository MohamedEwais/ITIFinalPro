<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

     function __construct(){
        $this->middleware('auth:sanctum')->only("destroy","update");
    }
  

    public function index() {
        // Retrieve and return a list of users
        $users = User::all();
        // return response()->json($users, 200);
        return UserResource::collection($users, 200);
    }

    public function show($id) {
        // Retrieve and return a specific user by ID
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }

    // public function store(Request $request) {
    //     // Validate and create a new user
    //     $validator = Validator::make($request->all() ,[
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|min:6',
    //         'role' => 'required|string',
    //     ],[
    //         'name.required' => 'برجاء ادخال الاسم',
    //         'email.required' => 'برجاء كتابه اﻻيميل',
    //         'email.email' => 'هذا اﻻيميل غير صحيح',
    //         'email.unique' => 'هذا اﻻيميل مستحدم من قبل',
    //         'password.required'=> 'برجاء كتابة كلمة السر',
    //         'password.min'=> ' كلمة السر ﻻ يجب ان تقل عن ٦ احرف او ارقام',
    //         'role.required' => 'هذا الحقل مطلوب',
    //    ]);
    // if ($validator-> fails()){
    //     return response($validator->errors()->all() , 422);
    // }

    //     $user = User::create($request->all());

    //     return new UserResource($user);
    // }

    public function update(Request $request,User $user, $id) {
        // Validate and update a specific user by ID
        $validator = Validator::make($request->all() ,[
            'name' => 'required|string|max:255',
            'password' => 'required|min:6',
            'role' => 'required|string',
            
        ],[
            'name.required' => 'برجاء ادخال الاسم',
            'password.required'=> 'برجاء كتابة كلمة السر',
            'password.min'=> ' كلمة السر ﻻ يجب ان تقل عن ٦ احرف او ارقام',
            'role.required' => 'هذا الحقل مطلوب',
        ]);
    if ($validator-> fails()){
        return response($validator->errors()->all() , 422);
    }

        $user = User::findOrFail($id);
        $user->update($request->all());

        return new UserResource($user);
    }

    public function destroy($id) {
        // Delete a specific user by ID
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([' تم مسح المستحدم بنجاح'], 200);
    }
}
