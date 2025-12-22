<?php

namespace App\Repositories\Favorite;

use App\Models\Favorite;
use App\Http\Controllers\BaseController;
use App\Repositories\Favorite\FavoriteInterface;
use Illuminate\Support\Facades\Auth;

class FavoriteRepository extends BaseController implements FavoriteInterface
{
    private Favorite $favorite;
    public function __construct(Favorite $favorite)
    {
        $this->favorite = $favorite;
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
        $favorite = $this->favorite->where([
            ['user_id', Auth::guard('user')->user()->id],
            ['job_id', $request->job_id]
        ])->first();
        if (!$favorite) {
            $favorite = new $this->favorite;
            $favorite->user_id = Auth::guard('user')->user()->id;
            $favorite->job_id = $request->job_id;
            return $favorite->save();
        }
        return $favorite->delete();
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
