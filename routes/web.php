<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\User\ForgotPasswordController as UserForgotPasswordController;
use App\Http\Controllers\User\PasswordResetController as UserPasswordResetController;
use App\Http\Controllers\User\ForgotPasswordCompleteController as UserForgotPasswordCompleteController;
use App\Http\Controllers\PasswordResetExpiredController;
use App\Http\Controllers\System\DashboardController as SystemDashboardController;
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\System\ContactController as SystemContactController;
use App\Http\Controllers\System\CompanyContactController as SystemCompanyContactController;
use App\Http\Controllers\System\ForgotPasswordSuccessController as SystemForgotPasswordSuccessController;
use App\Http\Controllers\System\LoginController as SystemLoginController;
use App\Http\Controllers\System\ForgotPasswordController as SystemForgotPasswordController;
use App\Http\Controllers\System\PasswordResetController as SystemPasswordResetController;
use App\Http\Controllers\System\NewController as SystemNewController;
use App\Http\Controllers\System\ItemMasterController;
use App\Http\Controllers\System\JobController;
use App\Http\Controllers\System\AreasController;
use App\Http\Controllers\System\DesiredCostsController;
use App\Http\Controllers\System\FeaturesController;
use App\Http\Controllers\System\GenresController;
use App\Http\Controllers\System\SkillsController;
use App\Http\Controllers\System\MailTemplateController;
use App\Http\Controllers\System\MailScheduleController;
use App\Http\Controllers\System\SystemSettingController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ViewHistoryController;
use App\Http\Controllers\CompanyContactController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\System\JobContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::resource('top', TopController::class);
Route::resource('login', LoginController::class);

Route::resource('register', RegisterController::class);
Route::get('register-success', [RegisterController::class, 'done'])->name('register.done');
Route::post('register', [RegisterController::class, 'store'])->name('user.register');
Route::get('verify/{id}', [RegisterController::class, 'activeUser'])->name('user.active');
Route::get('verify-success', [RegisterController::class, 'verifySuccess'])->name('user.verifySuccess');
Route::post('register-check-email', [RegisterController::class, 'checkEmail'])->name('user.checkEmail');

Route::resource('forgot-password-complete', UserForgotPasswordCompleteController::class, ['as' => 'user']);
Route::resource('password_reset_expired', PasswordResetExpiredController::class);

Route::get('logout', [LoginController::class, 'logout'])->name('user.logout');
Route::resource('forgot-password', UserForgotPasswordController::class, ['as' => 'user']);
Route::resource('password-reset', UserPasswordResetController::class, ['as' => 'user']);
// Route::resource('password_reset_expired', PasswordResetExpiredController::class);
Route::group([
    'prefix' => 'system',
], function () {
    Route::get('/', function () {
        return redirect(route('system.login.index'));
    });
    Route::resource('login', SystemLoginController::class, ['as' => 'system']);
    Route::resource('forgot_password', SystemForgotPasswordController::class, ['as' => 'system']);
    Route::resource('password_reset', SystemPasswordResetController::class, ['as' => 'system']);
    Route::resource('forgot_password_complete', SystemForgotPasswordSuccessController::class, ['as' => 'system']);
    Route::get('logout', [SystemLoginController::class, 'logout'])->name('system.logout');
    Route::group([
        'middleware' => ['system'],
    ], function () {
        Route::resource('dashboard', SystemDashboardController::class, ['as' => 'system']);
        Route::resource('user', UserController::class, ['as' => 'system']);
        Route::get('user-export', [UserController::class, 'export'])->name('system.user.export');
        Route::post('check-email', [UserController::class, 'checkEmail'])->name('system.user.checkEmail');
        Route::resource('news', SystemNewController::class, ['as' => 'system']);
        Route::resource('item-master', ItemMasterController::class, ['as' => 'system']);
        Route::resource('job', JobController::class, ['as' => 'system']);
        Route::post('check-job-code', [JobController::class, 'checkCode'])->name('system.job.checkCode');
        Route::resource('genre', GenresController::class, ['as' => 'system']);
        Route::resource('area', AreasController::class, ['as' => 'system']);
        Route::resource('skill', SkillsController::class, ['as' => 'system']);
        Route::resource('desired-cost', DesiredCostsController::class, ['as' => 'system']);
        Route::resource('feature', FeaturesController::class, ['as' => 'system']);
        Route::resource('contact', SystemContactController::class, ['as' => 'system']);
        Route::resource('company-contact', SystemCompanyContactController::class, ['as' => 'system']);
        Route::resource('job-contact', JobContactController::class, ['as' => 'system']);
        Route::delete('mail-template-delete-multi', [MailTemplateController::class, "deleteMulti"])->name('system.mail-template.delete-multi');
        Route::resource('mail-template', MailTemplateController::class, ['as' => 'system']);
        Route::delete('mail-schedule-delete-multi', [MailScheduleController::class, "deleteMulti"])->name('system.mail-schedule.delete-multi');
        Route::resource('mail-schedule', MailScheduleController::class, ['as' => 'system']);
        Route::resource('system-setting', SystemSettingController::class, ['as' => 'system']);
    });
});


Route::group([
    'middleware' => ['countNew'],
], function () {
    Route::get('/', [TopController::class, 'index'])->name('top.index');
    Route::resource('search', SearchController::class);
    Route::resource('company-contact', CompanyContactController::class);
    Route::resource('news', NewsController::class);
    Route::resource('contact', ContactController::class);
    Route::resource('terms_of_service', TermsController::class);
    Route::resource('privacy', PolicyController::class);
    Route::get('contact-success', [ContactController::class, 'success'])->name('contact.success');
    // Route::resource('company-profile', CompanyProfileController::class);
});
Route::group([
    'middleware' => ['user', 'countNew'],
], function () {
    // Route::resource('my-page', MyPageController::class, ['as' => 'user']);
    Route::post('check-email', [CompanyContactController::class, 'checkEmail'])->name('companyContact.checkEmail');
    Route::resource('favorite', FavoriteController::class, ['as' => 'user']);
    Route::resource('view-history', ViewHistoryController::class, ['as' => 'user']);
    Route::resource('application', ApplicationController::class, ['as' => 'user']);
    Route::get('application-complete', [ApplicationController::class, 'complete'])->name('user.application.complete');
    Route::resource('profile', ProfileController::class, ['as' => 'user']);
});
