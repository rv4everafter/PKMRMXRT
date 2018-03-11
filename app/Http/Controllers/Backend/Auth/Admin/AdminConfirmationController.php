<?php

namespace App\Http\Controllers\Backend\Auth\Admin;

use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Auth\AdminRepository;
use App\Http\Requests\Backend\Auth\Admin\ManageAdminRequest;
use App\Notifications\Frontend\Auth\AdminNeedsConfirmation;

/**
 * Class AdminConfirmationController.
 */
class AdminConfirmationController extends Controller
{
    /**
     * @var AdminRepository
     */
    protected $adminRepository;

    /**
     * @param AdminRepository $adminRepository
     */
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * @param Admin              $admin
     * @param ManageAdminRequest $request
     *
     * @return mixed
     */
    public function sendConfirmationEmail(User $admin, ManageAdminRequest $request)
    {
        // Shouldn't allow admins to confirm their own accounts when the application is set to manual confirmation
        if (config('access.admins.requires_approval')) {
            return redirect()->back()->withFlashDanger(__('alerts.backend.admins.cant_resend_confirmation'));
        }

        if ($admin->isConfirmed()) {
            return redirect()->back()->withFlashSuccess(__('exceptions.backend.access.admins.already_confirmed'));
        }

        $admin->notify(new AdminNeedsConfirmation($admin->confirmation_code));

        return redirect()->back()->withFlashSuccess(__('alerts.backend.admins.confirmation_email'));
    }

    /**
     * @param User              $admin
     * @param ManageAdminRequest $request
     *
     * @return mixed
     */
    public function confirm(User $admin, ManageAdminRequest $request)
    {
        $this->adminRepository->confirm($admin);

        return redirect()->route('admin.auth.admin.index')->withFlashSuccess(__('alerts.backend.admins.confirmed'));
    }

    /**
     * @param User              $admin
     * @param ManageAdminRequest $request
     *
     * @return mixed
     */
    public function unconfirm(User $admin, ManageAdminRequest $request)
    {
        $this->adminRepository->unconfirm($admin);

        return redirect()->route('admin.auth.admin.index')->withFlashSuccess(__('alerts.backend.admins.unconfirmed'));
    }
}
