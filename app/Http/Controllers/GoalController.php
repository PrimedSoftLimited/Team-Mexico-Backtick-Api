<?php

namespace App\Http\Controllers;

use App\User;
use App\Goal;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{

    public function index()
    {
        $goal = Goal::orderBy('created_at', 'desc')->paginate(10);
        return response()->json($goal, 200);
    }

    public function showAllGoals()
    {   
        $goal = Auth::user()->goal;

        return response()->json($goal, 200);
    }

    public function showOneGoal($id)
    {   
        $goal = Goal::findOrFail($id);

        if(Auth::user()->id == $goal->owner_id)
            {
                    return response()->json($goal, 200);
            }
            return response()->json('Unauthorized Access!', 400);
    }

    public function create(Request $request)
    {
        // validate inputs
        $this->validateGoal($request);
        
        // Create Goal
        $goal = new Goal;
        $goal->title = $request->input('title');
        $goal->description = $request->input('description');
        $goal->start = $request->input('start');
        $goal->finish = $request->input('finish');
        $goal->owner_id = Auth::user()->id;
        $goal->save();

        // response
        $res['message'] = "{$goal->title} Created Successfully!";
		$res['goal'] = $goal;
		return response()->json($res, 201);
    }

    public function update(Request $request, $id)
    {
        $goal = Goal::findOrFail($id);

        if(Auth::user()->id == $goal->owner_id)
        {
            // validate inputs
            $this->validateGoal($request); 
            
            // update goal
            $goal->title = $request->input('title');
            $goal->description = $request->input('description');
            $goal->start = $request->input('start');
            $goal->finish = $request->input('finish');
            $goal->save(); 

            $res['message'] = "{$goal->title} Updated Successfully!";
            $res['goal'] = $goal;
            return response()->json($res, 201);

        }
        return response()->json('Unauthorized Access!', 400);

    }

    public function destroy(Request $request, $id)
    {
        $goal = Goal::findOrFail($id);
    
        if(Auth::user()->id == $goal->owner_id)
        {
            $goal->delete();

            $res['message'] = "{$goal->title} Deleted Successfully!";
            return response()->json($res, 201);
        }
        
        return response()->json('Unauthorized Access!', 400);    
    }
        
    public function validateGoal(Request $request){
		$rules = [
            'title' => 'required|min:3',
            'description' => 'required|min:3|max:255',
            'start' => 'required|date|before:finish',
            'finish' => 'required|date|after:start',
        ];
		$this->validate($request, $rules);
    }
}
