<?php

namespace danielme85\LaravelLogToDB\Jobs;

use danielme85\LaravelLogToDB\Models\CreateLogFromRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SaveNewLogEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $logToDb;
    protected $record;

    /**
     * Create a new job instance.
     *
     * @param object $logToDb
     * @param  array $record
     * @return void
     */
    public function __construct($logToDb, $record)
    {
        $this->logToDb = $logToDb;
        $this->record = $record;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $log = CreateLogFromRecord::generate(
            $this->logToDb->connection,
            $this->logToDb->collection,
            $this->record,
            $this->logToDb->detailed,
            $this->logToDb->database['driver'] ?? null
        );

        $log->save();
    }
}