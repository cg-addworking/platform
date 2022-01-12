<?php

namespace App\Providers;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\DocumentTypeField;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseActivity;
use App\Models\Addworking\Enterprise\Iban;
use App\Models\Addworking\Enterprise\Site;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\Mission\ProposalResponse;
use App\Models\Addworking\Mission\PurchaseOrder;
use App\Models\Addworking\User\ChatMessage;
use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Sogetrel\User\Passwork as SogetrelPasswork;
use App\Models\Sogetrel\User\Quizz;
use App\Policies\Addworking\Billing\InboundInvoicePolicy;
use App\Policies\Addworking\Common\AddressPolicy;
use App\Policies\Addworking\Common\CommentPolicy;
use App\Policies\Addworking\Common\FilePolicy;
use App\Policies\Addworking\Enterprise\DocumentPolicy;
use App\Policies\Addworking\Enterprise\DocumentTypeFieldPolicy;
use App\Policies\Addworking\Enterprise\DocumentTypePolicy;
use App\Policies\Addworking\Enterprise\EnterpriseActivityPolicy;
use App\Policies\Addworking\Enterprise\EnterprisePolicy;
use App\Policies\Addworking\Enterprise\IbanPolicy;
use App\Policies\Addworking\Enterprise\SitePolicy;
use App\Policies\Addworking\Mission\MissionPolicy;
use App\Policies\Addworking\Mission\OfferPolicy;
use App\Policies\Addworking\Mission\ProposalPolicy;
use App\Policies\Addworking\Mission\ProposalResponsePolicy;
use App\Policies\Addworking\Mission\PurchaseOrderPolicy;
use App\Policies\Addworking\User\OnboardingProcessPolicy;
use App\Policies\MessagePolicy;
use App\Policies\Sogetrel\User\Passwork\SogetrelPassworkPolicy;
use App\Policies\Sogetrel\User\QuizzPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Address::class                     => AddressPolicy::class,
        ChatMessage::class                 => MessagePolicy::class,
        Comment::class                     => CommentPolicy::class,
        Enterprise::class                  => EnterprisePolicy::class,
        EnterpriseActivity::class          => EnterpriseActivityPolicy::class,
        File::class                        => FilePolicy::class,
        Iban::class                        => IbanPolicy::class,
        InboundInvoice::class              => InboundInvoicePolicy::class,
        Mission::class                     => MissionPolicy::class,
        Offer::class                       => OfferPolicy::class,
        Proposal::class                    => ProposalPolicy::class,
        Quizz::class                       => QuizzPolicy::class,
        SogetrelPasswork::class            => SogetrelPassworkPolicy::class,
        OnboardingProcess::class           => OnboardingProcessPolicy::class,
        Document::class                    => DocumentPolicy::class,
        DocumentType::class                => DocumentTypePolicy::class,
        DocumentTypeField::class           => DocumentTypeFieldPolicy::class,
        ProposalResponse::class            => ProposalResponsePolicy::class,
        Site::class                        => SitePolicy::class,
        PurchaseOrder::class               => PurchaseOrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
