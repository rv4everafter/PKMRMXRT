<?php

namespace App\Http\Controllers\Backend\Auth\Admin;

use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Auth\AdminRepository;
use App\Http\Requests\Backend\Auth\Admin\ManageAdminRequest;
use App\Http\Requests\Backend\Auth\Admin\UpdateAdminPasswordRequest;

/**
 * Class AdminPasswordController.
 */
class AdminPasswordController extends Controller
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
     * @param User              $admin
     * @param ManageAdminRequest $request
     *
     * @return mixed
     */
    public function edit(User $admin, ManageAdminRequest $request)
    {
        return view('backend.auth.admin.change-password')
            ->withAdmin($admin);
    }

    /**
     * @param User                      $admin
     * @param UpdateAdminPasswordRequest $request
     *
     * @return mixed
     */
    public function update(User $admin, UpdateAdminPasswordRequest $request)
    {
        $this->adminRepository->updatePassword($admin, $request->only('password'));

        return redirect()->route('admin.auth.admin.index')->withFlashSuccess(__('alerts.backend.admins.updated_password'));
    }
}
