<?php

namespace App\Http\Controllers\Addworking\Enterprise;

use App\Events\UserRegistration;
use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\Enterprise\Member\StoreEnterpriseMemberInvitationRequest;
use App\Http\Requests\Addworking\Enterprise\Member\ValidateInvitationMemberRequest;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Invitation;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\EnterpriseMemberRepository;
use App\Repositories\Addworking\Enterprise\EnterpriseRepository;
use App\Repositories\Addworking\Enterprise\InvitationRepository;
use App\Repositories\Addworking\User\OnboardingProcessRepository;
use App\Repositories\Addworking\User\UserRepository;
use App\Support\Token\InvitationTokenManager;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EnterpriseMemberInvitationController extends Controller
{
    protected $repository;
    protected $userRepository;
    protected $enterpriseMemberRepository;
    protected $manager;
    protected $enterpriseRepository;
    protected $onboardingProcessRepository;

    public function __construct(
        InvitationRepository $repository,
        UserRepository $userRepository,
        EnterpriseRepository $enterpriseRepository,
        EnterpriseMemberRepository $enterpriseMemberRepository,
        InvitationTokenManager $manager,
        OnboardingProcessRepository $onboardingProcessRepository
    ) {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->enterpriseMemberRepository = $enterpriseMemberRepository;
        $this->onboardingProcessRepository = $onboardingProcessRepository;
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('inviteMember', $enterprise);

        return view('addworking.enterprise.member.invitation.create', [
            'enterprise' => $enterprise,
            'user' => factory(User::class)->make()
        ]);
    }

    public function store(Enterprise $enterprise, StoreEnterpriseMemberInvitationRequest $request)
    {
        $this->authorize('inviteMember', $enterprise);

        $this->repository->sendInvitation(
            $this->repository->createInvitation(
                [
                    'type' => Invitation::TYPE_MEMBER,
                    'contact' => $request->input('email'),
                    'contact_name' => 'n/a',
                    'contact_enterprise_name' => 'n/a',
                    'additional_data' => $request->input('member')
                ],
                $enterprise
            )
        );

        return redirect(route('addworking.enterprise.invitation.index', compact('enterprise')));
    }

    public function review(Request $request)
    {
        if (($token = $this->decodeToken($request)) === null) {
            return redirect(route('dashboard'));
        }

        $this->repository->find($token->invitation_id)->markAs(Invitation::STATUS_IN_PROGRESS)->save();

        return view('addworking.enterprise.member.invitation.review', [
            'token' => $request->get('token'),
            'guest' => User::where('email', $token->email)->firstOrNew(['email' => $token->email]),
            'enterprise' => $this->enterpriseRepository->find($token->host_id),
            'job_title' => $token->member->job_title ?? null,
        ]);
    }

    public function accept(ValidateInvitationMemberRequest $request)
    {
        if (($token = $this->decodeToken($request)) === null) {
            return redirect(route('dashboard'));
        }

        $guest_enterprise = $this->enterpriseRepository->find($token->host_id);

        if ($request->get('user')) {
            $guest = $this->userRepository->createFromRequest($request);
            Auth::login($guest);
            event(new UserRegistration($guest));
        } else {
            $guest = User::fromEmail($token->email);
        }

        $this->repository->validateInvitation(
            $this->repository->find($token->invitation_id),
            $guest,
            $guest_enterprise
        );

        $request['member'] = ['id' => $guest->id, 'job_title' => $request->get('job_title')] + (array)$token->member;
        $this->enterpriseMemberRepository->createFromRequest($request, $guest_enterprise);
        $this->onboardingProcessRepository->completeFromInvitation($guest);
        $this->enterpriseMemberRepository->storeAccessesFromInvitation($guest_enterprise, $guest);

        return redirect(route('dashboard'));
    }

    private function decodeToken(Request $request)
    {
        try {
            return $this->manager->decode($request->get('token', ''));
        } catch (\Exception $e) {
            Log::debug($e->getMessage(), ['token' => $request->get('token', '')]);
            return null;
        }
    }
}
