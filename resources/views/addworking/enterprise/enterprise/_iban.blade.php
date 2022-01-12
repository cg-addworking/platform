@can('show', $enterprise->iban)
    {{ $enterprise->iban->iban ?? 'n/a' }} @if ($enterprise->iban->bic) (BIC: {{ $enterprise->iban->bic }}) @endif
@else
    <span class="text-danger">{{ __('addworking.enterprise.enterprise._iban.cannot_see_company_iban') }}</span>
@endcan
