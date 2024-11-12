<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Jobs\SendMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CheckTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check tasks and send email notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all(); // Get all users

        foreach ($users as $user) {
            // Get tasks created today
            $tasks = $user->tasks()->whereDate('created_at', today())->pluck('Task_name')->toArray();

            if (!empty($tasks)) {
                $subject = 'Your pending Tasks: ' . implode(', ', $tasks);

                // Update the status of the tasks to pending
                foreach ($tasks as $taskName) {
                    $task = $user->tasks()->where('Task_name', $taskName)->first();
                    if ($task) {
                        $task->update([
                            'Task_name' => $task->Task_name,
                            'Description' => $task->Description,
                            'Due_time' => $task->Due_time,
                            'User_id' => $task->User_id,
                            'Status' => 'pending',
                        ]);
                    }
                }

                // Clear the cache for the specific user
                Cache::forget('tasks_' . $user->id);

                // Prepare the data for email dispatch
                $dispatchData = [
                    'mail_to' => $user->email,
                    'subject' => $subject,
                    'message' => "Hello {$user->name},\n\nHere are your pending tasks for today: " . implode(', ', $tasks),
                ];

                // Dispatch the email job
                SendMail::dispatch($dispatchData);
            }
        }

        Log::info('Emails dispatched successfully.');
    }
}
