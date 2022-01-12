<?php

namespace Components\Enterprise\AccountingExpense\Application\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccouontingExpenseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'accounting_expense.display_name' => "required|max:255",
            'accounting_expense.analytical_code' => "nullable|max:255",
        ];
    }
}
