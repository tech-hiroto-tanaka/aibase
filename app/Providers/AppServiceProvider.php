<?php

namespace App\Providers;

use App\Repositories\CompanyContact\CompanyContactInterface;
use App\Repositories\CompanyContact\CompanyContactRepository;
use App\Repositories\Contact\ContactInterface;
use App\Repositories\Contact\ContactRepository;
use App\Repositories\User\UserInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\News\NewsInterface;
use App\Repositories\News\NewsRepository;
use App\Repositories\Job\JobInterface;
use App\Repositories\Job\JobRepository;
use App\Repositories\Genre\GenreInterface;
use App\Repositories\Genre\GenreRepository;
use App\Repositories\Prefecture\PrefectureInterface;
use App\Repositories\Prefecture\PrefectureRepository;
use App\Repositories\Area\AreaInterface;
use App\Repositories\Area\AreaRepository;
use App\Repositories\Skill\SkillInterface;
use App\Repositories\Skill\SkillRepository;
use App\Repositories\Feature\FeatureInterface;
use App\Repositories\Feature\FeatureRepository;
use App\Repositories\DesiredCost\DesiredCostInterface;
use App\Repositories\DesiredCost\DesiredCostRepository;
use App\Repositories\Favorite\FavoriteInterface;
use App\Repositories\Favorite\FavoriteRepository;
use App\Repositories\UserViewHistory\UserViewHistoryInterface;
use App\Repositories\UserViewHistory\UserViewHistoryRepository;
use App\Repositories\JobContact\JobContactInterface;
use App\Repositories\JobContact\JobContactRepository;
use App\Repositories\MailTemplate\MailTemplateInterface;
use App\Repositories\MailTemplate\MailTemplateRepository;
use App\Repositories\MailSchedule\MailScheduleInterface;
use App\Repositories\MailSchedule\MailScheduleRepository;
use App\Repositories\MailMaster\MailMasterInterface;
use App\Repositories\MailMaster\MailMasterRepository;
use App\Repositories\SystemSetting\SystemSettingInterface;
use App\Repositories\SystemSetting\SystemSettingRepository;
use App\Repositories\Admin\AdminInterface;
use App\Repositories\Admin\AdminRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(NewsInterface::class, NewsRepository::class);
        $this->app->bind(JobInterface::class, JobRepository::class);
        $this->app->bind(ContactInterface::class, ContactRepository::class);
        $this->app->bind(GenreInterface::class, GenreRepository::class);
        $this->app->bind(AreaInterface::class, AreaRepository::class);
        $this->app->bind(PrefectureInterface::class, PrefectureRepository::class);
        $this->app->bind(SkillInterface::class, SkillRepository::class);
        $this->app->bind(FeatureInterface::class, FeatureRepository::class);
        $this->app->bind(DesiredCostInterface::class, DesiredCostRepository::class);
        $this->app->bind(CompanyContactInterface::class, CompanyContactRepository::class);
        $this->app->bind(FavoriteInterface::class, FavoriteRepository::class);
        $this->app->bind(UserViewHistoryInterface::class, UserViewHistoryRepository::class);
        $this->app->bind(JobContactInterface::class, JobContactRepository::class);
        $this->app->bind(MailTemplateInterface::class, MailTemplateRepository::class);
        $this->app->bind(MailScheduleInterface::class, MailScheduleRepository::class);
        $this->app->bind(MailMasterInterface::class, MailMasterRepository::class);
        $this->app->bind(SystemSettingInterface::class, SystemSettingRepository::class);
        $this->app->bind(AdminInterface::class, AdminRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
