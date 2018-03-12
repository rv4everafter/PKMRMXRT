<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use App\Events\Backend\Auth\User\UserDeleted;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Http\Requests\Backend\Auth\User\StoreUserRequest;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Http\Requests\Backend\Auth\User\UpdateUserRequest;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ManageUserRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ManageUserRequest $request)
    {
        return view('backend.auth.user.index')
            ->withUsers($this->userRepository->getActivePaginated(25, 'id', 'asc'))->withPending($this->userRepository->getInactiveCount());
    }

    /**
     * @param ManageUserRequest    $request
     * @param RoleRepository       $roleRepository
     * @param PermissionRepository $permissionRepository
     *
     * @return mixed
     */
    public function create(ManageUserRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        return view('backend.auth.user.create')
            ->withRoles($roleRepository->with('permissions')->get(['id', 'name']))
            ->withPermissions($permissionRepository->get(['id', 'name']));
    }

    /**
     * @param StoreUserRequest $request
     *
     * @return mixed
     */
    public function store(StoreUserRequest $request)
    {
      
        if(User::where('referral_code',$request['enroller_id'])->count() == 0){
              return redirect(route('admin.auth.user.create'))->withFlashDanger('Enroller id is invalid. Please check and try agin');
        }
        if(User::where('referral_code',$request['sponsor_id'])->count() == 0){
              return redirect(route('admin.auth.user.create'))->withFlashDanger('Sponser id is invalid. Please check and try agin');
        }
        if(User::where('sponsor_id',$request['sponsor_id'])->count() > 3){
              return redirect(route('admin.auth.user.create'))->withFlashDanger('Sponser already has 3 direct downlines. Please try with other sponser');
        }
        $this->userRepository->create($request->only(
            'enroller_id',
            'sponsor_id',
            'dob',
            'pan_no',
            'phone',
            'gender',
            'marital_status',
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

        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('alerts.backend.users.created'));
    }

    /**
     * @param User              $user
     * @param ManageUserRequest $request
     *
     * @return mixed
     */
    public function show(User $user, ManageUserRequest $request)
    {
        return view('backend.auth.user.show')
            ->withUser($user);
    }

    /**
     * @param User                 $user
     * @param ManageUserRequest    $request
     * @param RoleRepository       $roleRepository
     * @param PermissionRepository $permissionRepository
     *
     * @return mixed
     */
    public function edit(User $user, ManageUserRequest $request, RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        return view('backend.auth.user.edit')
            ->withUser($user)
            ->withRoles($roleRepository->get())
            ->withUserRoles($user->roles->pluck('name')->all())
            ->withPermissions($permissionRepository->get(['id', 'name']))
            ->withUserPermissions($user->permissions->pluck('name')->all());
    }

    /**
     * @param User              $user
     * @param UpdateUserRequest $request
     *
     * @return mixed
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $this->userRepository->update($user, $request->only(
            'first_name', 'last_name', 'email', 'avatar_type', 'avatar_location','enroller_id','sponsor_id','dob',
            'pan_no','phone','gender','marital_status','receive_email','address1','address2','city','state','postal_code',
            'nominee_name','nominee_relation','account_no','account_title','bank_name','branch_name','ifcs','swift_code',
            'active','confirmed','confirmation_email'
        ));

        return redirect()->route('admin.auth.user.index')->withFlashSuccess(__('alerts.backend.users.updated'));
    }

    /**
     * @param User              $user
     * @param ManageUserRequest $request
     *
     * @return mixed
     */
    public function destroy(User $user, ManageUserRequest $request)
    {
        $this->userRepository->deleteById($user->id);

        event(new UserDeleted($user));

        return redirect()->route('admin.auth.user.deleted')->withFlashSuccess(__('alerts.backend.users.deleted'));
    }
}
