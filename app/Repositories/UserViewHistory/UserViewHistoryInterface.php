<?php

namespace App\Repositories\UserViewHistory;

interface UserViewHistoryInterface
{
    public function get($request);
    public function getById($id);
    public function store($id);
    public function update($request, $id);
    public function destroy($id);
}
