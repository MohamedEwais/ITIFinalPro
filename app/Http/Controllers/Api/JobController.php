<?php

namespace App\Http\Controllers\Api;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\JobResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class JobController extends Controller
{
    function __construct(){
        // $user = Auth::user();
        // dd($user->role);
    
        $this->middleware("auth:sanctum")->only("store","update","destroy");
    }

    
    public function index() {
        // Retrieve and return a list of jobs
        $jobs = Job::all();
        // return response()->json($jobs, 200);
        return JobResource::collection($jobs, 200);
    }

    public function show($id) {
        // Retrieve and return a specific job by ID
        $job = Job::findOrFail($id);
        return response()->json($job, 200);
    }

    public function store(Request $request) {
        $user = Auth::user();
        // dd($user->role);

        if ($user && $user->role == "employer") {
            $request->merge(['user_id' => $user->id]); // Set user_id in the request
   
            $validator = Validator::make($request->all() ,[
                'proTitle' => 'required|string|max:255',
                'description' => 'required',
                'status' => 'string',
                'skills' => 'required|string',
                'budget' => 'required|integer', 
                'duration' => 'required|integer',  
                'user_id' => 'integer',
                'location_id' => 'required|integer',
            ], [
                'proTitle.required' => 'برجاء ادخال الاسم',
                'description.required' => 'برجاء كتابه الوصف',
                'status'=> 'هذا الحقل مطلوب',
                'skills.required'=> 'برجاء اختيار المهارة ',
                'budget.required'=> 'برجاء كتابة المبلغ الذي تريد ان تدفعة ',
                'duration.required'=> 'رجاء كتابة المدة ',
                'user_id' => $user->id,
                'location_id.required' => 'اختار العنوان',
            ]);
        
            if ($validator->fails()) {
                return response($validator->errors()->all(), 422);
            }
        
            $job = Job::create($request->all());
            return new JobResource($job);
        } else {
            return  response()->json("انت لا تمتلك الصلاحية ل أضافة مشروع", 400);
        }
      
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all() ,[
            // $this->validate($request, [
                'proTitle' => 'required|string|max:255',
                'description' => 'required',
                'status' => 'required|string',
                'skills' => 'required|string', // Update the validation rule to match 'status'
                'budget' => 'required|integer', 
                'duration' => 'required|integer',  
                'user_id' => 'required|integer',
                'location_id' => 'required|integer',
            ]
            ,[
                'proTitle.required' => 'برجاء ادخال الاسم',
                'description.required' => 'برجاء كتابه الوصف',
                'status.required'=> 'هذا الحقل مطلوب',
                'skills.required'=> 'برجاء اختيار المهارة ',
                'budget.required'=> 'برجاء كتابة المبلغ الذي تريد ان تدفعة ',
                'duration.required'=> 'رجاء كتابة المدة ',
                'user_id.required' => 'هذا الحقل مطلوب',
                'location_id.required' => 'اختار العنوان',
            ]);
    
        if ($validator-> fails()){
            return response($validator->errors()->all() , 422);
        }

        $job = Job::findOrFail($id);
        $job->update($request->all());
        
        return new JobResource($job);
    }


    public function destroy($id) {
        // Delete a specific job by ID
        $job = Job::findOrFail($id);
        $job->delete();

        return response()->json(['تم المسح بنجاح!'], 200);
    }
}
