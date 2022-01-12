<?php

namespace App\Policies\Addworking\Common;

use App\Models\Addworking\User\User;
use App\Models\Addworking\Common\CsvLoaderReport;
use Illuminate\Auth\Access\HandlesAuthorization;

class CsvLoaderReportPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isSupport();
    }

    public function view(User $user, CsvLoaderReport $csvLoaderReport)
    {
        return $user->enterprise->isCustomer() || $this->viewAny($user);
    }

    public function create(User $user)
    {
        return $this->viewAny($user);
    }

    public function update(User $user, CsvLoaderReport $csvLoaderReport)
    {
        return $this->viewAny($user);
    }

    public function delete(User $user, CsvLoaderReport $csvLoaderReport)
    {
        return $this->viewAny($user);
    }

    public function restore(User $user, CsvLoaderReport $csvLoaderReport)
    {
        return $this->viewAny($user);
    }

    public function forceDelete(User $user, CsvLoaderReport $csvLoaderReport)
    {
        return $this->viewAny($user);
    }

    public function download(User $user, CsvLoaderReport $csvLoaderReport)
    {
        return $this->viewAny($user) && $csvLoaderReport->error_count > 0;
    }
}
