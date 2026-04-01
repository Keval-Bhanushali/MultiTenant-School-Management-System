<?php

namespace App\Console\Commands;

use App\Models\RecurringTask;
use Illuminate\Console\Command;

class RunRecurringTasks extends Command
{
    protected $signature = 'auracampus:run-recurring-tasks';

    protected $description = 'Run active recurring tasks such as attendance reminders and monthly fee invoice jobs';

    public function handle(): int
    {
        $now = now();

        $tasks = RecurringTask::query()
            ->where('is_active', true)
            ->where(function ($query) use ($now) {
                $query->whereNull('next_run_at')->orWhere('next_run_at', '<=', $now);
            })
            ->get();

        foreach ($tasks as $task) {
            $this->line(sprintf('Running task: %s (%s)', $task->task_name, $task->frequency));

            // Stub only: replace with queue dispatchers for attendance reminders and fee invoice generation.
            $task->update([
                'last_ran_at' => $now,
                'next_run_at' => $this->calculateNextRun($task->frequency, $now),
            ]);
        }

        $this->info(sprintf('Processed %d recurring task(s).', $tasks->count()));

        return self::SUCCESS;
    }

    private function calculateNextRun(string $frequency, $baseTime)
    {
        return match ($frequency) {
            'hourly' => $baseTime->copy()->addHour(),
            'weekly' => $baseTime->copy()->addWeek(),
            'monthly' => $baseTime->copy()->addMonth(),
            default => $baseTime->copy()->addDay(),
        };
    }
}
