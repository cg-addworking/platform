<?php

namespace App\Policies\Addworking\Billing;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\EnterpriseIbanRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\App;

class InboundInvoicePolicy
{
    use HandlesAuthorization;

    public function index(User $user, Enterprise $enterprise)
    {
        return $user->isSupport()
            || $user->enterprise->isCustomer() && $user->enterprise->isCustomerOf($enterprise)
            || $user->hasAccessFor($enterprise, [User::ACCESS_TO_BILLING])
            && $user->hasRoleFor($enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            && $enterprise->isVendor()
            && $enterprise->hasCustomers();
    }

    public function indexCustomer(User $user)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $user->enterprise->isCustomer()) {
            return Response::deny("You must be a member of a customer enterprise");
        }

        return Response::allow();
    }

    public function create(User $user, Enterprise $enterprise)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $user->hasAccessFor($enterprise, User::ACCESS_TO_BILLING)) {
            return Response::deny("You don't have access to billing");
        }

        if (! $user->hasRoleFor($enterprise, User::IS_ADMIN, User::IS_OPERATOR)) {
            return Response::deny("You need the role ADMIN or OPERATOR");
        }

        if (! $enterprise->isVendor()) {
            return Response::deny("You can only create inbound invoices for vendor enterprises");
        }

        if (! $enterprise->hasCustomers()) {
            return Response::deny("You can only create inboud invoice for enterprises having customers");
        }

        if (! App::make(EnterpriseIbanRepository::class)->hasApprovedIban($enterprise)) {
            return Response::deny("You need to have an approved IBAN attached");
        }

        return Response::allow();
    }

    public function view(User $user, InboundInvoice $inbound_invoice)
    {
        return $user->isSupport()
            || ($user->enterprise->isCustomer()
                && $user->enterprises->contains($inbound_invoice->customer))
            || $user->hasAccessFor($inbound_invoice->enterprise, [User::ACCESS_TO_BILLING])
            && $user->hasRoleFor($inbound_invoice->enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY]);
    }

    public function edit(User $user, InboundInvoice $inbound_invoice)
    {
        return $user->isSupport()
            || $user->hasAccessFor($inbound_invoice->enterprise, [User::ACCESS_TO_BILLING])
            && $user->hasRoleFor($inbound_invoice->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
            && ! $inbound_invoice->is_locked;
    }

    public function delete(User $user, InboundInvoice $inbound_invoice)
    {
        return $this->edit($user, $inbound_invoice);
    }

    public function download(User $user, InboundInvoice $inbound_invoice)
    {
        return $this->view($user, $inbound_invoice)
            && $inbound_invoice->file()->exists();
    }

    public function validate(User $user, InboundInvoice $inbound_invoice)
    {
        if (! $inbound_invoice->validateAmounts()) {
            return Response::deny("Amounts of invoice are not equal with total amounts of invoice lines");
        }

        if ($inbound_invoice->isLocked()) {
            return Response::deny("Invoice is locked, you cannot validate it");
        }

        if (! $user->isSupport()) {
            return Response::deny("You are not member of AddWorking support");
        }

        return Response::allow();
    }

    public function export(User $user)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if ($user->enterprise->isCustomer() && $user->hasAccessFor($user->enterprise, User::ACCESS_TO_BILLING)) {
            return Response::allow();
        }

        return Response::deny("You do not have access to this export");
    }

    public function viewReconciliationInfo(User $user, InboundInvoice $inbound_invoice)
    {
        if ($user->isSupport()) {
            return Response::allow('You are member of Addworking support');
        }

        if (! $user->enterprise->isCustomer()) {
            return Response::deny("You are not a customer");
        }

        if ($user->enterprise->isBusinessPlus()) {
            return Response::deny("You cannot view this because your subscription is Business +");
        }

        if (! $user->enterprise->isCustomerOf($inbound_invoice->enterprise)) {
            return Response::deny("You are not customer of {$inbound_invoice->enterprise->name}");
        }

        if (! $inbound_invoice->customer->is($user->enterprise)) {
            return Response::deny("You are not customer of this inbound invoice");
        }


        return Response::allow('All conditions are met');
    }

    public function updateComplianceStatus(User $user)
    {
        if (! $user->isSupport()) {
            return Response::deny("You are not member of AddWorking support");
        }

        return Response::allow();
    }
}
