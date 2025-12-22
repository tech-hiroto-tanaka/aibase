<?php

namespace App\Repositories\MailSchedule;

use App\Components\CommonComponent;
use App\Models\MailSchedule;
use App\Models\MailTemplate;
use App\Http\Controllers\BaseController;
use App\Repositories\MailSchedule\MailScheduleInterface;
use App\Repositories\MailTemplate\MailTemplateInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;

class MailScheduleRepository extends BaseController implements MailScheduleInterface
{
    private MailSchedule $mailSchedule;
    private MailTemplateInterface $mailTemplate;

    public function __construct(MailSchedule $mailSchedule, MailTemplateInterface $mailTemplate)
    {
        $this->mailSchedule = $mailSchedule;
        $this->mailTemplate = $mailTemplate;
    }

    private function copyFile(MailTemplate $template)
    {
        $path = public_path('storage/' . $template->mail_send_file_path);

        if (!File::isFile($path)) {
            return false;
        }

        $newPath = $this->getFileName($path);

        $this->makeFolder($newPath);
        if (File::copy($path, $newPath)) {
            return preg_replace('/(.*\/)(mail_schedules\/.*)/i', '${2}', $newPath);
        }

        return null;
    }

    private function getFileName($path)
    {
        $extension = '';
        if ($explode = explode('.', $path)) {
            $extension = $explode[count($explode) - 1];
        }

        $dirname = File::dirname($path);
        $newPath = str_replace('/mail_templates', '/mail_schedules', $dirname);

        return $newPath . '/' . CommonComponent::uploadFileName($extension);
    }

    private function makeFolder($path)
    {
        $dirname = File::dirname($path);

        if (!File::isDirectory($dirname)) {
            File::makeDirectory($dirname, 0777, true);
        }
    }

    public function get($request)
    {
        $limit = $this->newListLimit($request);
        $query = $this->mailSchedule;

        if (isset($request['search_input'])) {
            $query = $query->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('mail_from_user_name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('mail_subject', $request['search_input']));
            });
        }

        $items = $query
            ->sortable(['updated_at' => 'desc'])
            ->paginate($limit);
        if ($this->checkPaginatorList($items)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $items = $this->mailSchedule->paginate($limit);
        }

        return $items;
    }

    public function getById($id)
    {
        return $this->mailSchedule->where('id', $id)->first();
    }

    public function store($request)
    {
        $data = $request->post();
        if ($request->unset_file) { //Remove attach from template
            $data['mail_send_file_path'] = null;
            $data['file_name'] = null;
        }
        if ($request->hasFile('mail_send_file_path')) {
            $file = $request->file('mail_send_file_path');
            $extension = $file->getClientOriginalExtension();

            $path = CommonComponent::uploadFile('mail_templates', $file, CommonComponent::uploadFileName($extension));

            if (is_string($path)) {
                $data['mail_send_file_path'] = $path;
                $data['file_name'] = $file->getClientOriginalName();
            }
        } elseif ($request->mail_template_id && $request->file_name) { //Copy file from template to schedule
            $template = $this->mailTemplate->getById($data['mail_template_id']);
            if ($template && $template->mail_send_file_path) {
                $data['mail_send_file_path'] = $this->copyFile($template);
                $data['file_name'] = $template->file_name;
            }
        }
        $data['mail_from_user_name'] = $request->mail_from_user_name ?? '';
        $schedule = $this->mailSchedule->create($data);
        if (!$schedule) {
            return false;
        }
        \Artisan::call("command:SendMailSchedule", ['id' => $schedule->id]);
        return true;
    }

    public function update($request, $id)
    {
        $data = $request->post();
        $item = $this->mailSchedule->find($id);

        if ($request->unset_file) {
            $data['mail_send_file_path'] = null;
            $data['file_name'] = null;
        }
        if ($request->hasFile('mail_send_file_path')) {
            $file = $request->file('mail_send_file_path');
            $extension = $file->getClientOriginalExtension();

            $path = CommonComponent::uploadFile('mail_templates', $file, CommonComponent::uploadFileName($extension));

            if (is_string($path)) {
                $data['mail_send_file_path'] = $path;
                $data['file_name'] = $file->getClientOriginalName();
            }
        } elseif ($request->mail_template_id && $request->mail_template_id != $item->mail_template_id && $request->file_name) { //Copy file from template to schedule
            $tpl = $this->mailTemplate->getById($data['mail_template_id']);
            if ($tpl && $tpl->mail_send_file_path) {
                $data['mail_send_file_path'] = $this->copyFile($tpl);
                $data['file_name'] = $tpl->file_name;
            }
        }

        $data['mail_from_user_name'] = $request->mail_from_user_name ?? '';

        return $item->update($data);
    }

    public function destroy($id)
    {
        return $this->mailSchedule->destroy($id);
    }
    public function deleteMulti($ids)
    {
        return $this->mailSchedule->whereIn('id', $ids)->delete();
    }
    public function getAllMailSchedule($date, $id)
    {
        if ($id) {
            return $this->mailSchedule->where([
                ['id', $id],
                ['flag_send', 0],
                ['mail_send_datetime', '<', Carbon::now()],
            ])->get();
        }
        // return $this->mailSchedule->where('id', 9)->get();
        return $this->mailSchedule->where('mail_send_datetime', Carbon::parse($date))->get();
    }
}
