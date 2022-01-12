<div class="col-12 pl text-{{ $position ?? 'right' }}">
    <a class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#add-comment">
        <i class="fa fa-plus"></i> {{ __('addworking.common.comment._create.add_comment') }}
    </a>
    <hr>
</div>

@component('components.form.modal', ['id' => 'add-comment', 'action' => route('comment.store')])
    @slot('title')
        {{ __('addworking.common.comment._create.add_comment') }}
    @endslot

    @if (auth()->check())
        <input type="hidden" name="comment[commentable_id]" value="{{ $item->id }}">
        <input type="hidden" name="comment[commentable_type]" value="{{ snake_case(class_basename($item)) }}">
    @endif

    @form_group([
        'text'     => __('addworking.common.comment._create.comment'),
        'type'     => "textarea",
        'name'     => "comment.content",
        'required' => true,
        'rows'     => 10
    ])

    @form_group([
        'text'     => __('addworking.common.comment._create.visibility'),
        'type'     => "select",
        'name'     => "comment.visibility",
        'options'  => array_trans(array_mirror(comment()::getAvailableVisibilities()), 'messages.comment.visibility.'),
        'value'    => comment()::VISIBILITY_PUBLIC,
        'required' => true,
        'help'     => __('addworking.common.comment._create.help_text'),
        'id'       => 'select-comment-visibility',
    ])

    @if (in_array(snake_case(class_basename($item)), config('commentable.notified')))
        <div id="div-users-to-notify">
            @form_group([
                'text'         => __('addworking.common.comment._create.users_to_notify'),
                'type'         => "select",
                'name'         => "comment.users_to_notify.",
                'selectpicker' => true,
                'multiple'     => true,
                'search'       => true,
                'id'           => 'comment-users-to-notify'
            ])
        </div>
    @endif
@endcomponent

@if (in_array(snake_case(class_basename($item)), config('commentable.notified')))
    @push('scripts')
        <script>
            $(function () {
                var contract_id = "{{$item->id}}";
                var visibility = $('#select-comment-visibility').find(":selected").val();

                var setUsersToNotifyOptions = function (contract_id, visibility,) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ route('comment.get_users_to_notify') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            contract_id: contract_id,
                            visibility: visibility,
                        },
                        beforeSend: function () {
                            $.each($("select[id='comment-users-to-notify']"), function() {
                                $("#" + $(this).attr('id') + " option").remove();
                            })
                        },
                        success: function (response) {
                            $.each(response.data, function(id, name) {
                                $("#comment-users-to-notify").append('<option value="'+id+'">'+name+'</option>');
                            });
                            $("#comment-users-to-notify").selectpicker("refresh");
                        }
                    })
                }

                if (visibility === "{{comment()::VISIBILITY_PRIVATE}}") {
                    $("#div-users-to-notify").hide('slow');
                }

                setUsersToNotifyOptions(contract_id, visibility);

                $('#select-comment-visibility').on('change', function (e) {
                    var visibility = this.value;

                    if (visibility === "{{comment()::VISIBILITY_PRIVATE}}") {
                        $("#div-users-to-notify").hide('slow');
                    }
                    if (visibility === "{{comment()::VISIBILITY_PROTECTED}}" || visibility === "{{comment()::VISIBILITY_PUBLIC}}") {
                        $("#div-users-to-notify").show('slow');
                    }

                    setUsersToNotifyOptions(contract_id, visibility);
                });
            })
        </script>
    @endpush
@endif
