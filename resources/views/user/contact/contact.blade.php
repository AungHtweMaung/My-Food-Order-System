@extends('user.layouts.master')

@section('title')
Contact
@endsection

@section('content')
    <!-- Contact Start -->
    <div class="container-fluid">
        <h2 class=" position-relative text-uppercase mx-xl-5 mb-4"><span class="pr-3">Contact Us</span></h2>

        @if (session('MessageSent'))
            <div class="col-6 offset-3">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>{{ session('MessageSent') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form bg-light p-30">
                    <form action="{{route('user#sendMessage')}}" method="post" novalidate="novalidate">
                        @csrf
                        <div class="control-group mb-3">
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Your Name" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="control-group mb-3">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Your Email" required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="control-group mb-3">
                            <input type="text" value="{{ old('subject') }}" name="subject" class="form-control" placeholder="Subject" required>
                        </div>
                        <div class="control-group mb-3">
                            <textarea name="message" value="{{ old('message') }}" class="form-control @error('message') is-invalid @enderror" rows="8" placeholder="Message" required></textarea>
                            @error('message')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="btn btn-dark py-2 px-4" >Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <div class="bg-light p-30 mb-3">
                    <iframe style="width: 100%; height: 250px;"
                     src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d118427.18160608044!2d95.99342241807895!3d21.9403393636569!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30cb6d23f0d27411%3A0x24146be01e4e5646!2sMandalay!5e0!3m2!1sen!2smm!4v1697632623937!5m2!1sen!2smm" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                </div>
                <div class="bg-light p-30 mb-3">
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Mandalay, Myanmar</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>foos@gmail.com</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+959951813416</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

@endsection

