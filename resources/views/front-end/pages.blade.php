@extends('front-end.layouts.app')
@section('title', 'Page')
@section('contents')

<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item">{{$pages->name}}</li>
                </ol>
            </div>
        </div>
    </section>

    @if ($pages->slug == 'contact')
        <section class=" section-10">
            <div class="container">
                <div class="section-title mt-5 ">
                    <h2>{{$pages->name}}</h2>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mt-3 pe-lg-5">
                        {!! $pages->content !!}
                    </div>

                    <div class="col-md-6">
                        <form action="" class="shake" method="POST" id="contactForm" name="contactForm">
                            @csrf
                            <div class="mb-3">
                                <label class="mb-2" for="name">Name</label>
                                <input class="form-control" id="name" type="text" name="name" >
                                <p class="invalid-feedback"></p>
                            </div>

                            <div class="mb-3">
                                <label class="mb-2" for="email">Email</label>
                                <input class="form-control" id="email" type="email" name="email">
                                <p class="invalid-feedback"></p>

                            </div>

                            <div class="mb-3">
                                <label class="mb-2">Subject</label>
                                <input class="form-control" id="subject" type="text" name="subject" >
                                <p class="invalid-feedback"></p>

                            </div>

                            <div class="mb-3">
                                <label for="message" class="mb-2">Message</label>
                                <textarea class="form-control" rows="3" id="message" name="message" ></textarea>

                            </div>

                            <div class="form-submit">
                                <button class="btn btn-dark" type="submit" id="form-submit"><i class="material-icons mdi mdi-message-outline"></i> Send Message</button>
                                <div id="msgSubmit" class="h3 text-center hidden"></div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    @else
        <section class=" section-10">
            <div class="container">
                <h1 class="my-3">{{ $pages->name}}</h1>
                <p>{!! $pages->content !!}</p>

            </div>
        </section>
    @endif


</main>
@endsection
@section('js')
<script>
    $("#contactForm").submit(function(e){
        e.preventDefault();
        $("#form-submit").prop('disabled', true);
        $.ajax({
            url: `{{ route('front.sendContactEmail')}}` ,
            type: 'POST',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response){
                $("#form-submit").prop('disabled', false);

                if(response.status == true){
                    alert(response.message);
                    location.reload();
                }else{
                    var errors = response['errors'];
                    if (errors['name']) {
                            $('#name').addClass('is-invalid').siblings('p.invalid-feedback')
                                .html(errors['name']);
                        } else {
                            $('#name').removeClass('is-invalid').siblings('p.invalid-feedback')
                                .html("");
                        }

                        if (errors['email']) {
                            $('#email').addClass('is-invalid').siblings('p.invalid-feedback').html(errors['email']);
                        } else {
                            $('#email').removeClass('is-invalid').siblings('p.invalid-feedback').html("");
                        }

                        if (errors['subject']) {
                            $('#subject').addClass('is-invalid').siblings('p.invalid-feedback').html(errors['subject']);
                        } else {
                            $('#subject').removeClass('is-invalid').siblings('p.invalid-feedback').html("");
                        }
                }

            }
        });
    });
</script>
@endsection
