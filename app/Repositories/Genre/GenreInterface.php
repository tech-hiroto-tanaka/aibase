<?php

namespace App\Repositories\Genre;

interface GenreInterface
{
    public function get($request);
    public function getById($id);
    public function store($request);
    public function update($request, $id);
    public function destroy($id);
    public function getAll();
    public function getMaxOrderNum();
}
