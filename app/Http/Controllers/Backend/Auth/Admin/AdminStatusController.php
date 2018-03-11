<?php

namespace App\Http\Controllers\Backend\Auth\Admin;

use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Auth\AdminRepository;
use App\Http\Requests\Backend\Auth\Admin\ManageAdminRequest;

/**
 * Class AdminStatusController.
 */
class AdminStatusController extends Controller
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
     * @param ManageAdminRequest $request
     *
     * @return mixed
     */
    public function getDeactivated(ManageAdminRequest $request)
    {
        return view('backend.auth.admin.deactivated')
            ->withAdmins($this->adminRepository->getInactivePaginated(25, 'id', 'asc'));
    }

    /**
     * @param ManageAdminRequest $request
     *
     * @return mixed
     */
    public function getDeleted(ManageAdminRequest $request)
    {
        return view('backend.auth.admin.deleted')
            ->withAdmins($this->adminRepository->getDeletedPaginated(25, 'id', 'asc'));
    }

    /**
     * @param User              $admin
     * @param                   $status
     * @param ManageAdminRequest $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function mark(User $admin, $status, ManageAdminRequest $request)
    {
        $this->adminRepository->mark($admin, $status);

        return redirect()->route($status == 1 ?
            'admin.auth.admin.index' :
            'admin.auth.admin.deactivated'
        )->withFlashSuccess(__('alerts.backend.admins.updated'));
    }

    /**
     * @param User              $deletedAdmin
     * @param ManageAdminRequest $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function delete(User $deletedAdmin, ManageAdminRequest $request)
    {
        $this->adminRepository->forceDelete($deletedAdmin);
        return redirect()->route('admin.auth.admin.deleted')->withFlashSuccess(__('alerts.backend.admins.deleted_permanently'));
    }

    /**
     * @param User              $deletedAdmin
     * @param ManageAdminRequest $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function restore(User $deletedAdmin, ManageAdminRequest $request)
    {  
        $this->adminRepository->restore($deletedAdmin);
        return redirect()->route('admin.auth.admin.index')->withFlashSuccess(__('alerts.backend.admins.restored'));
    }
}
