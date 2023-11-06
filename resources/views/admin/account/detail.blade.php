@extends('admin.layouts.master')

@section('title', 'Admin Profile')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">

                <div class="col-lg-10 offset-lg-1 mt-5">

                    @if (session('accountUpdateSuccess'))
                        <div class="row">
                            <div class="col-md-7 offset-5">

                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ session('accountUpdateSuccess') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Account Info</h3>
                            </div>
                            <hr>

                            <div class="row justify-content-md-around px-0 px-sm-5">
                                <div class=" col-12 col-sm-6 col-md-4 mt-3 text-center text-sm-left">
                                    <div>
                                        @if (Auth::user()->image == null)
                                            @if (Auth::user()->gender == 'male')
                                                <img style="max-height: 300px;"
                                                    src="{{ asset('image/default_male.png') }}" />
                                            @else
                                                <img style="max-height: 300px;"
                                                    src="{{ asset('image/default_female.png') }}" />
                                            @endif
                                        @else
                                            <img class="img-fluid" style="max-height: 300px;"
                                                src="{{ asset('storage/profileImage/' . Auth::user()->image) }}" />
                                        @endif
                                    </div>

                                    <div class="mt-3">
                                        <a href="{{ route('admin#edit') }}" class="btn btn-dark py-2">
                                            <i class="fas fa-edit mr-2"></i>Edit Profile
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-7">
                                    <div>
                                        <h4 class="my-3"><i class="fas fa-user mr-2"></i>{{ Auth::user()->name }}</h4>
                                        <h4 class="my-3"><i class="fas fa-envelope mr-2"></i>{{ Auth::user()->email }}
                                        </h4>
                                        <h4 class="my-3"><i class="fas fa-phone mr-2"></i>{{ Auth::user()->phone }}</h4>
                                        <h4 class="my-3"><i class="fas fa-mercury mr-2"></i>{{ Auth::user()->gender }}
                                        </h4>
                                        <h4 class="my-3"><i
                                                class="fas fa-map-marker-alt mr-2"></i>{{ Auth::user()->address }}</h4>
                                        <h4 class="my-3"><i
                                                class="fas fa-clock mr-2"></i>{{ Auth::user()->created_at->format('j-F-Y') }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-2 offset-1 mt-2 p-0">
                                    <a href="{{ route('admin#edit') }}" class="btn btn-dark px-3 py-2">
                                        <i class="fas fa-edit mr-2"></i>Edit Profile
                                    </a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
