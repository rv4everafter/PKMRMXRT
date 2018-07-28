<?php

namespace App\Repositories\Backend\Auth;

use App\Models\Auth\User;
use App\Models\Auth\Transection;
use App\Models\Auth\Settings;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class CommissionRepository.
 */
class CommissionRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }
    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return LengthAwarePaginator
     */
    public function getPendingPaymentPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc', $req) : LengthAwarePaginator
    {
        $month=isset($req['monthFilter'])?$req['monthFilter']:date('m');
        $year=isset($req['yearFilter'])?$req['yearFilter']:date('Y');
        $firstdate=date('Y-m-d',strtotime('01-'.$month.'-'.$year));
        $lastdate=date('Y-m-t',strtotime($firstdate));
        return $this->model->select(DB::raw('ROUND(SUM(transections.amount),2) as amount'),'users.referral_code','users.email','users.first_name'
                ,'users.last_name','users.account_no','users.account_title','users.bank_name','users.branch_name','users.ifcs','users.swift_code')
               ->join('transections','users.referral_code','=','transections.transection_to')
                ->where('transections.transection_to','!=',null)->where('transections.type','credit')->where('transections.status','pending')
                ->where('users.id','!=',3)
                ->whereRaw("DATE(transections.created_at) >= '$firstdate'")
               ->whereRaw("DATE(transections.created_at) <= '$lastdate'")
                ->having(DB::raw('SUM(transections.amount)'),'<',500)
            ->orderBy($orderBy, $sort)
            ->groupBy('transections.transection_to','users.id','users.uuid','users.referral_code','users.first_name','users.last_name',
                    'users.account_no','users.account_title','users.bank_name','users.branch_name','users.ifcs','users.swift_code','users.email')
            ->paginate($paged);
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return LengthAwarePaginator
     */
    public function getPaymentPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc', $req) : LengthAwarePaginator
    {
        $month=isset($req['monthFilter'])?$req['monthFilter']:date('m');
        $year=isset($req['yearFilter'])?$req['yearFilter']:date('Y');
        $firstdate=date('Y-m-d',strtotime('01-'.$month.'-'.$year));
        $lastdate=date('Y-m-t',strtotime($firstdate));
        return $this->model->select(DB::raw('ROUND(SUM(transections.amount),2) as amount'),'users.id','users.referral_code','users.email','users.first_name'
                ,'users.last_name','users.account_no','users.account_title','users.bank_name','users.branch_name','users.ifcs','users.swift_code')
               ->join('transections','users.referral_code','=','transections.transection_to')
                ->where('transections.transection_to','!=',null)->where('transections.type','credit')->where('transections.status','pending')
                ->where('users.id','!=',3)
                ->whereRaw("DATE(transections.created_at) >= '$firstdate'")
               ->whereRaw("DATE(transections.created_at) <= '$lastdate'")
                ->having(DB::raw('SUM(transections.amount)'),'>',500)
            ->orderBy($orderBy, $sort)
            ->groupBy('transections.transection_to','users.id','users.uuid','users.referral_code','users.first_name','users.last_name',
                    'users.account_no','users.account_title','users.bank_name','users.branch_name','users.ifcs','users.swift_code','users.email')
            ->paginate($paged);
    } 
    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return LengthAwarePaginator
     */
    public function getCompletedPaymentPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc', $req) : LengthAwarePaginator
    {
        $month=isset($req['monthFilter'])?$req['monthFilter']:date('m');
        $year=isset($req['yearFilter'])?$req['yearFilter']:date('Y');
        $firstdate=date('Y-m-d',strtotime('01-'.$month.'-'.$year));
        $lastdate=date('Y-m-t',strtotime($firstdate));
        return $this->model->select(DB::raw('ROUND(SUM(transections.amount),2) as amount'),'users.referral_code','users.email','users.first_name'
                ,'users.last_name','users.account_no','users.account_title','users.bank_name','users.branch_name','users.ifcs','users.swift_code')
                ->where('transections.transection_to','!=',null)->where('transections.type','credit')
                ->where('users.id','!=',3)
               
               ->join('transections',function($join) use($firstdate,$lastdate){
                   $join->on('users.referral_code','=','transections.transection_to');
               })
               ->whereRaw("DATE(transections.created_at) >= '$firstdate'")
               ->whereRaw("DATE(transections.created_at) <= '$lastdate'")
            ->orderBy($orderBy, $sort)
            ->groupBy('transections.transection_to','users.id','users.uuid','users.referral_code','users.first_name','users.last_name',
                    'users.account_no','users.account_title','users.bank_name','users.branch_name','users.ifcs','users.swift_code','users.email')
            ->paginate($paged);
    }
    
    public function setCompletedPayment($referral_code){
        return Transection::where('transection_to',$referral_code)->update(['status'=>'completed']);
    }
    

}
