@pushonce('scripts:lazy_loading_actions')
    <script>
    if (typeof activateLazyLoading === "undefined") {
        var activateLazyLoading = function () {
            $('button.object-action-button').click(function () {
                var this_button = $(this);
                if (this_button.attr('data-action_lazy_loading_activated') === "1") {
                    return;
                }
                var action_path = this_button.attr('data-action_path');
                var action_objects = this_button.attr('data-action_objects');
                var dropdown = this_button.parent().find('div.dropdown-menu');
                if (action_path !== '') {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ route('common.lazy_loading.load_action_html') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "action_path": action_path,
                            "action_objects": action_objects,
                        },
                        success: function(response) {
                            if (this_button.attr('data-action_lazy_loading_activated') !== "1") {
                                dropdown.append(dropdown.html()+response.data.action_html);
                                this_button.attr('data-action_lazy_loading_activated', 1);
                            }
                        },
                    });
                }
            });
        };
        activateLazyLoading();
    }
</script>
@endpushonce

@component('foundation::layout.app._actions', ['action_path' => $action_path, 'action_objects' => $action_objects])
@endcomponent