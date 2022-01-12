<?php

namespace Components\Contract\Contract\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractNotificationEntityInterface;
use Illuminate\Database\Eloquent\Model;

class ContractNotification extends Model implements ContractNotificationEntityInterface
{
    use HasUuid;

    protected $table = "addworking_contract_contract_notifications";

    protected $fillable = [
        'notification_name',
        'sent_date',
    ];

    protected $dates = [
        'sent_date',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function contract()
    {
        return $this->belongsTo(Contract::class)->withDefault();
    }

    public function sentTo()
    {
        return $this->belongsTo(User::class, 'sent_to')->withDefault();
    }
    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setContract(ContractEntityInterface $contract): void
    {
        $this->contract()->associate($contract);
    }

    public function setSentTo($user): void
    {
        $this->sentTo()->associate($user);
    }

    public function setNotificationName(string $notification_name): void
    {
        $this->notification_name = $notification_name;
    }

    public function setSentDate($sent_date): void
    {
        $this->sent_date = $sent_date;
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getNotificationName(): string
    {
        return $this->notification_name;
    }

    public function getSentDate()
    {
        return $this->sent_date;
    }
}
