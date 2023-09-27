@extends('layouts.app')

@push('ajax')
{{-- <script>
    function request() {
        //    var httpdata= document.getElementById('httpdata');
        // a.innerHtml = 'helllll';
        $.ajax({
            type: 'GET',
            url: '/home',
            data: '_token = <?php echo csrf_token(); ?>',
            success: function(data) {
                // ajaxs.innerHtml= data.msg
                console.log(data);
                $("#httpdata").html(data.msg);
            },
            error: function(data) {
                document.getElementById('httpdata').innerHtml='hello';
                console.log(data.status);
            }
        });
    }
</script> --}}
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div id="httpdata">
                            hello
                        </div>
                        <a href="#" onclick="request()">click</a>

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
   @endsection
