<?php

namespace App\Repositories\Genre;

use App\Models\Genre;
use App\Http\Controllers\BaseController;
use App\Repositories\Genre\GenreInterface;
use Illuminate\Support\Facades\Auth;
use App\Enums\PublishStatus;
use Illuminate\Pagination\Paginator;

class GenreRepository extends BaseController implements GenreInterface
{
    private Genre $genre;
    public function __construct(Genre $genre)
    {
        $this->genre = $genre;
    }

    public function get($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $genreBuilder = $this->genre;

        if (isset($request['search_input'])) {
            $genreBuilder = $genreBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('genre_name', $request['search_input']));
            });
        }

        $newList = $genreBuilder->sortable(['order_number' => 'asc'])->sortable(['updated_at' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($newList)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $newList = $genreBuilder->paginate($newSizeLimit);
        }
        return $newList;
    }

    public function getById($id)
    {
        return $this->genre->where(['id'=>$id])->first();
    }

    public function store($request)
    {
        $this->genre->genre_name = $request->genre_name;
        $this->genre->order_number = (int) $request->order_number;

        return $this->genre->save();
    }

    public function update($request, $id)
    {
        $item = $this->genre->where('id', $id)->first();
        if (!$item) {
            return false;
        }
        $item->genre_name = $request->genre_name;
        $item->order_number = $request->order_number;
        return $item->save();
    }

    public function destroy($id)
    {
        $genreInfo = $this->genre->where(['id'=> $id])->first();
        if (!$genreInfo) {
            return false;
        }
        return $genreInfo->delete();
    }
    public function getAll()
    {
        return $this->genre->orderBy('order_number')->get();
    }

    public function getMaxOrderNum(){
        $sortNo = $this->genre->max('order_number');

        return $sortNo;
    }
}
