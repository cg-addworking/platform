<?php

namespace App\Repositories\Sogetrel\User;

use App\Models\Addworking\User\User;
use App\Models\Sogetrel\User\Passwork;
use App\Notifications\Sogetrel\User\Passwork\PasswordSharingReportNotification;
use App\Notifications\Sogetrel\User\Passwork\SharePassworkNotification;
use App\Repositories\Addworking\Common\CommentRepository;
use App\Repositories\Addworking\User\UserRepository;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;

class PassworkRepository extends BaseRepository
{
    protected $commentRepository;
    protected $userRepository;

    public function __construct(CommentRepository $comment_repository, UserRepository $user_repository)
    {
        $this->commentRepository = $comment_repository;
        $this->userRepository = $user_repository;
    }

    public function share(Request $request, Passwork $passwork)
    {
        foreach ($request->input('users') as $id) {
            Notification::send($this->userRepository->find($id), new SharePassworkNotification(
                $request->user(),
                $this->userRepository->find($id),
                $passwork,
                $request->comment
            ));

            $this->sendPassworkSharingNotificationReport($request, $passwork, $id);
            $this->sendPassworkSharingCommentReport($request, $passwork, $id);
        }
    }

    public function sendPassworkSharingNotificationReport(Request $request, Passwork $passwork, string $id)
    {
        $notification = new PasswordSharingReportNotification(
            $request->user(),
            $this->userRepository->find($id),
            $passwork,
            $request->comment
        );

        if ($request->passwork_sharing_report == "on") {
            $recipients = $request->user();

            Notification::send($recipients, $notification);
        }
    }

    public function sendPassworkSharingCommentReport(Request $request, Passwork $passwork, string $id)
    {
        $recipient = $this->userRepository->find($id);
        $user      = $request->user();
        $comment   = "Ce passwork a été partagé auprès de {$recipient->name}".
            " par {$user->name}".
            " avec comme remarque : {$request->comment}";

        $this->commentRepository->comment($passwork, $comment, 'public', $user);
    }
}
