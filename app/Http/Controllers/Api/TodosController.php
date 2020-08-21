<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $todo = Todo::create($this->validateTodo($request));
        $todo->refresh(); // ::create misses database default
        return $todo;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $todo->update($this->validateTodo($request));
        return $todo;
    }

    public function updateMultiple(Request $request)
    {
        $this->validateMultiple($request);
        $ids = $request->input('ids');
        $completed = $request->input('completed');
        $todos = Todo::whereIn('id', $ids)->where('completed', '!=', $completed)->update(['completed' => $completed]);
        return response('Success', 200)
                    ->header('Content-Type', 'text/plain');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response('Success', 200)
                    ->header('Content-Type', 'text/plain');
    }

    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('ids');
        Todo::whereIn('id', $ids)->delete();
        return response('Success', 200)
                    ->header('Content-Type', 'text/plain');
    }

    protected function validateTodo($request)
    {
        if ($request->isMethod('post')) {
            return $request->validate([
                'description' => ['required', 'max:25'],
                'user_id' => 'required',
            ]);
        } else {
            return $request->validate([
                'description' => 'max:25',
                'completed' => 'boolean',
            ]);
        }
    }

    protected function validateMultiple($request)
    {
        return $request->validate([
            'ids' => 'required',
            'completed' => ['required', 'boolean'],
        ]);
    }
}
