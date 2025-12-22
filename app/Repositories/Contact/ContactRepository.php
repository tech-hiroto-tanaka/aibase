<?php

namespace App\Repositories\Contact;

use App\Mail\UserContactMail;
use App\Enums\ContactType;
use App\Models\Contact;
use App\Http\Controllers\BaseController;
use App\Repositories\Contact\ContactInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class ContactRepository extends BaseController implements ContactInterface
{
    private Contact $contact;
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function get($request)
    {
        // TODO: Implement get() method.
    }

    public function getById($id)
    {
        return $this->contact->where('id', $id)->first();
    }

    public function store($request)
    {
        $this->contact->hira_first_name = $request->hira_first_name;
        $this->contact->hira_last_name = $request->hira_last_name;
        $this->contact->kata_first_name = $request->kata_first_name;
        $this->contact->kata_last_name = $request->kata_last_name;
        $this->contact->contact_phone_number = $request->contact_phone_number;
        $this->contact->contact_email = $request->contact_email;
        $this->contact->contact_content = $request->contact_content;
        $this->contact->contact_type = ContactType::NEW_CONTACT;
        $this->contact->contact_agent = $request->header('user-agent');
        $this->contact->contact_ip = request()->ip();
        if (!$this->contact->save()) {
            return false;
        }
        $mailContents = [
            'hira_first_name' => $request->hira_first_name,
            'hira_last_name' => $request->hira_last_name,
            'email' => $request->contact_email,
            'content' => $request->contact_content
        ];
        Mail::to($request->contact_email)->send(new UserContactMail($mailContents));
        return true;
    }

    public function update($request, $id)
    {
        $contactInfo = $this->contact->where('id', $id)->first();
        if (!$contactInfo) {
            return false;
        }
        $contactInfo->contact_type = $request->contact_type ?? 0;
        return $contactInfo->save();
    }

    public function destroy($id)
    {
        $contactInfo = $this->contact->where('id', $id)->first();
        if (!$contactInfo) {
            return false;
        }
        if ($contactInfo->delete()) {
            return true;
        }
        return false;
    }

    public function getContacts($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $contactBuilder = $this->contact;
        if (isset($request['search_input'])) {
            $contactBuilder = $contactBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('hira_first_name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('hira_last_name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('kata_first_name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('kata_last_name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('contact_email', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence(DB::raw('CASE contact_type WHEN 0 THEN "新規 ( 未対応）" WHEN 1 THEN "対応中" WHEN 2 THEN "対応済" ELSE "対応必要無し" END'), $request['search_input']));
            });
        }
        $contacts = $contactBuilder->sortable(['created_at' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($contacts)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $contacts = $contactBuilder->paginate($newSizeLimit);
        }
        return $contacts;
    }
}
