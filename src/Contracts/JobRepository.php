<?php

namespace Laravel\Horizon\Contracts;

use Illuminate\Support\Collection;
use Laravel\Horizon\JobPayload;

interface JobRepository
{
    /**
     * Get the next job ID that should be assigned.
     *
     * @return string
     */
    public function nextJobId();

    /**
     * Get the total count of recent jobs.
     *
     * @return int
     */
    public function totalRecent();

    /**
     * Get the total count of failed jobs.
     *
     * @return int
     */
    public function totalFailed();

    /**
     * Get a chunk of recent jobs.
     *
     * @param  string  $afterIndex
     * @return \Illuminate\Support\Collection
     */
    public function getRecent($afterIndex = null);

    /**
     * Get a chunk of failed jobs.
     *
     * @param  string  $afterIndex
     * @return \Illuminate\Support\Collection
     */
    public function getFailed($afterIndex = null);

    /**
     * Get a chunk of pending jobs.
     *
     * @param  string  $afterIndex
     * @param  string  $search
     * @return \Illuminate\Support\Collection
     */
    public function getPending($afterIndex = null, $search = null);

    /**
     * Get a chunk of completed jobs.
     *
     * @param  string  $afterIndex
     * @param  string  $search
     * @return \Illuminate\Support\Collection
     */
    public function getCompleted($afterIndex = null, $search = null);

    /**
     * Get a chunk of silenced jobs.
     *
     * @param  string  $afterIndex
     * @return \Illuminate\Support\Collection
     */
    public function getSilenced($afterIndex = null);

    /**
     * Get the count of recent jobs.
     *
     * @return int
     */
    public function countRecent();

    /**
     * Get the count of failed jobs.
     *
     * @return int
     */
    public function countFailed();

    /**
     * Get the count of pending jobs.
     *
     * @return int
     */
    public function countPending();

    /**
     * Get the count of completed jobs.
     *
     * @return int
     */
    public function countCompleted();

    /**
     * Get the count of silenced jobs.
     *
     * @return int
     */
    public function countSilenced();

    /**
     * Get the count of the recently failed jobs.
     *
     * @return int
     */
    public function countRecentlyFailed();

    /**
     * Retrieve the jobs with the given IDs.
     *
     * @param  array  $ids
     * @param  mixed  $indexFrom
     * @return \Illuminate\Support\Collection
     */
    public function getJobs(array $ids, $indexFrom = 0);

    /**
     * Insert the job into storage.
     *
     * @param  string  $connection
     * @param  string  $queue
     * @param  \Laravel\Horizon\JobPayload  $payload
     * @return void
     */
    public function pushed($connection, $queue, JobPayload $payload);

    /**
     * Mark the job as reserved.
     *
     * @param  string  $connection
     * @param  string  $queue
     * @param  \Laravel\Horizon\JobPayload  $payload
     * @return void
     */
    public function reserved($connection, $queue, JobPayload $payload);

    /**
     * Mark the job as released / pending.
     *
     * @param  string  $connection
     * @param  string  $queue
     * @param  \Laravel\Horizon\JobPayload  $payload
     * @return void
     */
    public function released($connection, $queue, JobPayload $payload);

    /**
     * Mark the job as completed and monitored.
     *
     * @param  string  $connection
     * @param  string  $queue
     * @param  \Laravel\Horizon\JobPayload  $payload
     * @return void
     */
    public function remember($connection, $queue, JobPayload $payload);

    /**
     * Mark the given jobs as released / pending.
     *
     * @param  string  $connection
     * @param  string  $queue
     * @param  \Illuminate\Support\Collection  $payloads
     * @return void
     */
    public function migrated($connection, $queue, Collection $payloads);

    /**
     * Handle the storage of a completed job.
     *
     * @param  \Laravel\Horizon\JobPayload  $payload
     * @param  bool  $failed
     * @param  bool  $silenced
     * @return void
     */
    public function completed(JobPayload $payload, $failed = false, $silenced = false);

    /**
     * Delete the given monitored jobs by IDs.
     *
     * @param  array  $ids
     * @return void
     */
    public function deleteMonitored(array $ids);

    /**
     * Trim the recent job list.
     *
     * @return void
     */
    public function trimRecentJobs();

    /**
     * Trim the failed job list.
     *
     * @return void
     */
    public function trimFailedJobs();

    /**
     * Trim the monitored job list.
     *
     * @return void
     */
    public function trimMonitoredJobs();

    /**
     * Find a failed job by ID.
     *
     * @param  string  $id
     * @return \stdClass|null
     */
    public function findFailed($id);

    /**
     * Mark the job as failed.
     *
     * @param  \Exception  $exception
     * @param  string  $connection
     * @param  string  $queue
     * @param  \Laravel\Horizon\JobPayload  $payload
     * @return void
     */
    public function failed($exception, $connection, $queue, JobPayload $payload);

    /**
     * Store the retry job ID on the original job record.
     *
     * @param  string  $id
     * @param  string  $retryId
     * @return void
     */
    public function storeRetryReference($id, $retryId);

    /**
     * Delete a failed job by ID.
     *
     * @param  string  $id
     * @return int
     */
    public function deleteFailed($id);
}
