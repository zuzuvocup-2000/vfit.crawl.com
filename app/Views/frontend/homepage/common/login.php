<div id="login_hd" class="uk-modal" aria-hidden="true">
    <div class="uk-modal-dialog">
        <a href="" class="uk-modal-close uk-close"></a>
        <div class="modal-auth-general wrap-modal-login">
            <div class="login-title">
                Log in
            </div>
            <a href="" title="" onclick="notification();return false;" class="btn-login-general bg-gg uk-flex uk-flex-middle uk-flex-center">
                <svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-mr-3"><rect width="24" height="24" rx="2" fill="#fff"></rect><path fill-rule="evenodd" clip-rule="evenodd" d="M19.68 12.182c0-.567-.05-1.113-.145-1.636H12v3.094h4.305a3.68 3.68 0 01-1.596 2.415v2.007h2.585c1.513-1.393 2.386-3.444 2.386-5.88z" fill="#4285F4"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M12 20c2.16 0 3.97-.716 5.294-1.938l-2.585-2.008c-.716.48-1.633.764-2.71.764-2.083 0-3.846-1.407-4.475-3.298H4.85v2.073A7.997 7.997 0 0012 20z" fill="#34A853"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M7.524 13.52c-.16-.48-.251-.993-.251-1.52s.09-1.04.25-1.52V8.407H4.852A7.997 7.997 0 004 12c0 1.29.31 2.513.85 3.593l2.674-2.073z" fill="#FBBC05"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M12 7.182c1.175 0 2.229.403 3.058 1.196l2.295-2.294C15.967 4.793 14.156 4 12 4a7.997 7.997 0 00-7.15 4.407l2.674 2.073C8.153 8.59 9.916 7.182 12 7.182z" fill="#EA4335"></path></svg>
                Log in with google
            </a>
            <a href="" title="" onclick="notification();return false;" class="btn-login-general bg-fb uk-flex uk-flex-middle uk-flex-center">
                <svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-mr-3"><path d="M19.117 4H4.877A.883.883 0 004 4.883v14.24a.883.883 0 00.883.877h7.664v-6.187h-2.08V11.39h2.08V9.61c0-2.066 1.263-3.2 3.106-3.2a16.73 16.73 0 011.862.096v2.166h-1.28c-1 0-1.193.48-1.193 1.176v1.542h2.398l-.32 2.423h-2.08V20h4.077a.883.883 0 00.883-.883V4.877A.883.883 0 0019.117 4z" fill="currentColor"></path></svg>
                Log in with facebook
            </a>
            <p class="text-hr-login"><span>or</span></p>
            <form action="" class="login-form">
                <div class="wrap-input mb15">
                    <label>Email</label>
                    <input type="text" name="email" autocomplete="off" value="" class="form-input login-input-email">
                </div>
                <div class="wrap-input">
                    <label>Password</label>
                    <input type="password" name="password" autocomplete="off" value="" class="form-input login-input-password">
                </div>
                <button type="submit" class="va-continue button-login" >Login</button>
            </form>
            <div class="text-center bold mb20">
                Need an account? <a href="" title="" class="text-underline btn-signupm">Sign up</a>.
            </div>
            <div class="text-center text-forgot mb20 text-underline"><a class="btn-forgotm" href="" title="">Forgot your password?</a></div>
            <div class="text-center text-policy">
                By logging in, you agree to our <a class="text-underline" href="" title="">Privacy Policy</a> and <a class="text-underline" href=""> Terms of Service</a>.
            </div>
        </div>
        <div class="modal-auth-general wrap-modal-sign">
            <div class="login-title">
                Create Account
            </div>
            <form action="" >
                <div class="wrap-input mb15">
                    <label>Email</label>
                    <input type="text" name="email" autocomplete="off" value="" class="form-input signup-email">
                </div>
                <div class="wrap-input">
                    <label>Password</label>
                    <input type="password" name="password" autocomplete="off" value="" class="form-input signup-password">
                </div>
                <button type="submit" class="va-continue btn-otp-email" >CREATE ACCOUNT</button>
            </form>

            <div class="text-center bold mb20">
                Already have an account? <a href="" title="" class="text-underline btn-signinm">Sign in</a>.
            </div>
            <div class="text-center text-policy">
                By logging in, you agree to our <a class="text-underline" href="" title="">Privacy Policy</a> and <a class="text-underline" href=""> Terms of Service</a>.
            </div>
        </div>
        <div class="modal-auth-general wrap-modal-forgot">
            <div class="login-title">
                Reset Password
            </div>
            <form action="" >
                <div class="wrap-input mb15">
                    <label>Email</label>
                    <input type="text" name="email" autocomplete="off" value="" class="form-input input-email-forgot">
                </div>
                <button type="submit" class="va-continue btn-get-otp-forgot" >SEND EMAIL</button>
            </form>
            <div class="text-center bold mb20">
                Remember your password ? <a href="" title="" class="text-underline btn-loginm">Log in</a>.
            </div>
        </div>
        <div class="modal-auth-general wrap-modal-verify">
            <div class="login-title">
                Verify OTP code
            </div>
            <form action="" >
                <div class="wrap-input mb15">
                    <label>OTP code</label>
                    <input type="text" name="otp" autocomplete="off" value="" class="form-input signup-otp">
                    <input type="hidden" name="email_otp" autocomplete="off" value="" class="form-input email-check-otp">
                </div>
                <button type="submit" class="va-continue btn-otp-verify" >VERIFY</button>
            </form>

            <div class="text-center bold mb20">
                Already have an account? <a href="" title="" class="text-underline btn-signinm">Sign in</a>.
            </div>
            <div class="text-center text-policy">
                By logging in, you agree to our <a class="text-underline" href="" title="">Privacy Policy</a> and <a class="text-underline" href=""> Terms of Service</a>.
            </div>
        </div>
        <script type="text/javascript">
        $(document).ready(function(){
            $('.btn-signupm').on('click', function(){
                $('.modal-auth-general').removeClass('block')
                $('.wrap-modal-sign').addClass('block')
                return false;
            });
            $('.btn-signinm').on('click', function(){
                $('.modal-auth-general').removeClass('block')
                $('.wrap-modal-login').addClass('block')
                return false;
            });
            $('.btn-forgotm').on('click', function(){
                $('.modal-auth-general').removeClass('block')
                $('.wrap-modal-forgot').addClass('block')
                return false;
            });
            $('.btn-loginm').on('click', function(){
                $('.modal-auth-general').removeClass('block')
                $('.wrap-modal-login').addClass('block')
                return false;
            });
            $('.btn-loginm2').on('click', function(){
                $('.modal-auth-general').removeClass('block')
                $('.wrap-modal-login').addClass('block')
            });
        });

        function notification(){
            toastr.warning('Feature is being finalized');
            return false;
        }
        </script>
    </div>
</div>