<?php

namespace App\Models\Addworking\User\OnboardingProcess;

use App\Contracts\Addworking\User\OnboardingProcess\Step as StepContract;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\OnboardingProcess;
use App\Models\Addworking\User\User;

abstract class Step implements StepContract
{
    /**
     * @var OnboardingProcess
     */
    protected $process;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var string
     */
    protected $description = "";

    /**
     * @var string
     */
    protected $message = "";

    /**
     * @var string
     */
    protected $callToAction = "";

    /**
     * @var string
     */
    protected $action = "";

    /**
     * Constructor.
     *
     * @param OnboardingProcess $process
     */
    public function __construct(OnboardingProcess $process)
    {
        $this->process = $process;
    }

    /**
     * get step name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name ?? snake_case(class_basename($this));
    }

    /**
     * Get step display name
     *
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName ?? class_basename($this);
    }

    /**
     * @inheritdoc
     */
    public function process(): OnboardingProcess
    {
        return $this->process;
    }

    /**
     * @inheritdoc
     */
    public function user(): User
    {
        return $this->process->user;
    }

    /**
     * @inheritdoc
     */
    public function enterprise(): Enterprise
    {
        return $this->process->enterprise;
    }

    /**
     * @inheritdoc
     */
    public function fails(): bool
    {
        return !$this->passes();
    }

    /**
     * @inheritdoc
     */
    public function description(): string
    {
        return __($this->description);
    }

    /**
     * @inheritdoc
     */
    public function message(): string
    {
        return __($this->message);
    }


    /**
     * @inheritdoc
     */
    public function callToAction(): string
    {
        return __($this->callToAction);
    }

    /**
     * @inheritdoc
     */
    public function action(): string
    {
        return __($this->action);
    }
}
