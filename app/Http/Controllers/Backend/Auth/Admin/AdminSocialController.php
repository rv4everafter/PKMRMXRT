<?php

namespace App\Http\Controllers\Backend\Auth\Admin;

use App\Models\Auth\User;
use App\Models\Auth\SocialAccount;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\Admin\ManageAdminRequest;
use App\Repositories\Backend\Access\Admin\SocialRepository;

/**
 * Class AdminSocialController.
 */
class AdminSocialController extends Controller
{
    /**
     * @param User                 $admin
     * @param SocialAccount          $social
     * @param ManageAdminRequest    $request
     * @param SocialRepository $socialRepository
     *
     * @return mixed
     */
    public function unlink(User $admin, SocialAccount $social, ManageAdminRequest $request, SocialRepository $socialRepository)
    {
        $socialRepository->delete($admin, $social);

        return redirect()->back()->withFlashSuccess(__('alerts.backend.admins.social_deleted'));
    }
}
