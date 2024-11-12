<?php

namespace App\Http\Controllers;

use App\Http\Requests\taskformrequestcreat;
use App\Http\Requests\taskformrequestupdate;
use App\Service\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the tasks.
     */
    public function index()
    {
        $tasks = $this->taskService->getAllTasks();
        return view('dashboard', compact('tasks'));
    }

    /**
     * Display a listing of the finished tasks.
     */
    public function getfinishedTask()
    {
        $tasks = $this->taskService->getfinishedTasks();
        return view('finishidTask', compact('tasks'));
    }
    /**
     * Display a listing of the Pending tasks.
     */

    public function getPendingTask()
    {
        $tasks = $this->taskService->getPendingTasks();
        return view('PendingTask', compact('tasks'));

    }
    /**
     * Store a newly created task.
     */
    public function store(taskformrequestcreat $request)
    {
        $vaildateddata = $request->validated();
        $result = $this->taskService->createTask($vaildateddata);
        return redirect()->route('dashboard')->with($result);
    }

    /**
     * Remove the specified task.
     */
    public function destroy($id)
    {
        $result = $this->taskService->deleteTask($id);
        return redirect()->route('dashboard')->with($result);
    }

    /**
     * Mark the specified task as finished.
     */
    public function update(taskformrequestupdate $Result, $id)
    {
        $vaildateddata = $Result->validated();
        $result = $this->taskService->updateTask($vaildateddata, $id);
        return redirect()->route('dashboard')->with($result);
    }
    public function delete($stuts)
    {
        $tasks = $this->taskService->deleteAllTasks($stuts);
        return redirect()->back()->with($tasks);

    }
}
