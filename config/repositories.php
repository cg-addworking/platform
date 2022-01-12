<?php

use Components\Sogetrel\Mission\Application\Repositories\MissionTrackingLineAttachmentRepository;

return [

    'addworkingEnterprise' => App\Repositories\Addworking\Enterprise\AddworkingEnterpriseRepository::class,
    'contract' => App\Repositories\Addworking\Contract\ContractRepository::class,
    'contractDocument' => App\Repositories\Addworking\Contract\ContractDocumentRepository::class,
    'contractParty' => App\Repositories\Addworking\Contract\ContractPartyRepository::class,
    'contractPartyDocumentType' => App\Repositories\Addworking\Contract\ContractPartyDocumentTypeRepository::class,
    'customer' => App\Repositories\Addworking\Enterprise\CustomerRepository::class,
    'documentType' => App\Repositories\Addworking\Enterprise\DocumentTypeRepository::class,
    'enterprise' => App\Repositories\Addworking\Enterprise\EnterpriseRepository::class,
    'enterpriseDocument' => App\Repositories\Addworking\Enterprise\DocumentRepository::class,
    'enterpriseFamily' => App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository::class,
    'mission' => App\Repositories\Addworking\Mission\MissionRepository::class,
    'missionTrackingLineAttachment' => MissionTrackingLineAttachmentRepository::class,
    'resource' => Components\Enterprise\Resource\Application\Repositories\ResourceRepository::class,
    'user' => App\Repositories\Addworking\User\UserRepository::class,
    'vendor' => App\Repositories\Addworking\Enterprise\VendorRepository::class,

];
