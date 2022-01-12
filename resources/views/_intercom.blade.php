@if(! is_null(config('intercom.api_key')))
    @if(auth()->check() && ! auth()->user()->isSupport())
        <script type="text/javascript">
            var APP_ID = "{{ config('intercom.api_key') }}";
            var USER_FIRSTNAME = "{{ auth()->user()->firstname }}";
            var USER_LASTNAME = "{{ auth()->user()->lastname }}";
            var USER_NAME = "{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}";
            var USER_EMAIL = "{{ auth()->user()->email }}";
            var USER_ID = "{{ auth()->user()->id }}";
        </script>
        @if(auth()->user()->enterprise->exists)
            <script type="text/javascript">
                var COMPANY_ID = "{{ auth()->user()->enterprise->id }}";
                var COMPANY_NAME = "{{ auth()->user()->enterprise->name }}";
                var USER_JOB = "{{ auth()->user()->enterprise->pivot->job_title ?? null}}";
                var COMPANY_COUNTRY = "{{ auth()->user()->enterprise->country }}";
                var COMPANY_IS_VENDOR = {{ auth()->user()->enterprise->is_vendor ? 1 : 0 }};
                var COMPANY_IS_CUSTOMER = {{ auth()->user()->enterprise->is_customer ? 1 : 0 }};
                var COMPANY_CUSTOMERS = "{{ implode(';', json_decode(json_encode(auth()->user()->enterprise->customers->pluck('name')))) }}";

                window.intercomSettings = {
                    app_id: APP_ID,
                    email: USER_EMAIL,
                    user_id: USER_ID,
                    name: USER_NAME,
                    "last_name": USER_LASTNAME,
                    "first_name": USER_FIRSTNAME,
                    "job_title": USER_JOB,
                    company: {
                        company_id: COMPANY_ID,
                        name: COMPANY_NAME,
                        "country": COMPANY_COUNTRY,
                        "is_vendor": COMPANY_IS_VENDOR,
                        "is_customer": COMPANY_IS_CUSTOMER,
                        "customers": COMPANY_CUSTOMERS,
                    },
                    alignment: 'right',
                };
            </script>
        @else
            <script type="text/javascript">
                window.intercomSettings = {
                    app_id: APP_ID,
                    email: USER_EMAIL,
                    user_id: USER_ID,
                    name: USER_NAME,
                    "last_name": USER_LASTNAME,
                    "first_name": USER_FIRSTNAME,
                    alignment: 'right',
                };
            </script>
        @endif
    <script>
        (function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/u28xytuq';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
    </script>
    @endif
@endif