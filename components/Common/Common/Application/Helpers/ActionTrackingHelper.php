<?php

namespace Components\Common\Common\Application\Helpers;

use App\Models\Addworking\User\User;
use Components\Common\Common\Application\Models\Action;
use Components\Common\Common\Application\Models\ActionType;
use Components\Common\Common\Domain\Exceptions\ActionIsNotRegisteredException;
use Components\Common\Common\Domain\Exceptions\ActionShouldBeSavedToDatabaseException;
use Components\Common\Common\Domain\Exceptions\EntityIsMissingActionRelationshipException;
use Components\Common\Common\Domain\Interfaces\ActionEntityInterface;
use Components\Common\Common\Domain\Interfaces\ActionRepositoryInterface;
use Components\Common\Common\Domain\Interfaces\ActionTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ActionTrackingHelper
{
    public static function track(?User $user, string $action_name, Model $model, $message = ""): void
    {
        if (!in_array($action_name, ActionEntityInterface::AVAILABLE_ACTION_NAMES)) {
            // All $action_name needs to be added in the ActionEntityInterface and in the ActionType table
            throw new ActionIsNotRegisteredException();
        }

        if (!method_exists($model, 'actions')) {
            // All $model needs to have a relationship called 'actions' with the Action table
            throw new EntityIsMissingActionRelationshipException();
        }

        /* @var Action $action */
        $action = App::make(ActionRepositoryInterface::class)->make();
        $action->setUser($user);
        $action->setMessage($message);
        $action->setModel($model);
        $action->setName($action_name);
        $action->setDisplayName(str_replace('_', ' ', ucfirst($action_name)));
        $action->save();
    }
}
