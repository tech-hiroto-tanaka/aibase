<?php

namespace App\Repositories\CompanyContact;

use App\Mail\CompanyContactMail;
use App\Enums\ContactType;
use App\Models\CompanyContact;
use App\Repositories\Area\AreaInterface;
use App\Http\Controllers\BaseController;
use App\Mail\ContactCompanyMail;
use App\Repositories\CompanyContact\CompanyContactInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class CompanyContactRepository extends BaseController implements CompanyContactInterface
{
    private $area;
    private CompanyContact $companyContact;
    public function __construct(AreaInterface $area, CompanyContact $companyContact)
    {
        $this->area = $area;
        $this->companyContact = $companyContact;
    }

    public function get($request)
    {
        // TODO: Implement get() method.
    }

    public function getById($id)
    {
        return $this->companyContact->where('id', $id)->with('area')->first();
    }

    public function store($request)
    {
        // $area = $this->area->where('id',$request->area_id)->first();
        // $area_name = $area->area_name;
        $this->companyContact->company_name = $request->company_name;
        $this->companyContact->department_name = $request->department_name;
        $this->companyContact->contact_hira_first_name = $request->contact_hira_first_name;
        $this->companyContact->contact_hira_last_name = $request->contact_hira_last_name;
        $this->companyContact->contact_kata_first_name = $request->contact_kata_first_name;
        $this->companyContact->contact_kata_last_name = $request->contact_kata_last_name;
        $this->companyContact->contact_phone_number = $request->contact_phone_number;
        $this->companyContact->contact_email = $request->contact_email;
        $this->companyContact->area_id = $request->area_id;
        $this->companyContact->contact_content = $request->contact_content;
        $this->companyContact->contact_agent = $request->header('user-agent');
        $this->companyContact->contact_ip = request()->ip();
        if (!$this->companyContact->save()) {
            return false;
        }
        $mailContents = [
            'company_name' => $request->company_name,
            'department_name' => $request->department_name,
            'contact_hira_first_name' => $request->contact_hira_first_name,
            'contact_hira_last_name' => $request->contact_hira_last_name,
            'contact_kata_first_name' => $request->contact_kata_first_name,
            'contact_kata_last_name' => $request->contact_kata_last_name,
            'contact_phone_number' => $request->contact_phone_number,
            'area_name' => $this->area->getById($request->area_id)['area_name'],
            'email' => $request->contact_email,
            'content' => $request->contact_content
        ];
        Mail::to($request->contact_email)->send(new CompanyContactMail($mailContents));
        return true;
    }

    public function update($request, $id)
    {
        $companyContactInfo = $this->companyContact->where('id', $id)->first();
        if (!$companyContactInfo) {
            return false;
        }
        $companyContactInfo->contact_type = $request->contact_type ?? 0;
        return $companyContactInfo->save();
    }

    public function destroy($id)
    {
        $companyContactInfo = $this->companyContact->where('id', $id)->first();
        if (!$companyContactInfo) {
            return false;
        }
        if ($companyContactInfo->delete()) {
            return true;
        }
        return false;
    }
    public function checkEmail($request)
    {
        return !$this->companyContact->where(function ($query) use ($request) {
            $query->where(['contact_email' => $request["value"]]);
        })->exists();
    }

    public function getCompanyContacts($request)
    {
        $newSizeLimit = $this->newListLimit($request);
        $companyContactBuilder = $this->companyContact->with('area');
        if (isset($request['search_input'])) {
            $companyContactBuilder = $companyContactBuilder->where(function ($q) use ($request) {
                $q->orWhere($this->escapeLikeSentence('company_name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('department_name', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence('contact_email', $request['search_input']));
                $q->orWhere($this->escapeLikeSentence(DB::raw('CASE contact_type WHEN 0 THEN "新規 ( 未対応）" WHEN 1 THEN "対応中" WHEN 2 THEN "対応済" ELSE "対応必要無し" END'), $request['search_input']));
            });
        }
        $companyContacts = $companyContactBuilder->sortable(['created_at' => 'desc'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($companyContacts)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $companyContacts = $companyContactBuilder->paginate($newSizeLimit);
        }
        return $companyContacts;
    }
}
