<?php

namespace App\Console\Commands;

use App\Enums\Gender;
use App\Enums\DesiredWorkType;
use App\Repositories\User\UserInterface;
use App\Repositories\MailSchedule\MailScheduleInterface;
use App\Repositories\MailMaster\MailMasterInterface;
use App\Repositories\SystemSetting\SystemSettingInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendMailSchedule extends Command
{
    private $user;
    private $mailSchedule;
    private $mailMaster;
    private $systemSetting;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SendMailSchedule {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserInterface $user, MailScheduleInterface $mailSchedule, MailMasterInterface $mailMaster, SystemSettingInterface $systemSetting)
    {
        $this->user = $user;
        $this->mailSchedule = $mailSchedule;
        $this->mailMaster = $mailMaster;
        $this->systemSetting = $systemSetting;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::channel('log_batch')->info('start batch send mail shedule:' . Carbon::now());
        $id = $this->argument('id');
        $schedules = $this->mailSchedule->getAllMailSchedule(Carbon::now()->format('Y/m/d H:i:0'), $id);
        $itemMaster = $this->mailMaster->get();
        $systemSettingInfo = $this->systemSetting->getSystemSetting();
        foreach ($schedules as $schedule) {
            Log::channel('log_batch')->info('send mail shedule id:' . $schedule->id);
            $users = $this->user->getUserSendMail($schedule->mail_condition, true);
            $totalSend = $users->count();
            foreach ($users as $user) {
                Log::channel('log_batch')->info('send mail shedule id:' . $schedule->id . ' to user id:' . $user->id);
                $content = $schedule->mail_body;
                $subject = $schedule->mail_subject;
                foreach ($itemMaster as $valueMaster) {
                    $valueReplate = '';
                    switch ($valueMaster->key) {
                        case '#SEND_DATE#':
                            $valueReplate = Carbon::now()->format('Y/m/d');
                            break;
                        case '#SEND_TIME#':
                            $valueReplate = Carbon::now()->format('H:i:s');
                            break;
                        case '#USER_ID#':
                            $valueReplate = $user->id;
                            break;
                        case '#USER_NAME#':
                            $valueReplate = $user->hira_first_name . $user->hira_last_name;
                            break;
                        case '#USER_NAME_KANA#':
                            $valueReplate = $user->kata_first_name . $user->kata_last_name;
                            break;
                        case '#GENDER#':
                            $valueReplate = Gender::getDescription($user->gender);
                            break;
                        case '#BIRTH_DAY#':
                            $valueReplate = Carbon::parse($user->birthday)->format('Y/m/d');
                            break;
                        case '#USER_EMAIL#':
                            $valueReplate = $user->email;
                            break;
                        case '#USER_PHONE#':
                            $valueReplate = $user->phone_number;
                            break;
                        case '#USER_AREA#':
                            $valueReplate = $user->area ? $user->area->area_name : '';
                            break;
                        case '#USER_HOPE_JOB_TIME#':
                            $valueReplate = DesiredWorkType::getDescription($user->desired_work_type);
                            break;
                        case '#USER_EXPERIENCE_SKILL#':
                            $valueReplate = $user->experience_skills_detail;
                            break;
                        case '#USER_NEAR_STATION#':
                            $valueReplate = $user->nearest_station_name;
                            break;
                    }
                    $content = str_replace($valueMaster->key, $valueReplate, $content);
                    $subject = str_replace($valueMaster->key, $valueReplate, $subject);
                }
                try {
                    Mail::raw($content, function ($message) use ($schedule, $user, $subject, $systemSettingInfo) {
                        $message->to($user->email)
                            ->replyTo($address = $schedule->mail_reply_to_email)
                            ->subject($subject);
                            if ($systemSettingInfo && $systemSettingInfo->system_email) {
                                $message->from($address = $systemSettingInfo->system_email, $name = $schedule->mail_from_user_name ? $schedule->mail_from_user_name : $systemSettingInfo->system_email);
                            } else {
                                if ($schedule->mail_from_user_name) {
                                    $message->from($address = env('MAIL_FROM_ADDRESS'), $name = $schedule->mail_from_user_name);
                                }
                            }
                        if ($schedule->mail_send_file_path) {
                            $message->attach(
                                env('APP_URL') . '/storage/' . $schedule->mail_send_file_path,
                                [
                                    'as' => $schedule->file_name
                                ]
                            );
                        }
                    });
                    Log::channel('log_batch')->info('send mail shedule id:' . $schedule->id . ' to user id:' . $user->id . ' success');
                } catch (\Throwable $th) {
                    $totalSend--;
                    Log::channel('log_batch')->error($th->getMessage());
                }
            }
            $schedule->mail_send_number = $totalSend;
            $schedule->flag_send = 1;
            $schedule->save();
        }
        Log::channel('log_batch')->info('end batch send mail shedule:' . Carbon::now());
    }
}
