<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auth\User;
use App\Models\Auth\Transection;
use App\Models\Auth\Settings;
class MonthlyCommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:commission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monthly add commission';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

     public function setCommissionSchedule($user){
        $enroller_income=Settings::where('code','virtual_code')->first(['value']);
        //enroller income
        if($user && $user->enroller_id && $user->enroller_id!='eroller1'){
            $v_user_main=User::where("referral_code",$user->referral_code)->first();
            $v_user_main->virtual_payment_count+=1;
            $v_user_main->save();
            $last_transection = Transection::where("transection_to",$user->enroller_id)
                    ->where("commission_type", "virtual")->where("transection_by", $user->referral_code)
                    ->orderBy("created_at","desc")->limit(1)->first();
            $count=  isset($last_transection) && isset($last_transection->times)?$last_transection->times:0;
            $transection = Transection::create([
                            'transection_to'        => $user->enroller_id?$user->enroller_id:null,
                            'transection_by'        => $user->referral_code?$user->referral_code:null,
                            'previous_bal'          => 0,
                            'times'                 => $count+1,
                            'type'                  => 'credit',
                            'commission_type'       => 'virtual',
                            'amount'                => $enroller_income['value'],
                        ]);
        }
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users=User::leftjoin("transections",  function ($join) {
            $join->on("transections.transection_to","=","users.referral_code");
            $join->orderBy("transections.created_at","desc");
            $join->limit(1);
        })->where("isUser",0)->where("users.virtual_payment_count","<",15)->get();
        foreach ($users as $key => $user) {
            $this->setCommissionSchedule($user);
        }
    }
}
