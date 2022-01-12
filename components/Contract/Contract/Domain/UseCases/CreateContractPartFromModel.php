<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\ContractModelPartIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\ContractPartyMissingException;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseDoesntHavePartnershipWithContractException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractVariableRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;
use Components\Infrastructure\PdfManager\Domain\Classes\PdfManagerInterface;
use Illuminate\Support\Facades\App;
use Components\Contract\Model\Application\Repositories\ContractModelVariableRepository;
use Carbon\Carbon;
use setasign\Fpdi\Fpdi;
use Carbon\Exceptions\InvalidFormatException;

class CreateContractPartFromModel
{
    protected $userRepository;
    protected $contractPartRepository;
    protected $contractRepository;
    protected $contractVariableRepository;
    protected $pdfManager;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ContractPartRepositoryInterface $contractPartRepository,
        ContractRepositoryInterface $contractRepository,
        ContractVariableRepositoryInterface $contractVariableRepository,
        PdfManagerInterface $pdfManager
    ) {
        $this->userRepository = $userRepository;
        $this->contractPartRepository = $contractPartRepository;
        $this->contractRepository = $contractRepository;
        $this->contractVariableRepository = $contractVariableRepository;
        $this->pdfManager = $pdfManager;
    }

    public function handle(
        ?User $auth_user,
        ?ContractEntityInterface $contract,
        ?ContractModelPartEntityInterface $contract_model_part
    ) {
        $this->checkUser($auth_user);
        $this->checkContract($contract, $auth_user);

        if ($contract->getContractModel()) {
            $this->checkContractModelPart($contract_model_part);
        }

        if ($contract_model_part->getShouldCompile()) {
            $file = $this->createFileFromHtml($contract, $contract_model_part);
        } else {
            $file = $contract_model_part->getFile();
        }

        $contract_part = $this->contractPartRepository->make();
        $contract_part->setContract($contract);
        $contract_part->setOrder($contract_model_part->getOrder());
        $contract_part->setContractModelPart($contract_model_part);
        $contract_part->setName($contract_model_part->getDisplayName());
        $contract_part->setDisplayName($contract_model_part->getDisplayName());
        $contract_part->setNumber();
        $contract_part->setSignatureMention($contract_model_part->getSignatureMention());
        $contract_part->setIsSigned($contract_model_part->getIsSigned());
        $contract_part->setFile($file);

        $contract_part = $this->setSignPage($contract_part, $contract_model_part, $file);

        return $this->contractPartRepository->save($contract_part);
    }

    private function setSignPage($contract_part, $contract_model_part, $file)
    {
        $contract_part->setSignOnLastPage($contract_model_part->getSignOnLastPage());
        if ($contract_model_part->getSignOnLastPage()) {
            $page = $this->getLastPage($file);
            $contract_part->setSignaturePage($page);
        } else {
            $contract_part->setSignaturePage($contract_model_part->getSignaturePage());
        }
        return $contract_part;
    }

    private function checkUser($auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException;
        }
    }

    private function checkContract($contract, $auth_user)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException;
        }

        if (count($this->contractRepository->getSignatoryParties($contract)) < 2) {
            throw new ContractPartyMissingException;
        }

        if ($this->userRepository->isSupport($auth_user)) {
            return true;
        }

        if (!$this->contractRepository->isPartyOf($auth_user, $contract)
            && !$this->contractRepository->isOwnerOf($auth_user, $contract)) {
            throw new EnterpriseDoesntHavePartnershipWithContractException;
        }
    }

    private function checkContractModelPart($contract_model_part)
    {
        if (is_null($contract_model_part)) {
            throw new ContractModelPartIsNotFoundException;
        }
    }

    private function createFileFromHtml($contract, $contract_model_part)
    {
        $contract_variables = $this->contractVariableRepository->getContractVariablesByModelPart(
            $contract,
            $contract_model_part
        );
        $html = $contract_model_part->getFile()->content;
        $variables_html = App::make(ContractModelVariableRepository::class)->findVariables($html);

        foreach ($variables_html as $variable_html) {
            $variable_html = explode('.', $variable_html);
            $variables_html_party_order = $variable_html[0];
            $variable_html_name = $variable_html[1];

            $variable_html_name_str = str_slug($variable_html_name, '_');
            $replace =  "{{" .$variables_html_party_order . "." .$variable_html_name  . "}}";
            $replace_with =  "{{" .$variables_html_party_order . "." .$variable_html_name_str  . "}}";
            $html = str_replace($replace, $replace_with, $html);

            unset($variable_html);
            gc_collect_cycles();
        }

        foreach ($contract_variables as $variable) {
            $var_name = "{{" . $variable->getContractParty()->getOrder() . "." .
                $variable->getContractModelVariable()->getName() . "}}";

            switch (true) {
                case ($this->contractVariableRepository->isLongText($variable)):
                    $value = $variable->getValueHtmlAttribute();
                    break;

                case ($this->contractVariableRepository->isDate($variable) && ! is_null($variable->getValue())):
                case ($this->contractVariableRepository->isDatetime($variable) && ! is_null($variable->getValue())):
                    try {
                        $value = Carbon::createFromFormat('Y-m-d', $variable->getValue())->format('d/m/Y');
                    } catch (InvalidFormatException $e) {
                        $value = $variable->getValue();
                    }
                    break;
                default:
                    $value = $variable->getValue();
            }

            $html = str_replace($var_name, $value, $html);

            unset($variable);
            gc_collect_cycles();
        }

        $pdf = $this->pdfManager->htmlToPdf(
            $html,
            "{$contract->getName()} - {$contract_model_part->getDisplayName()}"
        );

        unset($html);

        return $this->contractPartRepository->createFile($pdf->output());
    }

    private function getLastPage($file)
    {
        $temp = tmpfile();
        fwrite($temp, $file->content);
        $pdfPath = stream_get_meta_data($temp)['uri'];

        $pdf = new Fpdi();
        $page_count = $pdf->setSourceFile($pdfPath); // How many pages?
        unlink($pdfPath);
        unset($file);
        unset($pdf);
        fclose($temp);
        return $page_count;
    }
}
