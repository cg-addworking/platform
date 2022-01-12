<?php

namespace Components\Billing\Outbound\Application\Policies;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Outbound\Application\Repositories\InvoiceParameterRepository;
use Components\Billing\Outbound\Application\Repositories\MemberRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\App;

class OutboundInvoicePolicy
{
    use HandlesAuthorization;

    protected $userRepository;
    protected $enterpriseRepository;
    protected $memberRepository;
    protected $outboundInvoiceRepository;
    protected $invoiceParameterRepository;

    public function __construct(
        UserRepository $userRepository,
        EnterpriseRepository $enterpriseRepository,
        MemberRepository $memberRepository,
        OutboundInvoiceRepository $outboundInvoiceRepository,
        InvoiceParameterRepository $invoiceParameterRepository
    ) {
        $this->userRepository            = $userRepository;
        $this->enterpriseRepository      = $enterpriseRepository;
        $this->memberRepository          = $memberRepository;
        $this->outboundInvoiceRepository = $outboundInvoiceRepository;
        $this->invoiceParameterRepository = $invoiceParameterRepository;
    }

    public function index(User $user, Enterprise $enterprise)
    {
        if (! $this->enterpriseRepository->isCustomer($enterprise)) {
            return Response::deny("Enterprise type is not customer");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->memberRepository->isMemberOf($user, $enterprise)) {
            return Response::deny("User is not member of this enterprise");
        }

        return Response::allow();
    }

    public function show(User $user, OutboundInvoice $invoice)
    {
        if (! $invoice->exists) {
            return Response::deny("Invoice doesn't exist");
        }

        if (! $invoice->enterprise->exists) {
            return Response::deny("Invoice has no enterprise");
        }

        if (! $this->enterpriseRepository->isCustomer($invoice->enterprise)) {
            return Response::deny("Enterprise type is not customer");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->memberRepository->isMemberOf($user, $invoice->enterprise)) {
            return Response::deny("User is not member of this enterprise");
        }

        return Response::allow();
    }

    public function edit(User $user, OutboundInvoice $invoice)
    {
        if ($this->outboundInvoiceRepository->isValidated($invoice)) {
            return Response::deny("This outboundInvoice is validated");
        }

        if (! ($response = $this->show($user, $invoice))->allowed()) {
            return $response;
        }

        if (! $this->enterpriseRepository->isCustomer($invoice->enterprise)) {
            return Response::deny("Enterprise type is not customer");
        }

        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function indexSupport(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function create(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function indexAssociate(User $user, Enterprise $enterprise)
    {
        if (! $this->enterpriseRepository->isCustomer($enterprise)) {
            return Response::deny("Enterprise type is not customer");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->memberRepository->isMemberOf($user, $enterprise)) {
            return Response::deny("User is not member of this enterprise or User is not support");
        }

        return Response::allow();
    }

    public function storeAssociate(User $user, Enterprise $enterprise)
    {
        if (! $this->enterpriseRepository->isCustomer($enterprise)) {
            return Response::deny("Enterprise type is not customer");
        }

        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("Connected user is not support");
        }

        return Response::allow();
    }

    public function storeDissociate(User $user, Enterprise $enterprise)
    {
        if (! $this->enterpriseRepository->isCustomer($enterprise)) {
            return Response::deny("Enterprise type is not customer");
        }

        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("Connected user is not support");
        }

        return Response::allow();
    }

    public function generateFile(User $user, Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        if ($this->outboundInvoiceRepository->isValidated($outboundInvoice)) {
            return Response::deny("This outboundInvoice is already validated");
        }

        if (! $this->enterpriseRepository->isCustomer($enterprise)) {
            return Response::deny("Enterprise type is not customer");
        }

        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("Connected user is not support");
        }

        return Response::allow();
    }

    public function publish(User $user, Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("Connected user is not support");
        }

        if ($this->outboundInvoiceRepository->isPublished($outboundInvoice)) {
            return Response::deny("Outbound invoice is already published");
        }

        return Response::allow();
    }

    public function unpublish(User $user, Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("Connected user is not support");
        }

        if (! $this->outboundInvoiceRepository->isPublished($outboundInvoice)) {
            return Response::deny("Outbound invoice is already unpublished");
        }

        return Response::allow();
    }

    public function createCreditNote(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("Connected user is not support");
        }

        return Response::allow();
    }

    public function indexCreditLine(User $user, Enterprise $enterprise)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function export(User $user, Enterprise $enterprise)
    {
        if (! $this->enterpriseRepository->isCustomer($enterprise)) {
            return Response::deny("Enterprise type is not customer");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->memberRepository->isMemberOf($user, $enterprise)) {
            return Response::deny("User is not member of this enterprise");
        }

        return Response::allow();
    }

    public function createFromInboundInvoice(User $user, InboundInvoice $inboundInvoice)
    {
        $invoice_parameter = $this->invoiceParameterRepository->findByEnterprise($inboundInvoice->customer);

        if (is_null($invoice_parameter)) {
            return Response::deny("Customer doesnt have access to this feature");
        }

        if (! $invoice_parameter->getInvoicingFromInboundInvoice()) {
            return Response::deny("Customer doesnt have access to this feature");
        }

        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if ($inboundInvoice->outboundInvoice->exists) {
            return Response::deny("Inbound invoice is already associated to an outbound invoice");
        }

        if ($inboundInvoice->status != InboundInvoice::STATUS_VALIDATED) {
            return Response::deny("Inbound invoice is not in validated status");
        }

        return Response::allow();
    }

    public function search(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    /**
     * @param User $user
     * @param OutboundInvoice $outboundInvoice
     * @return Response
     */
    public function validate(User $user, OutboundInvoice $outboundInvoice)
    {
        if ($this->outboundInvoiceRepository->isValidated($outboundInvoice)) {
            return Response::deny("This outboundInvoice is already validated");
        }

        if ($outboundInvoice->getStatus() != OutboundInvoiceInterface::STATUS_FILE_GENERATED) {
            return Response::deny("You dont not have access to this feature");
        }

        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        return Response::deny("You dont not have access to this feature");
    }
}
