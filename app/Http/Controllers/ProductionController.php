<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
     public function updateStatus(Request $request, $id)
    {
         $request->validate([
        'status' => 'required|in:pending,ready_to_dispatch'
    ]);

    $task->status = $request->status;
    $task->save();

    return back()->with('success', "Task status updated to {$request->status}");

    return view('admin.home', compact('tasks'));
    }
}
