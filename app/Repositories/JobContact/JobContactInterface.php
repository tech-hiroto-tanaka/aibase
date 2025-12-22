<?php

namespace App\Repositories\JobContact;

interface JobContactInterface{
    public function getJobContact($request);
    public function getById($id);
    public function destroy($id);
    public function update($request, $id);
}
