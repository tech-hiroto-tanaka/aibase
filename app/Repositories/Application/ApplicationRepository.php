<?php

namespace App\Repositories\Application;

use App\Models\Application;
use App\Http\Controllers\BaseController;
use App\Repositories\Application\ApplicationInterface;
use Illuminate\Support\Facades\Auth;

class ApplicationRepository extends BaseController implements ApplicationInterface
{
    private Application $application;
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function get($request)
    {
        // TODO: Implement get() method.
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
