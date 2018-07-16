<?php

namespace App\Http\Controllers\Backend\Auth\Commission;

use App\Models\Auth\User;
use App\Models\Auth\Transection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Backend\Auth\CommissionRepository;


/**
 * Class CommissionController.
 */
class CommissionController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $commissionRepository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $commissionRepository
     */
    public function __construct(CommissionRepository $commissionRepository)
    {
        $this->commissionRepository = $commissionRepository;
    }

    /**
     * @param ManageUserRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pending(Request $request)
    {
        return view('backend.auth.commission.pending')
            ->withCommission($this->commissionRepository->getPendingPaymentPaginated(25, 'users.id', 'asc'));
    }
     /**
     * @param ManageUserRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payment(Request $request)
    {
        return view('backend.auth.commission.payment')
            ->withCommission($this->commissionRepository->getPaymentPaginated(25, 'users.id', 'asc'));
    }
     /**
     * @param ManageUserRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paymented(User $user)
    {
        $this->commissionRepository->setCompletedPayment($user->referral_code);
        return redirect()->route('admin.auth.commission.payment')->withFlashSuccess(__('alerts.backend.commission.paymented'));;
    }
     /**
     * @param ManageUserRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function completed(Request $request)
    {
        return view('backend.auth.commission.completed')
            ->withCommission($this->commissionRepository->getCompletedPaymentPaginated(25, 'users.id', 'asc',$request->only('monthFilter','yearFilter')));
    }

  
}
