<?php

namespace App\Repositories\Job;

interface JobInterface
{
    public function getJobs($request);
    public function getById($id);
    public function store($request);
    public function update($request, $id);
    public function destroy($id);
    public function checkCode($request);
    public function getJobNew($limit = 10);
    public function getJobSuggest($job);
    public function searchJob($request, $limit = 6);
    public function jobPublic($request);
    public function getJobFavorites($request);
    public function getJobViewHistories($request);
    public function userRegisterApp($id);
}
