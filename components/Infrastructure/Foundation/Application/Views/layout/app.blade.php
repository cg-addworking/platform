@extends('bootstrap::blank')

@section('page')
    @include('_gtm_body')
    <div class="d-flex" id="wrapper">
        @if (empty($_no_sidebar))
            <div class=" border-right" id="sidebar-wrapper">
                <div class="sidebar-heading">
                    <img src="{{ asset('img/logo_black_addworking.png') }}" alt="AddWorking" width="160px" class="ml-3">
                </div>
                <div class="list-group list-group-flush">
                    @include('foundation::layout._sidebar')
                </div>
            </div>
        @endif
        <div id="page-content-wrapper">
            @include('foundation::layout._navbar')

            <div class="container-fluid">
                <div class="row">
                    <main role="main" class="col-md-12">
                        @includeWhen(session('status'), 'foundation::layout._status')
                        @yield('main')

                        <footer class="text-center py-5">
                            © {{date('Y') }} Copyright: <a href="https://www.addworking.com/"> AddWorking</a>
                        </footer>
                    </main>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('stylesheets')
    <style>
        body {
            font-size: .875rem;
            overflow-y: scroll;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            -webkit-transition: margin .25s ease-out;
            -moz-transition: margin .25s ease-out;
            -o-transition: margin .25s ease-out;
            transition: margin .25s ease-out;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
        }

        #sidebar-wrapper .list-group {
            width: 15rem;
        }

        #page-content-wrapper {
            min-width: 100vw;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }

        .list-group-item {
            font-size: .875rem;
            padding: .50rem 1.25rem;
            border : 0px !important;
        }

        .section-text {
            font-size: .75rem;
            text-transform: uppercase;
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

        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }

            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: -15rem;
            }
        }
    </style>
    @include('_gtm_datalayer')
    @include('_gtm_head')
@endpush

@push('scripts')
    <script src="{{ asset('js/clipboard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/date-input-polyfill.dist.js') }}" type="text/javascript"></script>
    @include('enterprise::modals.member_job_title')
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
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
    <script>
        (function(){
            $('.prevent-multiple-submits').on('submit', function(){
                $(".prevent-multiple-submits").find(':submit').each(function() {
                    $(this).attr('disabled', true);
                })
            })
        })();
    </script>
    @include('_intercom')
@endpush
