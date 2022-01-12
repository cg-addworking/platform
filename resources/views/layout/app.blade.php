@extends('bootstrap::blank')

@section('page')
    @include('_gtm_body')
    @include('foundation::layout._navbar')

    <div class="container-fluid">
        <div class="row">
            @includeWhen(empty($_no_sidebar), 'foundation::layout._sidebar')
            <main role="main" class="@if(empty($_no_sidebar)) col-md-9 ml-sm-auto col-lg-10 @else col-md-12 @endif px-4">
                @includeWhen(session('status'), 'foundation::layout._status')
                @yield('main')

                <footer class="text-center py-5">
                    © {{date('Y') }} Copyright: <a href="https://www.addworking.com/"> AddWorking</a>
                </footer>
            </main>
        </div>
    </div>
@endsection

@push('stylesheets')
    @include('_gtm_datalayer')
    @include('_gtm_head')
    <style>
    body {
        font-size: .875rem;
        overflow-y: scroll;
    }

    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100; /* Behind the navbar */
        padding: 48px 0 0; /* Height of navbar */
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    }

    .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: .5rem;
        overflow-x: hidden;
        overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
    }

    @supports ((position: -webkit-sticky) or (position: sticky)) {
        .sidebar-sticky {
            position: -webkit-sticky;
            position: sticky;
        }
    }

    .sidebar .nav-link {
        font-weight: 500;
        color: #333;
    }

    .sidebar .nav-link .feather {
        margin-right: 4px;
        color: #999;
    }

    .sidebar .nav-link.active {
        color: #007bff;
    }

    .sidebar .nav-link:hover .feather,
    .sidebar .nav-link.active .feather {
        color: inherit;
    }

    .sidebar-heading {
        font-size: .75rem;
        text-transform: uppercase;
    }

    /*
     * Content
     */

    [role="main"] {
        padding-top: 72px; /* Space for fixed navbar */
    }

    @media (max-width: 768px) {
        [role="main"] {
            padding-top: 16px; /* Space for fixed navbar */
        }
    }

    /*
     * Navbar
     */

    .navbar-brand {
        padding-top: .75rem;
        padding-bottom: .75rem;
        font-size: 1rem;
        @if (empty($_no_shadow))
            background-color: rgba(0, 0, 0, .25);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        @endif
    }

    .navbar .form-control {
        padding: .75rem 1rem;
        border-width: 0;
        border-radius: 0;
    }

    .navbar .dropdown-menu {
        max-height:400px;
        overflow-y:auto;
    }

    .form-control-dark {
        color: #fff;
        background-color: rgba(255, 255, 255, .1);
        border-color: rgba(255, 255, 255, .1);
    }

    .form-control-dark:focus {
        border-color: transparent;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
    }

    /*
     * Bootstrap Select
     */

    .bootstrap-select > .dropdown-toggle {
        background: white;
        border: 1px solid #ced4da;
    }

    /*
     * Popovers
     */

    .popover-body {
        max-height: 250px;
        overflow-y: auto;
    }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/clipboard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/date-input-polyfill.dist.js') }}" type="text/javascript"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // initialize copy-to-clipboard
            clipboard = new ClipboardJS('.clipboard')

            clipboard.on('success', function(e) {
                var previous = $(e.trigger).attr('data-original-title');

                $(e.trigger)
                    .tooltip('hide')
                    .attr('data-original-title', "Copié !")
                    .tooltip('show');

                setTimeout(function () {
                    $(e.trigger)
                        .tooltip('hide')
                        .attr('data-original-title', previous);
                }, 500);
            });

            $('.clipboard').css('cursor', 'pointer');

            // initialize popovers
            $('[data-toggle="popover"]').popover();

            // initialize tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // initialize data-shown
            $('[data-shown-if]').each(function(i, item) {
                var attr   = $(item).attr('data-shown-if'),
                    values = (attr.indexOf(",") == -1) ? [attr] : attr.split(",");

                var show = function () {
                    return values.some(function (value) {
                        var parts = value.split(':');

                        if (parts[1] == 'checked') {
                            return $(parts[0]).is(':checked');
                        }

                        if (typeof(parts[1]) == 'undefined') {
                            return $(parts[0]).val();
                        }

                        return $(parts[0]).val() == parts[1];
                    })
                };

                $.each(values, function (i, value) {
                    var parts = value.split(':');

                    $(parts[0]).change(function (event) {
                        return show() ? $(item).show() : $(item).hide();
                    }).trigger('change');
                });
            });

            $('.enterprise-finder').each(function(i, finder) {
                let $button  = $('button', finder),
                    $input   = $(':input.form-control', finder),
                    $results = $('.list-group', finder),
                    $text    = $('small', finder),
                    $hidden  = $(':input[type=hidden]', finder),
                    $alert   = $('[role=alert]', finder);

                $input.keypress(function (event) {
                    if (event.key == 'Enter') {
                        event.preventDefault();
                        $button.click();
                    }
                });

                $(document).on('click', '.list-group-item', function(event) {
                    if ($(this).parents('.enterprise-finder').is(finder)) {
                        event.preventDefault();
                        $hidden.attr('value', $(this).attr('id'));
                        $(this).addClass('active').siblings().removeClass('active');
                    }
                });

                $button.click(function (event) {
                    let value = $input.val();

                    if (value.length < 3) {
                        return;
                    }

                    $.ajax({
                        url: $(finder).attr('data-finder-url'),
                        method: 'post',
                        data: {
                            search: $input.val(),
                            filter: JSON.parse($(finder).attr('data-finder-filter'))
                        },
                        beforeSend: function() {
                            $button.add($input).attr('disabled', true);
                            $results.html('');
                            $hidden.attr('value', '');
                            $alert.hide();
                        },
                        complete: function() {
                            $button.add($input).attr('disabled', false);
                        },
                        success: function(response) {
                            let count = 0;
                            $.each(response, function (id, name) {
                                count++;
                                $results.append('<a href="#" class="list-group-item list-group-item-action" id="'+id+'">'+name+'</a>');
                            });
                            $text.text($text.attr('data-text').replace('#', count));
                        },
                        error: function() {
                            $alert.show();
                        }
                    });
                });
            });
        });
    </script>
@endpush
