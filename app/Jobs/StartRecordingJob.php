<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Http\Middleware\QueuePriority;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class StartRecordingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sessionId;
    public $priority = 5; // Default priority

    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }


    public function handle()
    {
      
        $activateScript = 'venv\Scripts\activate.bat';
        $output = exec("\"$activateScript\" 2>&1", $output, $returnVar);

        $sessionId = $this->sessionId;
        $command = 'python';
        $arguments = [
            public_path('recording.py'),
            $sessionId,
            'start',
        ];

        // Create a new process instance
        $process = new Process([$command, ...$arguments]);

        // Run the process
        $process->run();

        // Check if the process was successful
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo "Python script output:\n" . $process->getOutput() . "\n";
    }

    // public function middleware()
    // {
    //     return [new QueuePriority]; // Lower priority for StartRecordingJob
    // }
}
