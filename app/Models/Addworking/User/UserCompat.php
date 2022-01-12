<?php

namespace App\Models\Addworking\User;

use Components\Infrastructure\Foundation\Application\Deprecated;
use App\Repositories\Addworking\User\AddworkingUserRepository;

trait UserCompat
{
    use Deprecated;

    /**
     * @deprecated v0.51.1 replaced by AddworkingUserRepository::getSystemUser
     */
    public static function system(): User
    {
        self::deprecated(__METHOD__, "AddworkingUserRepository::getSystemUser");

        return app(AddworkingUserRepository::class)->getSystemUser();
    }

    /**
     * @deprecated v0.51.1 replaced by AddworkingUserRepository::getJulienPeronaUser
     */
    public static function julienPerona(): User
    {
        self::deprecated(__METHOD__, "AddworkingUserRepository::getJulienPeronaUser");

        return app(AddworkingUserRepository::class)->getJulienPeronaUser();
    }
}
