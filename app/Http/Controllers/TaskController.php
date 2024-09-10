<?php

namespace App\Http\Controllers;

use App\Models\task;
use App\Http\Requests\StoretaskRequest;
use App\Http\Requests\UpdatetaskRequest;
use App\Models\User;
use Exception;
use Illuminate\Console\View\Components\Task as ComponentsTask;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'username' => 'required|string|unique:users,username',
                'task' => 'required|array|min:1',
                'task.*.category_id' => 'required|integer|exists:categories,id',
                'task.*.description' => 'required|string',
            ]);
            try {
                $newUser = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'username' => $validated['username'],
                ]);
            } catch (QueryException $e) {
                return response()->json(['error' => 'Failed to make User'], 500);
            }
            $taskData = array_map(function ($task) use ($newUser) {
                return array_merge($task, [
                    'created_by' => $newUser->id
                ]);
            }, $validated['task']);
            $newTask = $newUser->task()->createMany($taskData);
            return response()->json(['newuser' => $newUser, 'newtask' => $newTask], 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'validation error', 'messages' => $e->errors()], 422);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoretaskRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetaskRequest $request, task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(task $task, Request $request)
    {
        try {
            try {
                $user = DB::table('users')->where('username', $request->username)->where('email', $request->email)->get();
                if (!$user[0]->id) {
                    throw new Exception("User Not Found");
                }
            } catch (Exception $e) {
                return response()->json(['error' => 'User Not Found'], 404);
            }
            $deletedtask = task::find($task->id);
            $deletedtask->deleted_by = $user[0]->id;
            $deletedtask->save();
            $deletedtask->delete();
            return response()->json([$deletedtask], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Not Found'], 404);
        }
    }
}
