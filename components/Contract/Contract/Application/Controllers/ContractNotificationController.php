<?php

namespace Components\Contract\Contract\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Common\Common\Application\Helpers\ActionTrackingHelper;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Notifications\RequestValidationNotification;
use Components\Contract\Contract\Application\Repositories\ContractNotificationRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\UseCases\SendNotificationRequestDocuments;
use Components\Contract\Contract\Domain\UseCases\SendNotificationToRequestContractVariableValue;
use Components\Contract\Contract\Domain\UseCases\SendNotificationToSignContract;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;

class ContractNotificationController extends Controller
{
    private $contractRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $contractPartyRepository;
    private $contractNotificationRepository;
    private $contractModelRepository;
    private $contractVariableRepository;

    public function __construct(
        ContractRepository $contractRepository,
        EnterpriseRepository $enterpriseRepository,
        UserRepository $userRepository,
        ContractPartyRepository $contractPartyRepository,
        ContractNotificationRepository $contractNotificationRepository,
        ContractModelRepository $contractModelRepository,
        ContractVariableRepository $contractVariableRepository
    ) {
        $this->contractRepository = $contractRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->userRepository = $userRepository;
        $this->contractPartyRepository = $contractPartyRepository;
        $this->contractNotificationRepository = $contractNotificationRepository;
        $this->contractModelRepository = $contractModelRepository;
        $this->contractVariableRepository = $contractVariableRepository;
    }

    public function requestSignature(Contract $contract)
    {
        $this->authorize('requestSignature', $contract);
        $sended = App::make(SendNotificationToSignContract::class)
            ->handle(
                $this->userRepository->connectedUser(),
                $contract,
                $this->contractPartyRepository->getNextPartyThatShouldSign($contract),
                true
            );

        return $this->redirectWhen($sended, route('contract.show', $contract));
    }

    public function requestValidation(Contract $contract)
    {
        $this->authorize('requestValidation', $contract);

        $users = $this->userRepository->getUsersAllowedToSendContractToSignature($contract);

        if (!count($users)) {
            return redirect()->route('contract.show', $contract)->with(error_status());
        } elseif (count($users) === 1) {
            $this->sendRequestValidationEmail($contract, $users->first());
            return redirect()->route('contract.show', $contract)->with(success_status(
                __('components.contract.contract.application.views.contract.request_validation.success')
            ));
        }

        return view(
            'contract::contract.request_validation',
            compact('contract', 'users')
        );
    }

    public function postRequestValidation(Request $request, Contract $contract)
    {
        $this->authorize('requestValidation', $contract);

        $user = $this->userRepository->find($request->input('user'));

        if (!isset($user)) {
            return redirect()->back()->with(error_status());
        }

        $this->sendRequestValidationEmail($contract, $user);
        return redirect()->route('contract.show', $contract)->with(success_status(
            __('components.contract.contract.application.views.contract.request_validation.success')
        ));
    }

    private function sendRequestValidationEmail(Contract $contract, User $user)
    {
        Notification::send(
            $user,
            new RequestValidationNotification(
                $contract
            )
        );

        ActionTrackingHelper::track(
            $this->userRepository->connectedUser(),
            ActionEntityInterface::REQUEST_SEND_CONTRACT_TO_SIGNATURE,
            $contract,
            __(
                'components.contract.contract.application.tracking.request_send_contract_to_signature',
                ['user' => $user]
            )
        );
    }

    public function requestDocuments(Contract $contract)
    {
        $this->authorize('requestDocuments', $contract);

        $sended = App::make(SendNotificationRequestDocuments::class)
            ->handle($this->userRepository->connectedUser(), $contract);

        return $this->redirectWhen($sended, route('contract.show', $contract));
    }

    public function sendToManager(Contract $contract)
    {
        $this->authorize('sendToManager', $contract);

        $users = $this->userRepository->getUsersAllowedToSendContractToSignature($contract);

        if (count($users) === 1) {
            $this->sendRequestValidationEmail($contract, $users->first());
            return redirect()->route('contract.show', $contract)->with(success_status(
                __('components.contract.contract.application.views.contract.request_validation.success')
            ));
        }

        return view(
            'contract::contract.request_validation',
            compact('contract', 'users')
        );
    }

    public function requestContractVariableValue(Request $request, Contract $contract)
    {
        if ($request->ajax()) {
            $request->validate([
                'user_id' => 'required|uuid|exists:addworking_user_users,id',
                'url' => 'required',
            ]);

            $this->authorize('requestContractVariableValue', $contract);

            $url = $request->input('url');
            $user_to_request = $this->userRepository->find($request->input('user_id'));

            App::make(SendNotificationToRequestContractVariableValue::class)
                ->handle($this->userRepository->connectedUser(), $contract, $url, $user_to_request);

            $parsed_url = parse_url($url);
            parse_str($parsed_url['query'], $parsed_url_query);
            $requested_contract_variables = explode(',', $parsed_url_query['requested-contract-variables']);

            foreach ($requested_contract_variables as $requested_contract_variable_id) {
                $contract_variable = $this->contractVariableRepository->find($requested_contract_variable_id);
                $contract_variable->setValueRequestedTo($user_to_request);
                $contract_variable->setValueRequestedAt(Carbon::now());
                $contract_variable->save();
            }

            $response = [
                'status' => 200,
            ];

            return response()->json($response);
        }

        abort(501);
    }
}
