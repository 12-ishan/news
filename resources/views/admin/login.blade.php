@extends('layout.adminlogin')
@section('content')
 
    <!-- login area start -->
    <div class="login-area login-s2">
        <div class="container">
            <div class="login-box ptb--100">
                <form id="loginForm" method="post" action="{{ route('doLogin') }}"> 
                {{ csrf_field() }}
                    <div class="login-form-head">
                        <h4>Sign In</h4>
                        <p>Always deliver more than expected</p>
                    </div>

                    @if(session()->has('message'))
                    <div class="alert alert-danger" >
                    {{ session()->get('message') }}
                    </div>
                    @endif
                    <div id="err" class="alert alert-danger" style="display:none;">
                    </div>

                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="email">Email address</label>
                            <input type="text" id="email" name="email">
                            <i class="ti-email"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password">
                            <i class="ti-lock"></i>
                            <div class="text-danger"></div>
                        </div>
                        <!-- <div class="row mb-4 rmber-area">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                    <label class="custom-control-label" for="customControlAutosizing">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <a href="#">Forgot Password?</a>
                            </div>
                        </div> -->
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
                        </div>

                    

<!--                         <div class="form-footer text-center mt-5">
                            <p class="text-muted">Don't have an account? <a href="{{ url('/register') }}">Sign up</a></p>
                        </div> -->

                   

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->
   
    @section('js')
    <script src="{{ asset('assets/admin/js/registration.js') }}"></script>
    @append

@endsection