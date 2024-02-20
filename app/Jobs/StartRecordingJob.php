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
use Illuminate\Support\Facades\Log;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use App\Models\RecordingSession;
use Illuminate\Support\Facades\Auth;

class StartRecordingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sessionId;
    protected $bookingId;

    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }




    public function handle()
    {
        // Retrieve the recording session for the current user
        $recordingSession = RecordingSession::where('user_id', Auth::id())->first();

        // Check if the recording session exists and is in progress
        // if ($recordingSession) {
        //     Log::info("Recording is still in progress for session ID: . Retrying job.");

        //     // Since the recording is still in progress, we'll throw an exception to trigger a retry
        //     throw new \Exception("Recording is still in progress. Retrying job...");
        // } else {
            // If the recording session doesn't exist or is finished, we can start a new recording

            // Execute your script here to start the recording
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
            $process->setTimeout(7200);
            // Run the process
            $process->run();
            echo "Python script output:\n" . $process->getOutput() . "\n";
       // }

        usleep(100000); // 100 milliseconds
    }

    protected function isRecordingDone()
    {
        // Check if a recording session exists for the current user
        return RecordingSession::where('user_id', Auth::id())->exists();
    }
}
