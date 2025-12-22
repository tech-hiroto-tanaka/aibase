<?php

namespace App\Repositories\SystemSetting;

use App\Models\SystemSetting;
use App\Http\Controllers\BaseController;
use App\Repositories\SystemSetting\SystemSettingInterface;
use Illuminate\Support\Facades\Auth;

class SystemSettingRepository extends BaseController implements SystemSettingInterface
{
    private SystemSetting $systemSetting;
    public function __construct(SystemSetting $systemSetting)
    {
        $this->systemSetting = $systemSetting;
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
        $systemSetting = $this->getSystemSetting();
        if (!$systemSetting) {
            $systemSetting = new $this->systemSetting();
        }
        $systemSetting->system_email = $request->system_email;
        return $systemSetting->save();
    }

    public function update($request, $id)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
    public function getSystemSetting()
    {
        return $this->systemSetting->first();
    }
}
