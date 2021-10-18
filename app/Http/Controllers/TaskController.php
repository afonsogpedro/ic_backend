<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Auth::user()->tasks;
        return response()->json(["status" => "success", "error" => false, "count" => count($tasks), "data" => $tasks],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|min:3|unique:tasks,name",
            "description" => "required"
        ]);

        if($validator->fails()) {
            return $this->validationErrors($validator->errors());
        }

        try {
            $task = Task::create([
                "name" => $request->name,
                "description" => $request->description,
                "user_id" => Auth::user()->id
            ]);
            return response()->json(["status" => "success", "error" => false, "message" => "Success! task created."], 201);
        }
        catch(Exception $exception) {
            return response()->json(["status" => "failed", "error" => $exception->getMessage()], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Auth::user()->tasks->find($id);

        if($task) {
            return response()->json(["status" => "success", "error" => false, "data" => $task], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed! no task found."], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Auth::user()->tasks->find($id);

        if($task) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required'
            ]);

            if($validator->fails()) {
                return $this->validationErrors($validator->errors());
            }

            $task['name'] = $request->name;
            $task['description'] = $request->description;

            // if has active
            if($request->active) {
                $task['active'] = $request->active;
            }

            // if has completed
            if($request->completed) {
                $task['completed'] = $request->completed;
            }

            $task->save();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! task updated."], 201);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no task found."], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Auth::user()->tasks->find($id);
        if($task) {
            $task->delete();
            return response()->json(["status" => "success", "error" => false, "message" => "Success! task deleted."], 200);
        }
        return response()->json(["status" => "failed", "error" => true, "message" => "Failed no task found."], 404);
    }
}
