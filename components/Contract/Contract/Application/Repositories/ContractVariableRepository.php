<?php

namespace Components\Contract\Contract\Application\Repositories;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\ContractPart;
use Components\Contract\Contract\Application\Models\ContractVariable;
use Components\Contract\Contract\Domain\Exceptions\ContractVariableCreationFailedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractVariableEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractVariableRepositoryInterface;
use Components\Contract\Model\Application\Models\ContractModelVariable;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelVariableEntityInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class ContractVariableRepository implements ContractVariableRepositoryInterface
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function make($data = []): ContractVariableEntityInterface
    {
        $class = ContractVariable::class;

        return new $class($data);
    }

    public function list(
        ContractEntityInterface $contract,
        ?array $filter = null,
        ?string $search = null,
        ?string $page = null
    ) {
        $contract_parts = ContractPart::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })->orderBy('order', 'asc')->get();

        $variables = new Collection;

        foreach ($contract_parts as $part) {
            $contract_variables = ContractVariable::query()
            ->with('contractModelVariable')
            ->whereHas('contract', function ($query) use ($contract) {
                return $query->where('id', $contract->getId());
            })
            ->whereHas('contractModelVariable', function ($query) use ($part) {
                $query->whereHas('contractModelPart', function ($query) use ($part) {
                    $query->whereHas('contractParts', function ($query) use ($part) {
                        $query->where('id', $part->getId());
                    });
                });
            })
            ->when($filter['model_variable_display_name'] ?? null, function ($query, $model_variable_display_name) {
                return $query->filterModelVariableDisplayName($model_variable_display_name);
            })
            ->when(
                $filter['model_variable_model_part_display_name'] ?? null,
                function ($query, $model_variable_model_part_display_name) {
                    return $query->filterModelVariableModelPartDisplayName($model_variable_model_part_display_name);
                }
            )
            ->when($filter['model_variable_required'] ?? null, function ($query, $model_variable_required) {
                return $query->filterModelVariableRequired($model_variable_required);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            })
            ->orderBy('order', 'asc')
            ->get();

            $variables->push($contract_variables);
        }

        return $variables->flatten();
    }

    public function save(ContractVariableEntityInterface $contract_variable)
    {
        try {
            $contract_variable->save();
        } catch (ContractVariableCreationFailedException $exception) {
            throw $exception;
        }

        $contract_variable->refresh();

        return $contract_variable;
    }

    public function find($id): ?ContractVariableEntityInterface
    {
        return ContractVariable::find($id);
    }

    public function findMany(array $ids, array $with = [])
    {
        return ContractVariable::whereIn('id', $ids)->with($with)->get();
    }

    public function getContractVariableForEnterprise($enterprises, ContractEntityInterface $contract)
    {
        return ContractVariable::whereHas('contract', function ($q) use ($contract) {
            return $q->where('id', $contract->getId());
        })->whereHas('contractParty', function ($q) use ($enterprises) {
            return $q->whereHas('enterprise', function ($q) use ($enterprises) {
                return $q->whereIn('id', $enterprises->pluck('id'));
            });
        })->get();
    }

    public function getAllContractVariable(ContractEntityInterface $contract)
    {
        return $contract->getContractVariables();
    }

    public function getContractVariablesByModelPart(
        ContractEntityInterface $contract,
        ContractModelPartEntityInterface $model_part
    ) {
        return ContractVariable::whereHas('contract', function ($q) use ($contract) {
            return $q->where('id', $contract->getId());
        })->whereHas('contractModelVariable', function ($query) use ($model_part) {
            return $query->whereHas('contractModelPart', function ($query) use ($model_part) {
                return $query->where('id', $model_part->getId());
            });
        })->get();
    }

    public function checkIfAllRequiredVariablesHasValue(ContractEntityInterface $contract): bool
    {
        return ContractVariable::query()->whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->getId());
        })->whereHas('contractModelVariable', function ($query) {
            return $query->where('required', true);
        })->whereNull('value')
        ->count() === 0;
    }

    public function getNonSystemContractVariables(ContractEntityInterface $contract)
    {
        return ContractVariable::query()->whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->getId());
        })->whereHas('contractModelVariable', function ($query) {
            return $query->whereIn('input_type', [
                ContractModelVariable::INPUT_TYPE_TEXT,
                ContractModelVariable::INPUT_TYPE_DATE,
                ContractModelVariable::INPUT_TYPE_LONG_TEXT,
                ContractModelVariable::INPUT_TYPE_OPTIONS,
            ]);
        })->get();
    }

    public function getSystemContractVariables(ContractEntityInterface $contract)
    {
        return ContractVariable::query()->whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->getId());
        })->whereHas('contractModelVariable', function ($query) {
            return $query->whereNotIn('input_type', [
                ContractModelVariable::INPUT_TYPE_TEXT,
                ContractModelVariable::INPUT_TYPE_DATE,
                ContractModelVariable::INPUT_TYPE_LONG_TEXT,
                ContractModelVariable::INPUT_TYPE_OPTIONS,
            ]);
        })->get();
    }

    public function isSystemVariable(ContractVariableEntityInterface $contract_variable)
    {
        return ! in_array(
            $contract_variable->getContractModelVariable()->getInputType(),
            [
                ContractModelVariable::INPUT_TYPE_TEXT,
                ContractModelVariable::INPUT_TYPE_DATE,
                ContractModelVariable::INPUT_TYPE_LONG_TEXT,
                ContractModelVariable::INPUT_TYPE_OPTIONS,
            ]
        );
    }

    public function createContractVariables(
        ContractEntityInterface $contract,
        ContractModelPartyEntityInterface $contract_model_party,
        ContractPartyEntityInterface $contract_party
    ) {
        foreach ($contract_model_party->getVariables() as $contract_model_variable) {
            if (!$this->checkIfContractVariableExists(
                $contract,
                $contract_model_variable,
                $contract_model_variable->getContractModelPart(),
                $contract_party
            )) {
                $contract_variable = $this->make();
                $contract_variable->setContract($contract);
                $contract_variable->setContractModelVariable($contract_model_variable);
                $contract_variable->setContractParty($contract_party);

                $value = $this->setVariableValue(
                    $contract,
                    $contract_party,
                    $contract_model_variable
                );

                $contract_variable->setValue(
                    !is_null($value) ? \Normalizer::normalize($value) : $value
                );

                $contract_variable->setOrder($contract_model_variable->getOrder());

                $contract_variable->setNumber();
                $this->save($contract_variable);
            }
        }
    }

    public function setVariableValue(
        ContractEntityInterface $contract,
        ContractPartyEntityInterface $contract_party,
        ContractModelVariableEntityInterface $contract_model_variable
    ) {
        switch ($contract_model_variable->getInputType()) {
            case (ContractModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_LEGAL_FORM):
                $value = $contract_party->getEnterprise()->legalForm->display_name;
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_NAME):
                $value = $contract_party->getEnterprise()->name;
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_ADDRESS):
                $value = $contract_party->getEnterprise()->address->one_line;
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_TOWN):
                $value = $contract_party->getEnterprise()->address->town;
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_IDENTIFICATION_NUMBER):
                $value = $contract_party->getEnterprise()->identification_number;
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_SIREN_NUMBER):
                $value = $contract_party->getEnterprise()->siren;
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_REGISTRATION_TOWN):
                $value = $contract_party->getEnterprise()->registration_town;
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_REGISTRATION_DATE):
                $registration_date = $contract_party->getEnterprise()->getRegistrationDate();
                $value = $registration_date ? $registration_date->format('d/m/Y') : null;
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_ENTERPRISE_EMPLOYEES_NUMBER):
                $value = $contract_party->getEnterprise()->activities()->get()->sum('employees_count');
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_SIGNATORY_NAME):
                $value = $contract_party->getSignatory()->name;
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_SIGNATORY_FUNCTION):
                $value = $contract_party->getSignatory()->getJobTitleFor($contract_party->getEnterprise());
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_SIGNATORY_MAIL):
                $value = $contract_party->getSignatory()->email;
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_CONTRACT_ENTERPRISE_OWNER):
                $value = $contract->getEnterprise()->name;
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_CONTRACT_VALID_FROM):
                $value = is_null($contract->getValidFrom()) ? '' : $contract->getValidFrom()->format('Y-m-d');
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_CONTRACT_VALID_UNTIL):
                $value = is_null($contract->getValidUntil()) ? '' : $contract->getValidUntil()->format('Y-m-d');
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_CONTRACT_EXTERNAL_IDENTIFIER):
                $value = $contract->getExternalIdentifier();
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_WORK_FIELD_DESCRIPTION):
                $value = '';
                if (!is_null($contract->getMission()) && !is_null($contract->getMission()->getWorkField())) {
                    $value = $contract->getMission()->getDescription();
                }
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_WORK_FIELD_PROJECT_OWNER):
                $value = '';
                if (!is_null($contract->getMission()) && !is_null($contract->getMission()->getWorkField())) {
                    $value = $contract->getMission()->getWorkField()->getProjectOwner();
                }
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_WORK_FIELD_PROJECT_MANAGER):
                $value = '';
                if (!is_null($contract->getMission()) && !is_null($contract->getMission()->getWorkField())) {
                    $value = $contract->getMission()->getWorkField()->getProjectManager();
                }
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_WORK_FIELD_ADDRESS):
                $value = '';
                if (!is_null($contract->getMission()) && !is_null($contract->getMission()->getWorkField())) {
                    $value = $contract->getMission()->getWorkField()->getAddress();
                }
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_WORK_FIELD_DISPLAY_NAME):
                $value = '';
                if (!is_null($contract->getMission()) && !is_null($contract->getMission()->getWorkField())) {
                    $value = $contract->getMission()->getWorkField()->getDisplayName();
                }
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_WORK_FIELD_EXTERNAL_ID):
                $value = '';
                if (!is_null($contract->getMission()) && !is_null($contract->getMission()->getWorkField())) {
                    $value = $contract->getMission()->getWorkField()->getExternalId();
                }
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_WORK_FIELD_STARTED_AT):
                $value = '';
                if (!is_null($contract->getMission()) && !is_null($contract->getMission()->getWorkField()) &&
                    !is_null($contract->getMission()->getWorkField()->getStartedAt())) {
                    $value = $contract->getMission()->getWorkField()->getStartedAt()->format('Y-m-d');
                }
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_WORK_FIELD_ENDED_AT):
                $value = '';
                if (!is_null($contract->getMission()) && !is_null($contract->getMission()->getWorkField()) &&
                    !is_null($contract->getMission()->getWorkField()->getEndedAt())) {
                    $value = $contract->getMission()->getWorkField()->getEndedAt()->format('Y-m-d');
                }
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_STARTED_AT):
                $value = '';
                if (!is_null($contract->getMission()) && !is_null($contract->getMission()->getWorkField()) &&
                    !is_null($contract->getMission()->getStartsAt())) {
                    $value = $contract->getMission()->getStartsAt()->format('Y-m-d');
                }
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_ENDED_AT):
                $value = '';
                if (!is_null($contract->getMission()) && !is_null($contract->getMission()->getWorkField()) &&
                    !is_null($contract->getMission()->getEndsAt())) {
                    $value = $contract->getMission()->getEndsAt()->format('Y-m-d');
                }
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_WORK_FIELD_SPS_COORDINATOR):
                $value = '';
                if (! is_null($contract->getMission()) && ! is_null($contract->getMission()->getWorkField())) {
                    $value = $contract->getMission()->getWorkField()->getSpsCoordinator();
                }
                break;
            case (ContractModelVariableEntityInterface::INPUT_TYPE_MISSION_AMOUNT):
                $value = '';
                if (! is_null($contract->getMission())) {
                    $value = $contract->getMission()->getAmount();
                }
                break;
            default:
                $value = $contract_model_variable->getDefaultValue();
        }

        if (in_array(
            $contract_model_variable->getInputType(),
            ContractModelVariableEntityInterface::INPUTS_WORKFIELD
        )) {
            if ($value === '' || is_null($value)) {
                $value = 'n/a';
            }
        }

        return $value;
    }

    public function updateSystemContractVariables(ContractEntityInterface $contract)
    {
        $contract_system_variables = $this->getSystemContractVariables($contract);
        foreach ($contract_system_variables as $system_variable) {
            $system_variable->setValue(
                $this->setVariableValue(
                    $contract,
                    $system_variable->getContractParty(),
                    $system_variable->getContractModelVariable()
                )
            );
            $this->save($system_variable);
        }
    }

    public function delete(ContractVariableEntityInterface $contract_variable): bool
    {
        return $contract_variable->delete();
    }

    public function deleteNonSystemContractVariablesForParty(
        ContractEntityInterface $contract,
        ContractPartyEntityInterface $contract_party
    ) {
        foreach ($this->getSystemContractVariables($contract) as $contract_variable) {
            if ($contract_variable->getContractParty()->getId() === $contract_party->getId()) {
                $this->delete($contract_variable);
            }
        }
    }

    private function checkIfContractVariableExists(
        ContractEntityInterface $contract,
        ContractModelVariableEntityInterface $contract_model_variable,
        ContractModelPartEntityInterface $contract_model_part,
        ContractPartyEntityInterface $contract_party
    ): bool {
        return ContractVariable::whereHas('contract', function ($query) use ($contract) {
            return $query->where('id', $contract->getId());
        })->whereHas('contractModelVariable', function ($query) use ($contract_model_variable, $contract_model_part) {
            return $query->whereHas('contractModelPart', function ($query) use ($contract_model_part) {
                return $query->where('id', $contract_model_part->getId());
            })->where('id', $contract_model_variable->getId());
        })->whereHas('contractParty', function ($query) use ($contract_party) {
            return $query->where('id', $contract_party->getId());
        })->exists();
    }

    public function getVariables(ContractEntityInterface $contract)
    {
        return ContractVariable::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        })->orderBy('order')->cursor();
    }

    public function isDeleted(ContractVariableEntityInterface $contract_variable)
    {
        return ! is_null($contract_variable->getDeletedAt());
    }

    public function checkIfVariablesMustBeEdited(ContractEntityInterface $contract): bool
    {
        if ($this->checkIfAllVariablesAreSystemVariables($contract)) {
            if ($this->checkIfAllRequiredVariablesHasValue($contract)) {
                return false;
            } else {
                return true;
            }
        }

        return true;
    }

    public function checkIfAllVariablesAreSystemVariables(ContractEntityInterface $contract): bool
    {
        foreach ($contract->getContractVariables() as $contract_variable) {
            if (! $this->isSystemVariable($contract_variable)) {
                return false;
            }
        }
        return true;
    }

    public function isLongText(ContractVariableEntityInterface $contract_variable): bool
    {
        return in_array($contract_variable->getContractModelVariable()->getInputType(), [
            ContractModelVariableEntityInterface::INPUT_TYPE_LONG_TEXT,
            ContractModelVariableEntityInterface::INPUT_TYPE_WORK_FIELD_DESCRIPTION,
        ]);
    }

    public function isOptions(ContractVariableEntityInterface $contract_variable): bool
    {
        return $contract_variable->getContractModelVariable()->getInputType()
            == ContractModelVariableEntityInterface::INPUT_TYPE_OPTIONS;
    }

    public function isDate(ContractVariableEntityInterface $contract_variable): bool
    {
        return in_array(
            $contract_variable->getContractModelVariable()->getInputType(),
            [
                ContractModelVariableEntityInterface::INPUT_TYPE_DATE,
                ContractModelVariableEntityInterface::INPUT_TYPE_STARTED_AT,
                ContractModelVariableEntityInterface::INPUT_TYPE_ENDED_AT,
            ]
        );
    }

    public function isDatetime(ContractVariableEntityInterface $contract_variable): bool
    {
        return in_array(
            $contract_variable->getContractModelVariable()->getInputType(),
            [
                ContractModelVariableEntityInterface::INPUT_TYPE_CONTRACT_VALID_FROM,
                ContractModelVariableEntityInterface::INPUT_TYPE_CONTRACT_VALID_UNTIL,
                ContractModelVariableEntityInterface::INPUT_TYPE_WORK_FIELD_STARTED_AT,
                ContractModelVariableEntityInterface::INPUT_TYPE_WORK_FIELD_ENDED_AT,
            ]
        );
    }

    public function isEditable(ContractVariableEntityInterface $contract_variable): bool
    {
        return ! in_array($contract_variable->getContractModelVariable()->getInputType(), [
            ContractModelVariable::INPUT_TYPE_ENTERPRISE_NAME,
            ContractModelVariable::INPUT_TYPE_ENTERPRISE_ADDRESS,
            ContractModelVariable::INPUT_TYPE_ENTERPRISE_TOWN,
            ContractModelVariable::INPUT_TYPE_ENTERPRISE_IDENTIFICATION_NUMBER,
            ContractModelVariable::INPUT_TYPE_ENTERPRISE_LEGAL_FORM,
            ContractModelVariable::INPUT_TYPE_ENTERPRISE_SIREN_NUMBER,
            ContractModelVariable::INPUT_TYPE_ENTERPRISE_REGISTRATION_TOWN,
            ContractModelVariable::INPUT_TYPE_SIGNATORY_NAME,
            ContractModelVariable::INPUT_TYPE_SIGNATORY_MAIL,
            ContractModelVariable::INPUT_TYPE_SIGNATORY_FUNCTION,
            ContractModelVariable::INPUT_TYPE_CONTRACT_ENTERPRISE_OWNER,
        ]);
    }

    /**
     * Returns the variables a user can fill in a contract
     *
     * @param ContractEntityInterface $contract
     * @param User $user
     * @param ContractPartEntityInterface|null $part
     * @return mixed
     */
    public function getUserFillableContractVariable(
        ContractEntityInterface $contract,
        User $user,
        ?ContractPartEntityInterface $part = null,
        bool $empty_variables_only = false
    ) {
        $is_vendor = App::make(ContractRepositoryInterface::class)->isVendorAndPartyOf($user, $contract);

        if ($is_vendor && !$contract->getContractModel()->getShouldVendorsFillTheirVariables()) {
            return new Collection([]);
        }

        $contract_variables_query = ContractVariable::whereHas('contract', function ($q) use ($contract) {
            $q->where('id', $contract->getId());
        });
        if (!is_null($part)) {
            $contract_variables_query->whereHas('contractModelVariable', function ($query) use ($part) {
                $query->whereHas('contractModelPart', function ($query) use ($part) {
                    $query->whereHas('contractParts', function ($query) use ($part) {
                        $query->where('id', $part->getId());
                    });
                });
            });
        }

        if ($is_vendor) {
            $contract_variables_query->whereHas('contractParty', function ($q) use ($user) {
                $q->whereHas('enterprise', function ($q) use ($user) {
                    $q->where('id', $user->enterprise->id);
                });
            });
        }

        if ($empty_variables_only) {
            $contract_variables_query->whereNull('value');
        }

        return $contract_variables_query->orderBy('order')->get();
    }

    public function updateObjectValuesFromSystemVariables(
        ContractVariableEntityInterface $contract_variable,
        User $user
    ) {
        $input_type = $contract_variable->getContractModelVariable()->getInputType();

        if ($input_type ===  ContractModelVariableEntityInterface::INPUT_TYPE_CONTRACT_EXTERNAL_IDENTIFIER) {
            if ($this->userRepository->checkIfUserCanEditSystemVariableInitialValue(
                $user,
                $contract_variable->getContract()
            )) {
                $contract = $contract_variable->getContract();
                $contract->setExternalIdentifier($contract_variable->getValue());
                App::make(ContractRepository::class)->save($contract);
            }
        }
    }
}
