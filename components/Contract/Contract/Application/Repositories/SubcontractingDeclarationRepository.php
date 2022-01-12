<?php

namespace Components\Contract\Contract\Application\Repositories;

use App\Models\Addworking\Common\File;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\SubcontractingDeclaration;
use Components\Contract\Contract\Domain\Exceptions\SubcontractingDeclarationCreationFailedException;
use Components\Contract\Contract\Domain\Interfaces\Repositories\SubcontractingDeclarationRepositoryInterface;

class SubcontractingDeclarationRepository implements SubcontractingDeclarationRepositoryInterface
{
    public function make(): SubcontractingDeclaration
    {
        return new SubcontractingDeclaration;
    }

    public function save(SubcontractingDeclaration $declaration)
    {
        try {
            $declaration->save();
        } catch (SubcontractingDeclarationCreationFailedException $exception) {
            throw $exception;
        }

        $declaration->refresh();

        return $declaration;
    }

    public function getSubcontractingDeclarationOf(Contract $contract)
    {
        return SubcontractingDeclaration::whereHas('contract', function ($query) use ($contract) {
            $query->has('captureInvoices')->where('id', $contract->getId());
        })->first();
    }

    public function delete(SubcontractingDeclaration $declaration)
    {
        return $declaration->delete();
    }

    public function createFile($content)
    {
        $file = File::from($content)
            ->fill(['mime_type' => "application/pdf"])
            ->name("/dc4_%uniq%.pdf")
            ->saveAndGet();

        unset($content);
        return $file;
    }
}
