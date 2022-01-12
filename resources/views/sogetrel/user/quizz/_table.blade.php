<table class="table table-striped">
    <thead>
        <tr>
            <th>{{ __('sogetrel.user.quizz._table.id') }}</th>
            <th>{{ __('sogetrel.user.quizz._table.status') }}</th>
            <th>{{ __('sogetrel.user.quizz._table.job') }}</th>
            <th>{{ __('sogetrel.user.quizz._table.level') }}</th>
            <th>{{ __('sogetrel.user.quizz._table.proposed_at') }}</th>
            <th>{{ __('sogetrel.user.quizz._table.completed_at') }}</th>
            <th class="text-right">{{ __('sogetrel.user.quizz._table.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($quizzes as $quizz)
            <tr>
                <td>@uuid($quizz->id)</td>
                <td>@include('sogetrel.user.passwork.quizz._status')</td>
                <td>{{ $quizz->job }}</td>
                <td>@include('sogetrel.user.passwork.quizz._level')</td>
                <td>@date($quizz->proposed_at)</td>
                <td>@date($quizz->completed_at)</td>
                <td class="text-right">{{ $quizz->actions }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
