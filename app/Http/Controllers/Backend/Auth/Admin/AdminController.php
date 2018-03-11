<?php

namespace App\Http\Controllers\Backend\Auth\Admin;

use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use App\Events\Backend\Auth\User\UserDeleted;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\AdminRepository;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Http\Requests\Backend\Auth\Admin\StoreAdminRequest;
use App\Http\Requests\Backend\Auth\Admin\ManageAdminRequest;
use App\Http\Requests\Backend\Auth\Admin\UpdateAdminRequest;

/**
 * Class AdminController.
 */
class AdminController extends Controller
{
    /**
     * @var AdminRepository
     */
    protected $adminRepository;

    /**
     * AdminController constructor.
     *
     * @param AdminRepository $admin  Repository
     */
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * @param ManageAdminRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ManageAdminRequest $request)
    {
        return view('backend.auth.admin.index')
            ->withAdmins($this->adminRepository->getActivePaginated(25, 'id', 'asc'));
    }

    /**
     * @param ManageAdminRequest    $request
     * @param RoleRepository       $roleRepository
     * @param PermissionRepository $permissionRepository
     *
     * @return mixed
     */
    public function create(ManageAdminRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        return view('backend.auth.admin.create')
            ->withRoles($roleRepository->with('permissions')->get(['id', 'name']))
            ->withPermissions($permissionRepository->get(['id', 'name']));
    }

    /**
     * @param StoreAdminRequest $request
     *
     * @return mixed
     */
    public function store(StoreAdminRequest $request)
    {
        $this->adminRepository->create($request->only(
            'first_name',
            'last_name',
            'email',
            'password',
            'timezone',
            'active',
            'confirmed',
            'confirmation_email',
            'roles',
            'permissions'
        ));

        return redirect()->route('admin.auth.admin.index')->withFlashSuccess(__('alerts.backend.admins.created'));
    }

    /**
     * @param User              $admin
     * @param ManageAdminRequest $request
     *
     * @return mixed
     */
    public function show(User $admin, ManageAdminRequest $request)
    {
        return view('backend.auth.admin.show')
            ->withAdmin($admin);
    }

    /**
     * @param User                 $admin
     * @param ManageAdminRequest    $request
     * @param RoleRepository       $roleRepository
     * @param PermissionRepository $permissionRepository
     *
     * @return mixed
     */
    public function edit(User $admin, ManageAdminRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        return view('backend.auth.admin.edit')
            ->withAdmin($admin)
            ->withRoles($roleRepository->get())
            ->withAdminRoles($admin->roles->pluck('name')->all())
            ->withPermissions($permissionRepository->get(['id', 'name']))
            ->withAdminPermissions($admin->permissions->pluck('name')->all());
    }

    /**
     * @param User              $admin
     * @param UpdateAdminRequest $request
     *
     * @return mixed
     */
    public function update(User $admin, UpdateAdminRequest $request)
    {
        $this->adminRepository->update($admin, $request->only(
            'first_name',
            'last_name',
            'email',
            'timezone',
            'roles',
            'permissions'
        ));

        return redirect()->route('admin.auth.admin.index')->withFlashSuccess(__('alerts.backend.admins.updated'));
    }

    /**
     * @param User              $admin
     * @param ManageAdminRequest $request
     *
     * @return mixed
     */
    public function destroy(User $admin, ManageAdminRequest $request)
    {
        $this->adminRepository->deleteById($admin->id);

        event(new UserDeleted($admin));

        return redirect()->route('admin.auth.admin.deleted')->withFlashSuccess(__('alerts.backend.admins.deleted'));
    }
}
