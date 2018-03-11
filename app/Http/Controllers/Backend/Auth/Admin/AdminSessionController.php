<?php

namespace App\Http\Controllers\Backend\Auth\Admin;

use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Auth\SessionRepository;
use App\Http\Requests\Backend\Auth\Admin\ManageAdminRequest;

/**
 * Class AdminSessionController.
 */
class AdminSessionController extends Controller
{
    /**
     * @param User              $admin
     * @param ManageAdminRequest $request
     * @param SessionRepository $sessionRepository
     *
     * @return mixed
     */
    public function clearSession(User $admin, ManageAdminRequest $request, SessionRepository $sessionRepository)
    {
        $sessionRepository->clearSession($admin);

        return redirect()->back()->withFlashSuccess(__('alerts.backend.admins.session_cleared'));
    }
}
