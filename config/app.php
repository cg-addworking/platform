<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Addworking'),
    'icon' => 'img/logo_square.png',

    /*
    |--------------------------------------------------------------------------
    | Application Domains
    |--------------------------------------------------------------------------
    |
    | This value is the list of the domains handled by your application.
    |
    */

    'domains' => [
        'addworking',
        'edenred',
        'everial',
        'sogetrel',
        'spie',
        'support',
        'tse_express_medical',
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Themes
    |--------------------------------------------------------------------------
    |
    | This value is the list of the themes your application is structured around.
    |
    */

    'themes' => [
        'billing',
        'common',
        'contract',
        'enterprise',
        'mission',
        'user',
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'https://app.addworking.com'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'fr',
    'available_locales' => ['fr', 'en', 'de'],
    'faker_locale' => "fr_FR",

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'fr',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',


    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */
        Barryvdh\DomPDF\ServiceProvider::class,
        Lab404\Impersonate\ImpersonateServiceProvider::class,
        Conner\Tagging\Providers\TaggingServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\SigningHubServiceProvider::class,
        App\Providers\Addworking\Billing\BillingRouteServiceProvider::class,
        App\Providers\Addworking\Billing\BillingAuthServiceProvider::class,
        App\Providers\Addworking\Common\CommonAuthServiceProvider::class,
        App\Providers\Addworking\Common\CommonRouteServiceProvider::class,
        App\Providers\Addworking\Contract\ContractRouteServiceProvider::class,
        App\Providers\Addworking\Contract\ContractAuthServiceProvider::class,
        App\Providers\Addworking\Enterprise\EnterpriseRouteServiceProvider::class,
        App\Providers\Addworking\Mission\MissionAuthServiceProvider::class,
        App\Providers\Addworking\Mission\MissionRouteServiceProvider::class,
        App\Providers\Addworking\User\OnboardingProcessServiceProvider::class,
        App\Providers\Addworking\User\UserRouteServiceProvider::class,
        App\Providers\Addworking\User\UserServiceProvider::class,
        App\Providers\Edenred\Common\CommonAuthServiceProvider::class,
        App\Providers\Edenred\Common\CommonRouteServiceProvider::class,
        App\Providers\Edenred\Mission\MissionRouteServiceProvider::class,
        App\Providers\Everial\Mission\MissionRouteServiceProvider::class,
        App\Providers\Everial\Mission\MissionAuthServiceProvider::class,
        App\Providers\Sogetrel\Enterprise\EnterpriseRouteServiceProvider::class,
        App\Providers\Spie\Enterprise\EnterpriseRouteServiceProvider::class,
        App\Providers\Spie\Enterprise\EnterpriseAuthServiceProvider::class,
        App\Providers\Support\Mission\MissionRouteServiceProvider::class,
        App\Providers\Support\User\UserRouteServiceProvider::class,
        App\Providers\Support\Enterprise\EnterpriseRouteServiceProvider::class,
        App\Providers\Support\Enterprise\EnterpriseAuthServiceProvider::class,
        App\Providers\Support\Billing\BillingRouteServiceProvider::class,
        App\Providers\Soprema\Enterprise\EnterpriseRouteServiceProvider::class,
        App\Providers\Soprema\Enterprise\EnterpriseAuthServiceProvider::class,
        App\Providers\Soprema\Enterprise\EnterpriseAuthServiceProvider::class,

        /*
         * Components Service Providers...
         */
        Components\Billing\Inbound\Application\Providers\InboundInvoiceServiceProvider::class,
        Components\Billing\Inbound\Application\Providers\InboundInvoiceRouteServiceProvider::class,
        Components\Billing\Outbound\Application\Providers\OutboundInvoiceAuthServiceProvider::class,
        Components\Billing\Outbound\Application\Providers\OutboundInvoiceRouteServiceProvider::class,
        Components\Billing\Outbound\Application\Providers\OutboundInvoiceServiceProvider::class,
        Components\Billing\PaymentOrder\Application\Providers\PaymentOrderAuthServiceProvider::class,
        Components\Billing\PaymentOrder\Application\Providers\PaymentOrderRouteServiceProvider::class,
        Components\Billing\PaymentOrder\Application\Providers\PaymentOrderServiceProvider::class,
        Components\Common\Common\Application\Providers\CommonServiceProvider::class,
        Components\Connector\Airtable\Application\Providers\AirtableServiceProvider::class,
        Components\Contract\Contract\Application\Providers\ContractAuthServiceProvider::class,
        Components\Contract\Contract\Application\Providers\ContractRouteServiceProvider::class,
        Components\Contract\Contract\Application\Providers\ContractServiceProvider::class,
        Components\Contract\Model\Application\Providers\ContractModelAuthServiceProvider::class,
        Components\Contract\Model\Application\Providers\ContractModelRouteServiceProvider::class,
        Components\Contract\Model\Application\Providers\ContractModelServiceProvider::class,
        Components\Enterprise\AccountingExpense\Application\Providers\AccountingExpenseAuthServiceProvider::class,
        Components\Enterprise\AccountingExpense\Application\Providers\AccountingExpenseRouteServiceProvider::class,
        Components\Enterprise\AccountingExpense\Application\Providers\AccountingExpenseServiceProvider::class,
        Components\Enterprise\ActivityReport\Application\Providers\ActivityReportAuthServiceProvider::class,
        Components\Enterprise\ActivityReport\Application\Providers\ActivityReportRouteServiceProvider::class,
        Components\Enterprise\ActivityReport\Application\Providers\ActivityReportServiceProvider::class,
        Components\Enterprise\BusinessTurnover\Application\Providers\BusinessTurnoverAuthServiceProvider::class,
        Components\Enterprise\BusinessTurnover\Application\Providers\BusinessTurnoverRouteServiceProvider::class,
        Components\Enterprise\BusinessTurnover\Application\Providers\BusinessTurnoverServiceProvider::class,
        Components\Infrastructure\FileDataExtractor\Application\Providers\DocumentServiceProvider::class,
        Components\Enterprise\Enterprise\Application\Providers\EnterpriseRouteServiceProvider::class,
        Components\Enterprise\Enterprise\Application\Providers\EnterpriseServiceProvider::class,
        Components\Enterprise\Export\Application\Providers\ExportServiceProvider::class,
        Components\Enterprise\InvoiceParameter\Application\Providers\InvoiceParameterAuthServiceProvider::class,
        Components\Enterprise\InvoiceParameter\Application\Providers\InvoiceParameterRouteServiceProvider::class,
        Components\Enterprise\InvoiceParameter\Application\Providers\InvoiceParameterServiceProvider::class,
        Components\Enterprise\Resource\Application\Providers\ResourceAuthServiceProvider::class,
        Components\Enterprise\Resource\Application\Providers\ResourceRouteServiceProvider::class,
        Components\Enterprise\Resource\Application\Providers\ResourceServiceProvider::class,
        Components\Enterprise\WorkField\Application\Providers\WorkFieldAuthServiceProvider::class,
        Components\Enterprise\WorkField\Application\Providers\WorkFieldRouteServiceProvider::class,
        Components\Enterprise\WorkField\Application\Providers\WorkFieldServiceProvider::class,
        Components\Infrastructure\ElectronicSignature\Application\Providers\ElectronicSignatureServiceProvider::class,
        Components\Infrastructure\Export\Application\Providers\ExportAuthServiceProvider::class,
        Components\Infrastructure\Export\Application\Providers\ExportRouteServiceProvider::class,
        Components\Infrastructure\Export\Application\Providers\ExportServiceProvider::class,
        Components\Infrastructure\Foundation\Application\Providers\FoundationServiceProvider::class,
        Components\Infrastructure\Image\Application\Providers\ImageServiceProvider::class,
        Components\Infrastructure\Megatron\Application\Providers\MegatronServiceProvider::class,
        Components\Infrastructure\Pdf\Application\Providers\PdfServiceProvider::class,
        Components\Infrastructure\PdfManager\Application\Providers\PdfManagerServiceProvider::class,
        Components\Infrastructure\Text\Application\Providers\TextServiceProvider::class,
        Components\Infrastructure\Translation\Application\Providers\TranslationServiceProvider::class,
        Components\Mission\Offer\Application\Providers\OfferRouteServiceProvider::class,
        Components\Mission\Offer\Application\Providers\OfferServiceProvider::class,
        Components\Mission\Mission\Application\Providers\MissionAuthServiceProvider::class,
        Components\Mission\Mission\Application\Providers\MissionRouteServiceProvider::class,
        Components\Mission\Mission\Application\Providers\MissionServiceProvider::class,
        Components\Mission\TrackingLine\Application\Providers\TrackingLineRouteServiceProvider::class,
        Components\Mission\TrackingLine\Application\Providers\TrackingLineServiceProvider::class,
        Components\Module\Module\Application\Providers\ModuleServiceProvider::class,
        Components\Sogetrel\Mission\Application\Providers\MissionAuthServiceProvider::class,
        Components\Sogetrel\Mission\Application\Providers\MissionRouteServiceProvider::class,
        Components\Sogetrel\Mission\Application\Providers\MissionServiceProvider::class,
        Components\User\User\Application\Providers\UserServiceProvider::class,
        Components\Enterprise\Document\Application\Providers\DocumentRouteServiceProvider::class,
        Components\Enterprise\Document\Application\Providers\DocumentAuthServiceProvider::class,
        Components\Enterprise\Document\Application\Providers\DocumentServiceProvider::class,
        Components\Enterprise\DocumentTypeModel\Application\Providers\DocumentTypeModelRouteServiceProvider::class,
        Components\Enterprise\DocumentTypeModel\Application\Providers\DocumentTypeModelAuthServiceProvider::class,
        Components\Enterprise\DocumentTypeModel\Application\Providers\DocumentTypeModelServiceProvider::class,
        Components\Common\WYSIWYG\Application\Providers\WysiwygServiceProvider::class,
        Components\Infrastructure\LaravelBootstrap\Application\Providers\BootstrapServiceProvider::class,
        Components\Infrastructure\DatabaseCommands\Providers\DatabaseCommandsServiceProvider::class,
        Components\Sogetrel\Passwork\Application\Providers\PassworkAuthServiceProvider::class,
        Components\Sogetrel\Passwork\Application\Providers\PassworkRouteServiceProvider::class,
        Components\Sogetrel\Passwork\Application\Providers\PassworkServiceProvider::class,
        Components\Common\Common\Application\Providers\CommonRouteServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        /*
         * Laravel Framework Service Aliases...
         */
        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,

        /*
         * Custom Aliases...
         */
        'SigningHub' => App\Support\Facades\SigningHub::class,
        'TextExtractor' => Components\Infrastructure\Text\Application\Facades\TextExtractor::class,
        'ClassFinder' => Components\Infrastructure\DatabaseCommands\Helpers\ClassFinderFacade::class,
        'Models' => Components\Infrastructure\DatabaseCommands\Helpers\Models::class,

        /*
         * Package Aliases...
         */
        'PDF' => Barryvdh\DomPDF\Facade::class,
        'Markdown' => GrahamCampbell\Markdown\Facades\Markdown::class,
        'Repository' => App\Support\Facades\Repository::class,
        'ReCaptcha' => Biscolab\ReCaptcha\Facades\ReCaptcha::class,
        'Str' => Illuminate\Support\Str::class,
        'Arr' => Illuminate\Support\Arr::class,
    ],

];
