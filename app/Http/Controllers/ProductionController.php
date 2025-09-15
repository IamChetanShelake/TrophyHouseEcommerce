<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductionTask;
use App\Http\Controllers\Controller;

class ProductionController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,ready_to_dispatch'
        ]);

        $task = ProductionTask::findOrFail($id);
        //  return $task;
        $task->status = $request->status;
        $task->save();


        //orders status
        $task->payment->delivery_status = 'ready_to_pickup';
        $task->payment->save();

        //payment item status
        $productitem = $task->paymentItem;
        $productitem->delivery_status = $request->status;
        $productitem->save();

        return back()->with('success', "Task status updated to {$request->status}");

        return view('admin.home', compact('tasks'));
    }
}
