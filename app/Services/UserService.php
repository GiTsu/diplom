<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 28.01.19
 * Time: 11:03
 */

namespace App\Services;

use App\Helpers\DataImportHelper;
use App\Helpers\Facades\FileLogger;
use App\Helpers\FormatHelper;
use App\Models\AccountComment;
use App\Models\Children;
use App\Models\ConfirmEmail;
use App\Models\ConfirmPhone;
use App\Models\Document;
use App\Models\Location;
use App\Models\PromoBonus;
use App\Models\PromoCampaign;
use App\Models\Rate;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserLocationRate;
use App\Models\UserProfile;
use App\Rules\CorrectPassword;
use App\Rules\CorrectPhoneNumber10;
use App\Services\MessageService\MessageService;
use App\Services\PromoService\PromoService;
use App\Services\Traits\ServiceCountersTrait;
use App\Services\Traits\ServiceErrorsTrait;
use App\Services\Traits\ServiceSuccessTrait;
use Auth;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Session\SessionManager;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Log;


class UserService
{
    use ServiceErrorsTrait;
    use ServiceCountersTrait;
    use ServiceSuccessTrait;

    public function __construct()
    {

    }

}
