<?php

namespace App\Repositories\MailMaster;

interface MailMasterInterface
{
    public function get();
    public function getById($id);
    public function store($request);
    public function update($request, $id);
    public function destroy($id);
}
