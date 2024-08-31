@extends('front-end.layouts.app')
@section('title', 'Register')
@section('contents')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item">Register</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            <div class="login-form">
                <form action="" method="post" name="registrantionForm" id="registrantionForm">
                    <h4 class="modal-title">Register Now</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" id="name" name="name">
                        <p class="error"></p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Email" id="email" name="email">
                        <p class="error"></p>

                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Phone" id="phone" name="phone">
                    </div>
                    <div class="form-group" style="position: relative;" >
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password">
                        <i class=" toggle-password" id="togglePassword" ></i>
                        <p class="error"></p>

                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation">
                        <i class=" toggle-password" id="togglePassword" ></i>

                        <p class="error"></p>
                    </div>
                    <div class="form-group small">
                        <a href="#" class="forgot-link">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
                </form>
                <div class="text-center small">Already have an account? <a class="text-success " href="{{ route('account.login')}}">Login Now</a></div>
            </div>
        </div>
    </section>
</main>
@endsection
@section('js')
<script>
    $("#registrantionForm").submit( function(event){
        event.preventDefault(); // ngăn chặn hành vi mặc định của form
        $("button[type='submit']").prop('disabled', true);
        $.ajax({
            url: `{{ route('account.processRegister') }}`,
            type: 'POST',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type='submit']").prop('disabled', false);
                let errors = response.errors;
                if(response.status === false){
                    // name
                    if(errors.name){
                        $("#name").siblings("p").addClass('invalid-feedback').html(errors.name);
                        $("#name").addClass('is-invalid');

                    }else{
                        $("#name").siblings("p").removeClass('invalid-feedback').html('');
                        $("#name").removeClass('is-invalid');

                    }
                    // email
                    if(errors.email){
                        $("#email").siblings("p").addClass('invalid-feedback').html(errors.email);
                        $("#email").addClass('is-invalid');

                    }else{
                        $("#email").siblings("p").removeClass('invalid-feedback').html('');
                        $("#email").removeClass('is-invalid');

                    }
                    // password
                    if(errors.password){
                        $("#password").siblings("p").addClass('invalid-feedback').html(errors.password);
                        $("#password").addClass('is-invalid');

                    }else{
                        $("#password").siblings("p").removeClass('invalid-feedback').html('');
                        $("password").removeClass('is-invalid');

                    }

                }else{
                    $("#name").siblings("p").removeClass('invalid-feedback').html('');
                    $("#name").removeClass('is-invalid');

                    $("#email").siblings("p").removeClass('invalid-feedback').html('');
                    $("#email").removeClass('is-invalid');

                    $("#password").siblings("p").removeClass('invalid-feedback').html('');
                    $("password").removeClass('is-invalid');



                    alert(response.message);
                    window.location.href = `{{ route('account.login')}}`;
                }
            },
            error: function(JQXHR, execption){
                console.log('something went wrong');
            }

        });

        // document.getElementById('togglePassword').addEventListener('click', function () {
        //     var passwordInput = document.getElementById('password');
        //     var passwordIcon = this.querySelector('i');

        //     if (passwordInput.type === 'password') {
        //         passwordInput.type = 'text';
        //         passwordIcon.classList.remove('fa-eye');
        //         passwordIcon.classList.add('fa-eye-slash');
        //     } else {
        //         passwordInput.type = 'password';
        //         passwordIcon.classList.remove('fa-eye-slash');
        //         passwordIcon.classList.add('fa-eye');
        //     }
        // });

    });

</script>

@endsection
