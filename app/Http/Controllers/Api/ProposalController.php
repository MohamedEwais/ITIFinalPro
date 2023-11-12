<?php


namespace App\Http\Controllers\Api;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    function __construct(){
        $this->middleware("auth:sanctum")->only("store","update","destroy");
    }

    public function index()
    {
        // Retrieve a list of proposals
        $proposals = Proposal::all();
        return response()->json($proposals);
    }

    public function show($id)
    {
        // Retrieve a specific proposal by its ID
        $proposal = Proposal::find($id);

        if (!$proposal) {
            return response()->json(['message' => 'Proposal not found'], 404);
        }

        return response()->json($proposal);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->merge(['user_id' => $user->id]);
        // Create a new proposal
        $validator = Validator::make($request->all() ,
        [
            'img' => 'required',
            'budget' => 'required|numeric',
            'comment' => 'required',
            'user_id' => 'integer',
            'job_id' => 'required|exists:jobs,id',
        ],[
            'img.required' => 'برجاء ارفاق صورة',
            'budget.required' => 'برجاء كتابه الميزانية',
            'comment.required'=> 'هذا الحقل مطلوب',
            'user_id' => $user->id,
            'job_id' => 'required|integer',
        ]);


        if ($validator-> fails()){
            return response($validator->errors()->all() , 422);
        }
        $proposal = Proposal::create($request->all());
        return response()->json($proposal, 201);

    }

    public function update(Request $request, $id)
    {
        // Update an existing proposal
        $proposal = Proposal::find($id);

        if (!$proposal) {
            return response()->json(['message' => 'Proposal not found'], 404);
        }
        $data = Validator::make($request->all() ,
        [
            'img' => 'required',
            'budget' => 'required|numeric',
            'comment' => 'required',
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:jobs,id',
        ],[
            'img.required' => 'برجاء ارفاق صورة',
            'budget.required' => 'برجاء كتابه الميزانية',
            'comment.required'=> 'هذا الحقل مطلوب',
            'user_id' => 'required|integer',
            'job_id' => 'required|integer',
        ]);
        if ($data-> fails()){
            return response($data->errors()->all() , 422);
        }

        $proposal->update($request->all());
        return response()->json($proposal);
    }

    public function destroy($id)
    {
        // Delete a proposal
        $proposal = Proposal::find($id);

        if (!$proposal) {
            return response()->json(['message' => 'Proposal not found'], 404);
        }

        $proposal->delete();
        return response()->json(['message' => 'Proposal deleted']);
    }
}
