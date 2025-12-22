<?php

namespace App\Repositories\CompanyContact;

interface CompanyContactInterface
{
    public function get($request);
    public function getById($id);
    public function store($request);
    public function update($request, $id);
    public function destroy($id);
    public function checkEmail($request);
    public function getCompanyContacts($request);
}
