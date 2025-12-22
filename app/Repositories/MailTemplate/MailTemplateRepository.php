<?php

namespace App\Repositories\MailTemplate;

use App\Components\CommonComponent;
use App\Models\MailTemplate;
use App\Http\Controllers\BaseController;
use App\Repositories\MailTemplate\MailTemplateInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class MailTemplateRepository extends BaseController implements MailTemplateInterface
{
    private MailTemplate $mailTemplate;
    public function __construct(MailTemplate $mailTemplate)
    {
        $this->mailTemplate = $mailTemplate;
    }

    public function get($request)
    {
        $limit = $this->newListLimit($request);
        $query = $this->mailTemplate;

        if (isset($request['search_input'])) {
            $query = $query->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('mail_name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('mail_subject', $request['search_input']));
            });
        }

        $templates = $query
            ->sortable(['updated_at' => 'desc'])
            ->paginate($limit);

        if ($this->checkPaginatorList($templates)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $templates = $this->mailTemplate->paginate($limit);
        }

        return $templates;
    }

    public function getById($id)
    {
        return $this->mailTemplate->where('id', $id)->first();
        // if ($item && $item->mail_send_file_path) {
        //     $item->files = [
        //         [
        //             'id' => random_int(1000, 10000),
        //             'name' => $item->file_name
        //         ]
        //     ];
        // }

        // return $item;
    }

    public function store($request)
    {
        $data = $request->post();

        if ($request->input('unset_file')) {
            $data['mail_send_file_path'] = null;
            $data['file_name'] = null;
        } elseif ($request->hasFile('mail_send_file_path')) {
            $file = $request->file('mail_send_file_path');
            $extension = $file->getClientOriginalExtension();

            $path = CommonComponent::uploadFile('mail_templates', $file, CommonComponent::uploadFileName($extension));
            if (is_string($path)) {
                $data['mail_send_file_path'] = $path;
                $data['file_name'] = $file->getClientOriginalName();
            }
        }
        $data['mail_from_user_name'] = $request->mail_from_user_name ?? '';

        return $this->mailTemplate->create($data);
    }

    public function update($request, $id)
    {
        $data = $request->post();

        if ($request->input('unset_file')) {
            $data['mail_send_file_path'] = null;
            $data['file_name'] = null;
        } elseif ($request->hasFile('mail_send_file_path')) {
            $file = $request->file('mail_send_file_path');
            $extension = $file->getClientOriginalExtension();

            $path = CommonComponent::uploadFile('mail_templates', $file, CommonComponent::uploadFileName($extension));
            if (is_string($path)) {
                $data['mail_send_file_path'] = $path;
                $data['file_name'] = $file->getClientOriginalName();
            }
        }
        $data['mail_from_user_name'] = $request->mail_from_user_name ?? '';
        return $this->mailTemplate->find($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->mailTemplate->where('id', $id)->delete();
    }
    public function getAll()
    {
        return $this->mailTemplate->get();
    }
    public function deleteMulti($ids)
    {
        return $this->mailTemplate->whereIn('id', $ids)->delete();
    }
}
