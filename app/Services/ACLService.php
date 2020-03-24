<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 28.01.19
 * Time: 11:03
 */

namespace App\Services;

use App\Helpers\DataImportHelper;
use App\Helpers\FormatHelper;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Sessions;
use App\Models\SocialCredential;
use App\Models\User;
use App\Rules\CorrectPasswordOldUser;
use App\Rules\CorrectPhoneNumber10;
use App\Services\Traits\ServiceErrorsTrait;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Session;

class ACLService
{
    use ServiceErrorsTrait;

    public function __construct()
    {
    }

    /**
     * Массив для Form::select
     * @return array
     */
    public function getRoleSelect()
    {
        $roles = Role::get();
        return FormatHelper::getObjectsCollectionFormSelectData($roles, 'id', 'slug');
    }

    /**
     * Массив для Form::select
     * @return array
     */
    public function getPermissionSelect()
    {
        $permissions = Permission::get();
        return FormatHelper::getObjectsCollectionFormSelectData($permissions, 'id', 'name');
    }

}
