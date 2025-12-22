<?php

namespace App\Repositories\MailTemplate;

interface MailTemplateInterface
{
    public function get($request);
    public function getById($id);
    public function store($request);
    public function update($request, $id);
    public function destroy($id);
    public function deleteMulti($ids);
    public function getAll();
}
