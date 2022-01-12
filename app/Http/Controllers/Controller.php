<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $views;

    protected $redirects;

    public function redirectWhen(
        $condition,
        string $to,
        string $success = null,
        string $error = null,
        array $cta = []
    ): RedirectResponse {
        $redirector = App::make(Redirector::class);

        return $condition
            ? $redirector->to(Request::input('return-to', $to))->with($this->successStatus($success, $cta))
            : $redirector->back()->with($this->errorStatus($error, $cta));
    }

    public function success(string $message = null, array $cta = []): self
    {
        Session::flash('status', $this->successStatus($message)['status']);

        if (!empty($cta)) {
            Session::flash('cta.icon', isset($cta['icon']) ? $cta['icon'] : '');
            Session::flash('cta.href', isset($cta['href']) ? $cta['href'] : '#');
            Session::flash('cta.text', isset($cta['text']) ? $cta['text'] : '');
        }

        return $this;
    }

    public function info(string $message = null): self
    {
        Session::flash('status', $this->infoStatus($message)['status']);

        return $this;
    }

    public function warning(string $message = null, array $cta = []): self
    {
        Session::flash('status', $this->warningStatus($message)['status']);

        if (!empty($cta)) {
            Session::flash('cta.icon', isset($cta['icon']) ? $cta['icon'] : '');
            Session::flash('cta.href', isset($cta['href']) ? $cta['href'] : '#');
            Session::flash('cta.text', isset($cta['text']) ? $cta['text'] : '');
        }

        return $this;
    }

    public function error(string $message = null): self
    {
        Session::flash('status', $this->errorStatus($message)['status']);

        return $this;
    }

    public function successStatus(string $message = null, array $cta = []): array
    {
        return [
            'status' => [
                'class'   => "success",
                'message' => $message ?? __("messages.success"),
            ],
            'cta' => [
                'icon' => isset($cta['icon']) ? $cta['icon'] : '',
                'href' => isset($cta['href']) ? $cta['href'] : '#',
                'text' => isset($cta['text']) ? $cta['text'] : '',
            ],
        ];
    }

    public function infoStatus(string $message): array
    {
        return [
            'status' => [
                'class'   => "info",
                'message' => $message,
            ]
        ];
    }

    public function warningStatus(string $message, array $cta = []): array
    {
        return [
            'status' => [
                'class'   => "warning",
                'message' => $message,
            ],
            'cta' => [
                'icon' => isset($cta['icon']) ? $cta['icon'] : '',
                'href' => isset($cta['href']) ? $cta['href'] : '#',
                'text' => isset($cta['text']) ? $cta['text'] : '',
            ],
        ];
    }

    public function errorStatus(string $message = null, array $cta = []): array
    {
        return [
            'status' => [
                'class'   => "danger",
                'message' => $message ?? __("messages.error"),
            ],
            'cta' => [
                'icon' => isset($cta['icon']) ? $cta['icon'] : '',
                'href' => isset($cta['href']) ? $cta['href'] : '#',
                'text' => isset($cta['text']) ? $cta['text'] : '',
            ],
        ];
    }
}
