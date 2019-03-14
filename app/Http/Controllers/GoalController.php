<?php

namespace App\Http\Controllers;

use App\Goal;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;

class GoalController extends Controller
{

    public function index()
    {
        $goal = Goal::orderBy('created_at', 'desc')->paginate(10);

        return response()->json($goals, 200);
    }

    public function show($id)
    {
        $goal = Goal::findOrFail($id);
        
        // Check for correct user
        if(Auth::user()->id !== $goal->user_id)
        {
            return response()->json('Unauthorized Access!', 400);
        }
        return response()->json($goal, 200);
    }

    public function create(Request $request)
    {
        // validate inputs
        $this->validateGoal($request);
        
        // Create Goal
        $goal = new Goal;
        $goal->title = $request->input('title');
        $goal->body = $request->input('description');
        $goal->body = $request->input('start');
        $goal->body = $request->input('finish');
        $goal->user_id = Auth::user()->id;
        $goal->save();

        // response
        $res['message'] = "{$goal->title} Created Successfully!";
		$res['goal'] = $goal;
		return response()->json($res, 201);
    }

    public function update(Request $request, $id)
    {
        // validate inputs
        $this->validateGoal($request);   

        // update goal
        $goal = Goal::findOrFail($id);
        $goal->title = $request->input('title');
        $goal->body = $request->input('description');
        $goal->body = $request->input('start');
        $goal->body = $request->input('finish');
        $goal->save(); 

        $res['message'] = "{$goal->title} Updated Successfully!";
		$res['goal'] = $goal;
		return response()->json($res, 201);
    }

    public function destroy(Request $request, $id)
    {
        $goal = Goal::findOrFail($id);
        if(Auth::user()->id !== $goal->user_id)
        {        
            return response()->json('Unauthorized Access!', 400);
        }

        $goal->delete();

        $res['message'] = "{$goal->title} Deleted Successfully!";
        return response()->json($res, 201);

    }
        
    public function validateGoal(Request $request){
		$rules = [
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:3', 'max:255'],
            'start' => ['required', 'date'],
            'finish' => ['required', 'date']
		];
		$this->validate($request, $rules);
    }
}
