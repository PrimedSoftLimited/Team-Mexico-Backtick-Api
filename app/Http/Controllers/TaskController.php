<?php

namespace App\Http\Controllers;

use App\User;
use App\Task;
use App\Goal;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {
        $task = Task::orderBy('created_at', 'desc')->paginate(10);
        return response()->json($task);
    }

    public function showAllTasks($goal_id)
    {   
        $goalCheck = Goal::where('id', $goal_id)->exists();
        $goal = Goal::findOrFail($goal_id);

        if (Auth::user()->id == $goal->owner_id){

            if ($goalCheck){

                $task = Task::where('goal_id', $goal_id)->first();

                if ($task){

                    return response()->json($task, 200);
                
                } return response()->json('Task Does not Exist', 401);

            } return response()->json('Goal Does not Exist', 401);

        } return response()->json('Unauthorized Acess!', 401);
    }

    public function showOneTask($goal_id, $id)
    {   
        $goal = Goal::all()->first();
        $goalCheck = Goal::where('id', $goal_id)->exists();
        $taskCheck = Task::where('id', $id)->exists();

        if (Auth::user()->id == $goal->owner_id){

            if ($goalCheck && $taskCheck){
            
                $task = Task::where('id', $id)->where('goal_id', $goal_id)->first();
            
                    if ($task){
            
                return response()->json($task, 200);

            }return response()->json('Unauthorized Access!', 400);
            
        }return response()->json('Goal or Task Does not exist!', 400);
        
    }return response()->json('Unauthorized Access!', 400);
    
}

    public function create(Request $request, $id)
    {
        // validate inputs
        $this->validateTask($request);
        
        $goalCheck = Goal::where($id == 'id')->exists();

        $goal = Goal::where('id', $goal_id)->first();

        if($goalCheck && Auth::user()->id == $goal->owner_id)
            {
                $task = new Task;
                $task->description = $request->input('description');
                $task->begin = $request->input('begin');
                $task->due = $request->input('due');
                $task->goal_id = $goal_id;
                $task->save();

                $res['message'] = "{$task->description} Created Successfully!";
		        $res['goal'] = $task;
		        return response()->json($res, 201);
            } 
            return response()->json('Goal does not exist', 401);
    }

    public function update(Request $request, $id, $goal_id)
    {

        $goal = Goal::all()->first();
        $goalCheck = Goal::where('id', $goal_id)->exists();
        $taskCheck = Task::where('id', $id)->exists();
        $task = Task::where('id', $id)->where('goal_id', $goal_id)->first();

        if (Auth::user()->id == $goal->owner_id){
         
            if ($goalCheck && $taskCheck){
                
                if ($task){
            
                    $this->validateTask($request);

                    $task->description = $request->input('description');
                    $task->begin = $request->input('begin');
                    $task->due = $request->input('due');
                    $task->goal_id = $goal_id;
                    $task->save();

                    $res['message'] = "{$task->description} Updated Successfully!";
                    $res['goal'] = $task;
                    return response()->json($res, 201);

            }return response()->json('Unauthorized Access!', 400);

            }return response()->json('does not exist!', 400);
            
        }return response()->json('Unauthorized Access!', 400);
    }

    public function destroy(Request $request, $id, $goal_id)
    {
        $goal = Goal::all()->first();
        $goalCheck = Goal::where('id', $goal_id)->exists();
        $taskCheck = Task::where('id', $id)->exists();

        if (Auth::user()->id == $goal->owner_id){

            if ($goalCheck && $taskCheck){
            
                $task = Task::findOrFail($id)->where('goal_id', $goal_id)->first();
            
                    if ($task){

                        $task->delete();
            
                        $res['message'] = "Deleted Successfully!";
                        return response()->json($res, 201);

                }return response()->json('Unauthorized Access!', 400);
            
            }return response()->json('Goal or Task Does not exist!', 400);
    
        }return response()->json('Unauthorized Access!', 400);
    }
        
    public function validatetask(Request $request){

		$rules = [
            'description' => 'required|min:3|max:255',
            'begin' => 'required|date|before:due',
            'due' => 'required|date|after:begin',
		];
		$this->validate($request, $rules);
    }
}
