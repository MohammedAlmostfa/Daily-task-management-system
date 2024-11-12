<?php

namespace App\Service;

use Exception;
use App\Models\Task;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use phpDocumentor\Reflection\Types\Null_;

class TaskService
{
    /**
     * Get all tasks for the authenticated user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTasks()
    {
        $userId = Auth::id(); // Get the authenticated user's ID
        // Retrieve all tasks for the authenticated user with caching
        $tasks = Cache::remember("tasks_$userId", 60, function () {
            return Auth::user()->tasks()->byTask(null)->get(); // Ensure to call get() at the end of the query
        });

        return $tasks;
    }

    /**
     * Get all finished tasks for the authenticated user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFinishedTasks()
    {
        $userId = Auth::id(); // Get the authenticated user's ID
        // Retrieve all finished tasks for the authenticated user with caching
        $finishedTasks = Cache::remember("finishedTasks_$userId", 60, function () {
            return Auth::user()->tasks()->byTask('finished')->get(); // Ensure to call get() at the end of the query
        });

        return $finishedTasks;
    }
    /**
    * Get all Pending tasks for the authenticated user.
    *
    * @return \Illuminate\Database\Eloquent\Collection
    */

    public function getPendingTasks()
    {
        $userId = Auth::id(); // Get the authenticated user's ID
        // Retrieve all Pending tasks for the authenticated user with caching
        $PendingTasks = Cache::remember("PendingTasks_$userId", 60, function () {
            return Auth::user()->tasks()->byTask('pending')->get();
        });
        return $PendingTasks;

    }

    /**
     * Create a new task.
     *
     * @param array $data
     * @return array
     */
    public function createTask($data)
    {
        try {
            // Create a new task
            $task = Task::create([
                'Task_name' => $data['Task_name'],
                'Description' => $data['Description'],
                'Due_time' => $data['Due_time'],
                'User_id' => Auth::user()->id,
            ]);

            // Clear tasks cache after creation
            Cache::forget('tasks_' . Auth::id());
            Cache::forget('finishedTasks_' . Auth::id());
            Cache::forget('PendingTasks_' . Auth::id());

            return ['success' => 'Task created successfully'];
        } catch (Exception $e) {
            // Log the error in case of failure
            Log::error('Error creating task: ' . $e->getMessage());
            return ['error' => 'Failed to create task ' .$e->getMessage()];
        }
    }

    /**
     * Delete a task.
     *
     * @param int $id
     * @return array
     */
    public function deleteTask($id)
    {
        try {
            // Find the task and delete it
            $task = Task::find($id);
            $task->delete();

            // Clear tasks cache after deletion
            Cache::forget('tasks_' . Auth::id());
            return ['success' => 'Task deleted successfully'];
        } catch (Exception $e) {
            // Log the error in case of failure
            Log::error('Error deleting task: ' . $e->getMessage());
            return ['error' => 'Failed to delete task'];
        }
    }

    /**
 * Update the task with the specified id.
 *
 * @param array $data
 * @param int $id
 * @return array
 */
    public function updateTask($data, $id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->update([
                'Task_name' => $task->Task_name,
                'Description' => $task->Description,
                'Due_time' => $data['Due_time'] ?? $task->Due_time,
                'User_id' => $task->User_id,
                'Status' => $data['Status'] ?? null,
                'Result' => $data['result'] ?? null,
            ]);

            Cache::forget('tasks_' . Auth::id());
            Cache::forget('finishedTasks_' . Auth::id());
            Cache::forget('PendingTasks_' . Auth::id());

            if (!empty($data['Due_time'])) {
                return ['success' => 'Task active successfully'];
            }
            return ['success' => 'Task finished successfully'];
        } catch (Exception $e) {
            Log::error('Error finishing task: ' . $e->getMessage());
            return ['error' => 'Failed to finish task'];
        }
    }


    public function deleteAllTasks($status)
    {
        try {
            $userId = Auth::id(); // Get the authenticated user's ID
            if($status=='null') {
                // Retrieve all tasks for the authenticated user with the given status
                $tasks = Auth::user()->tasks()->byTask(null)->get();
            } else {
                $tasks = Auth::user()->tasks()->byTask($status)->get();
            }
            // Loop through each task and delete it
            foreach ($tasks as $task) {
                $task->delete();
            }

            // Clear the cache for tasks
            Cache::forget('tasks_' . $userId);
            Cache::forget('finishedTasks_' . $userId);
            Cache::forget('PendingTasks_' . $userId);

            return ['success' => 'Tasks deleted successfully'];
        } catch (Exception $e) {
            Log::error('Error deleting task: ' . $e->getMessage());
            return ['error' => 'Failed to delete tasks'];
        }
    }

}
