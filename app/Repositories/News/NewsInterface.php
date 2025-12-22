<?php

namespace App\Repositories\News;

interface NewsInterface
{
    public function getNews($request);
    public function destroy($id);
    public function store($request);
    public function getById($id);
    public function update($request, $id);
    public function getTopNews($limit);
    public function userGetNews($request);
    public function getNewPublishById($id);
}
