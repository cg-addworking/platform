<?php

namespace App\Repositories\Addworking\Enterprise;

use App\Contracts\Models\Repository;
use App\Mail\IbanValidation;
use App\Models\Addworking\Common\Concerns\File\HasAttachments;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use App\Repositories\Addworking\Common\FileRepository;
use App\Repositories\Addworking\User\UserRepository;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use UnexpectedValueException;

class IbanRepository extends BaseRepository
{
    protected $model = Iban::class;

    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function createFromRequest(Request $request, Enterprise $enterprise): Iban
    {
        return DB::transaction(function () use ($request, $enterprise) {
            if ($enterprise->iban->attachments->count() > 0) {
                $enterprise->iban->attachments->first->delete();
            }

            $iban = $this->make([
                'status'           => Iban::STATUS_PENDING,
                'validation_token' => str_random(40)
            ] + $request->input('iban'));

            $iban->enterprise()->associate($request->input('enterprise.id'))->save();

            if ($request->has('file.content')) {
                $iban->attach($request->file('file.content'));
            }

            $this->sendValidationEmail($iban);

            return $iban;
        });
    }

    public function sendValidationEmail($iban, $users = null)
    {
        foreach (array_wrap($users) ?: $iban->enterprise->legalRepresentatives as $user) {
            $mail = new IbanValidation($user, $iban);

            if ($user->can('receive', $mail)) {
                $user->update([
                    'iban_validation_token' => $iban->validation_token
                ]);

                Mail::to($user)->send($mail);
            }
        }
    }

    protected function validateIbanUserToken($iban, $user): array
    {
        $iban = $this->find($iban);
        $user = $this->user->find($user);

        if ($iban->validation_token != $user->iban_validation_token) {
            throw new UnexpectedValueException("token mismatch");
        }

        return [$iban, $user];
    }

    public function confirm($iban, $user): bool
    {
        list($iban, $user) = $this->validateIbanUserToken($iban, $user);

        return DB::transaction(function () use ($iban, $user) {
            // tag all other ibans as expired...
            $iban->enterprise->ibans()->update([
                'status' => Iban::STATUS_EXPIRED,
            ]);

            // ...and mark current one as approved
            $iban->update([
                'status'           => Iban::STATUS_APPROVED,
                'validation_token' => null,
            ]);

            // release user's token
            $user->update([
                'iban_validation_token' => null,
            ]);

            return true;
        });
    }

    public function cancel($iban, $user): bool
    {
        list($iban, $user) = $this->validateIbanUserToken($iban, $user);

        return DB::transaction(function () use ($iban, $user) {
            // dismiss pending iban...
            $iban->update([
                'status'           => Iban::STATUS_EXPIRED,
                'validation_token' => null,
            ]);

            // ...and delete it.
            $iban->delete();

            // release user's token
            $user->update([
                'iban_validation_token' => null,
            ]);

            return true;
        });
    }
}
