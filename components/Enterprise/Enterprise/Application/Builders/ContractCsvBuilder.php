<?php

namespace Components\Enterprise\Enterprise\Application\Builders;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractVariable;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractVariableEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Models\ContractModelVariable;
use Components\Enterprise\BusinessTurnover\Application\Repositories\EnterpriseRepository;
use Components\Infrastructure\Foundation\Application\CsvBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ContractCsvBuilder extends CsvBuilder
{
    protected $headers = [
        0 => 'Créateur',
        1 => 'Date de création',
        2 => 'Modèle de contrat',
        3 => 'Partie prenante 1 (ST)',
        4 => 'Numéro SIRET de la Partie prenante 1 (ST)',
        5 => 'CA (ST)',
        6 => 'Partie prenante 2',
        7 => 'Etat',
        8 => 'Nom du Chantier',
        9 => 'Numéro du Chantier',
        10 => 'Date de signature du contrat',
    ];

    protected $variables_positions = [];

    private User $user;

    public function __construct(
        User $user,
        string $path = null,
        string $separator = ";",
        string $enclosure = "\"",
        string $escape = "\\"
    ) {
        $this->user = $user;
        parent::__construct($path, $separator, $enclosure, $escape);
    }

    protected function normalize(Model $contract): array
    {
        return $this->includeContent($contract);
    }

    protected function includeContent(Contract $contract): array
    {
        $userRepository = App::make(UserRepositoryInterface::class);
        $state = App::make(ContractRepositoryInterface::class)->getContractFacadeState($contract, $this->user);
        $parties = App::make(ContractRepositoryInterface::class)->getSignatoryParties($contract);
        $party_order_1 = $parties->where('order', 1)->first();
        $party_order_2 = $parties->where('order', 2)->first();
        $created_by = $contract->getCreatedBy();
        $creator_name = isset($created_by)
            ? ($userRepository->isSupport($created_by) ? 'AddWorking' : $created_by->name )
            : 'N/A';

        $workfield = null;
        if (!is_null($contract->getMission()) && !is_null($contract->getMission()->getWorkField())) {
            $workfield = $contract->getMission()->getWorkField();
        }

        $normalizedData =  [
            0 => $creator_name,
            1 => $contract->getCreatedAt(),
            2 => !is_null($contract->getContractModel()) ? $contract->getContractModel()->getDisplayName() : 'N/A',
            3 => isset($party_order_1) && !is_null($party_order_1->getEnterprise()) ?
                $party_order_1->getEnterprise()->name : 'N/A',
            4 => isset($party_order_1) && !is_null($party_order_1->getEnterprise()) ?
                $party_order_1->getEnterprise()->siren : 'N/A',
            5 => isset($party_order_2) && !is_null($party_order_2->getEnterprise()) ?
                $this->getLastYearBusinessTurnover($party_order_2->getEnterprise()) : 'N/A',
            6 => isset($party_order_2) && !is_null($party_order_2->getEnterprise()) ?
                $party_order_2->getEnterprise()->name : 'N/A',
            7 => $state
                ? __("components.contract.contract.application.views.contract._state.{$state}")
                : 'N/A',
            8 => $workfield ? $workfield->getDisplayName() : 'N/A',
            9 => $workfield ? $workfield->getExternalId() : 'N/A',
            10 => isset($party_order_2) ? $party_order_2->getSignedAt() : 'N/A',
        ];

        return $this->includeVariables($normalizedData, $contract);
    }

    protected function getLastYearBusinessTurnover(Enterprise $model)
    {
        $turnover = App::make(EnterpriseRepository::class)->getLastYearBusinessTurnover($model);
        if (isset($turnover) && !is_null($turnover)) {
            return $turnover->amount;
        }
        return 'N/A';
    }

    private function includeVariables(array $data, $contract): array
    {
        $data = array_merge($data, $this->variables_positions);
        foreach ($contract->getContractVariables() as $variable) {
            /* @var ContractVariableEntityInterface $variable */
            if (!$variable->getContractModelVariable()->getIsExportable()) {
                continue;
            }

            /* @var ContractVariable $variable */
            $key = $variable->getContractModelVariable()->getContractModelParty()->getOrder()
                .'.'
                .strtolower($variable->getContractModelVariable()->getName());

            if (key_exists($key, $this->headers)) {
                $data[$key] = $variable->getValue();
            }
        }

        return $data;
    }

    public function includeHeader($contracts): void
    {
        $contract_models = $contracts->pluck('contractModel')->unique();

        foreach ($contract_models as $contract_model) {
            /* @var ContractModel $contract_model */
            foreach ($contract_model->getVariables() as $model_variable) {
                /* @var ContractModelVariable $model_variable */
                if (!$model_variable->getIsExportable()) {
                    continue;
                }

                $key = $model_variable->getContractModelParty()->getOrder().'.'.strtolower($model_variable->getName());

                $this->variables_positions[$key] = 'N/A';
                $this->headers[$key] =
                    $model_variable->getContractModelParty()->getOrder() . ' ' . $model_variable->getDisplayName();
            }
        }
    }
}
