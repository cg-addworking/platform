<?php

namespace App\Models\Addworking\User\Concerns\User;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use InvalidArgumentException;

trait HasPermissions
{
    /**
     * User enterprises pivot attributes
     *
     * @var array
     */
    protected $pivot = [
        'is_signatory',
        'is_legal_representative',
        'is_admin',
        'is_operator',
        'is_readonly',
        'is_mission_offer_broadcaster',
        'is_mission_offer_closer',
        'is_vendor_compliance_manager',
        'is_customer_compliance_manager',
        'is_allowed_to_send_contract_to_signature',
        'is_work_field_creator',
        'is_allowed_to_view_business_turnover',
        'access_to_billing',
        'access_to_mission',
        'access_to_mission_purchase_order',
        'access_to_contract',
        'access_to_user',
        'access_to_enterprise',
        'is_allowed_to_invite_vendors',
        'is_financial',
        'is_accounting_monitoring',
    ];

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this
            ->belongsToMany(Enterprise::class, 'addworking_enterprise_enterprises_has_users')
            ->withPivot($this->pivot)
            ->whereNull('addworking_enterprise_enterprises_has_users.deleted_at')
            ->withTimestamps();
    }

    /**
     * @return bool
     */
    public function isSystemSuperadmin(): bool
    {
        return $this->is_system_superadmin;
    }

    /**
     * @return bool
     */
    public function isSystemAdmin(): bool
    {
        return $this->is_system_admin;
    }

    /**
     * @return bool
     */
    public function isSystemOperator(): bool
    {
        return $this->is_system_operator;
    }

    /**
     * @return bool
     */
    public function isSupport(): bool
    {
        return $this->isSystemSuperadmin()
            || $this->isSystemAdmin()
            || $this->isSystemOperator();
    }

    /**
     * @param Enterprise $enterprise
     * @param $role
     * @return bool
     */
    public function hasRoleFor(Enterprise $enterprise, ...$role): bool
    {
        if (! $enterprise->exists) {
            return false;
        }

        foreach (array_flatten($role) as $name) {
            if (! in_array($name, self::getAvailableRoles())) {
                throw new InvalidArgumentException("no such role '$name'");
            }

            $granted = $this->permissions()
                ->wherePivot('enterprise_id', $enterprise->id)
                ->wherePivot($name, true)
                ->exists();

            if ($granted) {
                return true;
            }
        }

        return false;
    }

    public function getRolesFor(Enterprise $enterprise): array
    {
        $roles = [];

        foreach ($this->getAvailableRoles() as $role) {
            if ($this->hasRoleFor($enterprise, $role)) {
                $roles[] = $role;
            }
        }

        return $roles;
    }

    /**
     * @param  array|string ...$role
     * @return boolean
     */
    public function hasRole(...$role): bool
    {
        return $this->hasRoleFor($this->enterprise, ...$role);
    }

    /**
     * @param Enterprise $enterprise
     * @param $access
     * @return bool
     */
    public function hasAccessFor(Enterprise $enterprise, ...$access): bool
    {
        if (! $enterprise->exists) {
            return false;
        }

        foreach (array_flatten($access) as $name) {
            if (! in_array($name, self::getAvailableAccess())) {
                throw new InvalidArgumentException("no such access '$name'");
            }

            $granted = $this->permissions()
                ->wherePivot('enterprise_id', $enterprise->id)
                ->wherePivot($name, true)
                ->exists();

            if ($granted) {
                return true;
            }
        }

        return false;
    }

    public function getAccessesFor(Enterprise $enterprise): array
    {
        $accesses = [];

        foreach ($this->getAvailableAccess() as $access) {
            if ($this->hasAccessFor($enterprise, $access)) {
                $accesses[] = $access;
            }
        }

        return $accesses;
    }

    /**
     * @param  array|string ...$access
     * @return boolean
     */
    public function hasAccess(...$access): bool
    {
        return $this->hasAccessFor($this->enterprise, ...$access);
    }

    public function hasAccessToMissionFor($enterprise): bool
    {
        return $this->hasAccessFor($enterprise, User::ACCESS_TO_MISSION);
    }

    public function hasAccessToUserFor($enterprise): bool
    {
        return $this->hasAccessFor($enterprise, User::ACCESS_TO_USER);
    }

    public function hasAccessToEnterpriseFor($enterprise): bool
    {
        return $this->hasAccessFor($enterprise, User::ACCESS_TO_ENTERPRISE);
    }

    public function hasAccessToContractFor($enterprise): bool
    {
        return $this->hasAccessFor($enterprise, User::ACCESS_TO_CONTRACT);
    }

    public function hasAccessToBillingFor($enterprise): bool
    {
        return $this->hasAccessFor($enterprise, User::ACCESS_TO_BILLING);
    }

    public function hasAccessToMissionPurchaseOrderFor($enterprise): bool
    {
        return $this->hasAccessFor($enterprise, User::ACCESS_TO_MISSION_PURCHASE_ORDER);
    }

    /**
     * @return boolean
     */
    public function hasAccessToBilling()
    {
        return $this->hasAccess(self::ACCESS_TO_BILLING);
    }

    /**
     * @return boolean
     */
    public function hasAccessToMission()
    {
        return $this->hasAccess(self::ACCESS_TO_MISSION);
    }

    /**
     * @return boolean
     */
    public function hasAccessToMissionPurchaseOrder()
    {
        return $this->hasAccess(self::ACCESS_TO_MISSION_PURCHASE_ORDER);
    }

    /**
     * @return boolean
     */
    public function hasAccessToContract()
    {
        return $this->hasAccess(self::ACCESS_TO_CONTRACT);
    }

    /**
     * @return boolean
     */
    public function hasAccessToUser()
    {
        return $this->hasAccess(self::ACCESS_TO_USER);
    }

    /**
     * @return boolean
     */
    public function hasAccessToEnterprise()
    {
        return $this->hasAccess(self::ACCESS_TO_ENTERPRISE);
    }

    /**
     * @return boolean
     */
    public function isConfirmed(): bool
    {
        return $this->is_confirmed;
    }

    /**
     * @param Enterprise $enterprise
     * @return bool
     */
    public function isAdminFor(Enterprise $enterprise): bool
    {
        return $this
            ->permissions()
            ->wherePivot('enterprise_id', $enterprise->id)
            ->wherePivot(self::IS_ADMIN, true)
            ->exists();
    }

    /**
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return $this->isAdminFor($this->enterprise);
    }

    /**
     *
     * @param  Enterprise $enterprise [description]
     * @return boolean                [description]
     */
    public function isSignatoryFor(Enterprise $enterprise): bool
    {
        return $this
            ->permissions()
            ->wherePivot('enterprise_id', $enterprise->id)
            ->wherePivot(self::IS_SIGNATORY, true)
            ->exists();
    }

    /**
     * @return boolean
     */
    public function isSignatory(): bool
    {
        return $this->isSignatoryFor($this->enterprise);
    }

    /**
     * @return boolean
     */
    public function isLegalRepresentativeOf(Enterprise $enterprise): bool
    {
        return $this
            ->permissions()
            ->wherePivot('enterprise_id', $enterprise->id)
            ->wherePivot(self::IS_LEGAL_REPRESENTATIVE, true)
            ->exists();
    }

    /**
     * @return boolean
     */
    public function isLegalRepresentative(): bool
    {
        return $this->isLegalRepresentativeOf($this->enterprise);
    }

    /**
     * @param Enterprise $enterprise
     * @return bool
     */
    public function isOperatorFor(Enterprise $enterprise): bool
    {
        return $this
            ->permissions()
            ->wherePivot('enterprise_id', $enterprise->id)
            ->wherePivot(self::IS_OPERATOR, true)
            ->exists();
    }

    /**
     * @return boolean
     */
    public function isOperator(): bool
    {
        return $this->isOperatorFor($this->enterprise);
    }

    /**
     * @param Enterprise $enterprise
     * @return bool
     */
    public function isReadonlyFor(Enterprise $enterprise): bool
    {
        return $this
            ->permissions()
            ->wherePivot('enterprise_id', $enterprise->id)
            ->wherePivot(self::IS_READONLY, true)
            ->exists();
    }

    /**
     * @return boolean
     */
    public function isReadonly(): bool
    {
        return $this->isReadonlyFor($this->enterprise);
    }

    public static function getAvailableSystemRoles(bool $trans = false): array
    {
        $system = [
            self::IS_SYSTEM_SUPERADMIN             => __("Superadmin Système"),
            self::IS_SYSTEM_ADMIN                  => __("Admin Système"),
            self::IS_SYSTEM_OPERATOR               => __("Opérateur Système"),
        ];

        return $trans ? $system : array_keys($system);
    }

    public static function getAvailableRoles(bool $trans = false): array
    {
        $roles = [
            self::IS_LEGAL_REPRESENTATIVE          => __("addworking.enterprise.member._form.is_legal_representative"),
            self::IS_ADMIN                         => __("addworking.enterprise.member._form.is_admin"),
            self::IS_OPERATOR                      => __("addworking.enterprise.member._form.is_operator"),
            self::IS_READONLY                      => __("addworking.enterprise.member._form.is_readonly"),
            self::IS_SIGNATORY                     => __("addworking.enterprise.member._form.is_signatory"),
            self::ROLE_FINANCIAL                   => __("addworking.enterprise.member._form.is_financial"),
            self::ROLE_ACCOUNTING_MONITORING       => __("addworking.enterprise.member._form.is_accounting_monitoring"),
            self::IS_CUSTOMER_COMPLIANCE_MANAGER   =>
            __("addworking.enterprise.member._form.is_customer_compliance_manager"),
            self::IS_VENDOR_COMPLIANCE_MANAGER     =>
            __("addworking.enterprise.member._form.is_vendor_compliance_manager"),
            self::IS_MISSION_OFFER_BROADCASTER     =>
            __("addworking.enterprise.member._form.is_mission_offer_broadcaster"),
            self::IS_MISSION_OFFER_CLOSER          => __("addworking.enterprise.member._form.is_mission_offer_closer"),
            self::ROLE_CONTRACT_CREATOR            => __("addworking.enterprise.member._form.role_contract_creator"),
            self::ROLE_SEND_CONTRACT_TO_SIGNATURE  =>
            __("addworking.enterprise.member._form.is_allowed_to_send_contract_to_signature"),
            self::ROLE_WORKFIELD_CREATOR           => __("addworking.enterprise.member._form.is_work_field_creator"),
            self::ROLE_INVITE_VENDORS              =>
            __("addworking.enterprise.member._form.is_allowed_to_invite_vendors"),
            self::ROLE_VIEW_BUSINESS_TURNOVER      =>
            __("addworking.enterprise.member._form.is_allowed_to_view_business_turnover"),
        ];

        return $trans ? $roles : array_keys($roles);
    }

    public static function getAvailableAccess(bool $trans = false): array
    {
        $accesses = [
            self::ACCESS_TO_BILLING                => __("Facturation"),
            self::ACCESS_TO_CONTRACT               => __("Contrats"),
            self::ACCESS_TO_ENTERPRISE             => __("Entreprise"),
            self::ACCESS_TO_MISSION                => __("Mission"),
            self::ACCESS_TO_MISSION_PURCHASE_ORDER => __("Bons de commande"),
            self::ACCESS_TO_USER                   => __("Utilisateurs"),
        ];

        return $trans ? $accesses : array_keys($accesses);
    }
}
