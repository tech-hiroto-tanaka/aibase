<?php

namespace App\Http\Middleware;

use App\Models\Contact;
use App\Models\CompanyContact;
use App\Models\Application;
use Closure;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Auth;

class System
{
    public function __construct(Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('system')->check()) {
            return redirect(route('system.login.index', ['url_redirect' => url()->full()]));
        }
        $routeName = \Route::currentRouteName();
        if ($routeName == 'system.contact.show') {
            Contact::where('id', $request->contact)->update(['is_read' => 1]);
        }
        if ($routeName == 'system.company-contact.show') {
            CompanyContact::where('id', $request->company_contact)->update(['is_read' => 1]);
        }
        if ($routeName == 'system.job-contact.show') {
            Application::where('id', $request->job_contact)->update(['is_read' => 1]);
        }
        view()->share('countUnReadApplication', Application::where('is_read', 0)->count());
        view()->share('countUnReadContact', Contact::where('is_read', 0)->count());
        view()->share('countUnReadCompanyContact', CompanyContact::where('is_read', 0)->count());
        return $next($request);
    }
}
