<?php

namespace Components\Enterprise\AccountingExpense\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\AccountingExpense\Application\Models\AccountingExpense;
use Components\Enterprise\AccountingExpense\Application\Presenters\AccountingExpenseListPresenter;
use Components\Enterprise\AccountingExpense\Application\Repositories\AccountingExpenseRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\UserRepository;
use Components\Enterprise\AccountingExpense\Application\Requests\StoreAccountingExpenseRequest;
use Components\Enterprise\AccountingExpense\Application\Requests\UpdateAccouontingExpenseRequest;
use Components\Enterprise\AccountingExpense\Domain\UseCases\CreateAccountingExpense;
use Components\Enterprise\AccountingExpense\Domain\UseCases\DeleteAccountingExpense;
use Components\Enterprise\AccountingExpense\Domain\UseCases\EditAccountingExpense;
use Components\Enterprise\AccountingExpense\Domain\UseCases\ListAccountingExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AccountingExpenseController extends Controller
{
    protected $accountingExpenseRepository;
    protected $userRepository;

    public function __construct(
        AccountingExpenseRepository $accountingExpenseRepository,
        UserRepository $userRepository
    ) {
        $this->accountingExpenseRepository = $accountingExpenseRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Enterprise $enterprise, Request $request)
    {
        $this->authorize('index', [AccountingExpense::class, $enterprise]);

        $presenter = new AccountingExpenseListPresenter;
        $authenticated = $this->userRepository->connectedUser();

        $searchable_attributes = $this->accountingExpenseRepository->getSearchableAttributes();

        $items = App::make(ListAccountingExpense::class)->handle(
            $presenter,
            $authenticated,
            $enterprise,
            $request->input('filter'),
            $request->input('search'),
            $request->input('per-page'),
            $request->input('operator'),
            $request->input('field'),
        );

        return view(
            'accounting_expense::accounting_expense.index',
            compact('items', 'enterprise', 'searchable_attributes')
        );
    }

    public function create(Enterprise $enterprise)
    {
        $this->authorize('create', [AccountingExpense::class, $enterprise]);

        $accounting_expense = $this->accountingExpenseRepository->make();

        return view(
            'accounting_expense::accounting_expense.create',
            compact('accounting_expense', 'enterprise')
        );
    }

    public function store(Enterprise $enterprise, StoreAccountingExpenseRequest $request)
    {
        $this->authorize('create', [AccountingExpense::class, $enterprise]);

        $authenticated = $this->userRepository->connectedUser();

        $accounting_expense = App::make(CreateAccountingExpense::class)->handle(
            $authenticated,
            $enterprise,
            $request->input('accounting_expense')
        );

        return $this->redirectWhen(
            $accounting_expense->exists,
            route('addworking.enterprise.accounting_expense.index', $enterprise)
        );
    }

    public function edit(Enterprise $enterprise, AccountingExpense $accounting_expense)
    {
        $this->authorize('edit', [$accounting_expense, $enterprise]);

        return view('accounting_expense::accounting_expense.edit', compact('accounting_expense', 'enterprise'));
    }

    public function update(
        Enterprise $enterprise,
        AccountingExpense $accounting_expense,
        UpdateAccouontingExpenseRequest $request
    ) {
        $this->authorize('edit', [$enterprise, $accounting_expense]);

        $authenticated = $this->userRepository->connectedUser();

        $accounting_expense = App::make(EditAccountingExpense::class)->handle(
            $authenticated,
            $enterprise,
            $accounting_expense,
            $request->input('accounting_expense')
        );

        return $this->redirectWhen(
            $accounting_expense->exists,
            route('addworking.enterprise.accounting_expense.index', $enterprise)
        );
    }

    public function delete(Enterprise $enterprise, AccountingExpense $accounting_expense)
    {
        $this->authorize('delete', [$accounting_expense, $enterprise]);

        $deleted = App::make(DeleteAccountingExpense::class)->handle(
            $this->userRepository->connectedUser(),
            $enterprise,
            $accounting_expense
        );

        return $this->redirectWhen(
            $deleted,
            route('addworking.enterprise.accounting_expense.index', $enterprise)
        );
    }
}
