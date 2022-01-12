<?php

namespace Components\Billing\Outbound\Domain\Repositories;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;

interface OutboundInvoiceRepositoryInterface
{
    public function find(string $id);

    public function save(OutboundInvoiceInterface $outboundInvoice);

    public function getStatuses(): array;

    public function getPeriods(): array;

    public function findByNumber(string $number);

    public function hasStatus(OutboundInvoiceInterface $outboundInvoice, string $status): bool;

    public function list(?array $filter = null, ?string $search = null);

    public function make($data = []): OutboundInvoiceInterface;

    public function hasInboundInvoice(OutboundInvoiceInterface $outboundInvoice, InboundInvoice $inboundInvoice): bool;

    public function getItemsOfInboundInvoice(
        OutboundInvoiceInterface $outboundInvoice,
        InboundInvoice $inboundInvoice
    );

    public function hasFile(OutboundInvoiceInterface $outboundInvoice): bool;

    public function getOutboundInvoicesForPeriodAndDeadline(
        Enterprise $enterprise,
        string $month,
        DeadlineType $deadline
    );

    public function updateStatusTo(OutboundInvoiceInterface $outboundInvoice, string $status);

    public function publish(OutboundInvoiceInterface $outboundInvoice);

    public function unpublish(OutboundInvoiceInterface $outboundInvoice);

    public function isPublished(OutboundInvoiceInterface $outboundInvoice): bool;

    public function findByParentId(string $parentId);

    public function hasParent(OutboundInvoiceInterface $outboundInvoice): bool;
    public function getPaymentOrderOfOutboundInvoice(OutboundInvoiceInterface $outboundInvoice);
    public function validate(User $auth_user, OutboundInvoiceInterface $outboundInvoice);
    public function isValidated(OutboundInvoiceInterface $outboundInvoice);
    public function checkIfStatusEqualsToFileGenerated(OutboundInvoiceInterface $outboundInvoice);
}
