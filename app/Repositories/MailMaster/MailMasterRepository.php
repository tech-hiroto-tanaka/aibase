<?php

namespace App\Repositories\MailMaster;

use App\Models\MailMaster;
use App\Http\Controllers\BaseController;
use App\Repositories\MailMaster\MailMasterInterface;
use Illuminate\Support\Facades\Auth;

class MailMasterRepository extends BaseController implements MailMasterInterface
{
    private MailMaster $mailMaster;
    public function __construct(MailMaster $mailMaster)
    {
        $this->mailMaster = $mailMaster;
    }

    public function get()
    {
        return $this->mailMaster->get();
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    public function store($request)
    {
        // TODO: Implement store() method.
    }

    public function update($request, $id)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}
