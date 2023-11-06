@extends('user.layouts.master')

@section('title', 'User Profile')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <a href="#" onclick="history.back()"><i
                                            class="fas fa-arrow-left ml-4 text-dark"></i></a>
                                </div>
                                <div class="card-title">
                                    <h3 class="text-center title-2">Account Info</h3>
                                </div>
                                <hr>

                                <form action="{{ route('user#update', Auth::user()->id) }}" method="post" enctype="multipart/form-data"
                                    novalidate="novalidate">
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-4 ">
                                            @if (Auth::user()->image == null)
                                                @if (Auth::user()->gender == 'male')
                                                    <img class="img-thumbnail" src="{{ asset('image/default_male.png') }}"
                                                        alt="">
                                                @else
                                                    <img class="img-thumbnail" src="{{ asset('image/default_female.png') }}"
                                                        alt="">
                                                @endif
                                            @else
                                                <img class="img-fluid" style="min-height: 150px;"
                                                    src="{{ asset('storage/profileImage/' . Auth::user()->image) }}" />
                                            @endif

                                            <div class="form-group mt-2">
                                                <input name="image" type="file"
                                                    class="form-control @error('image') is-invalid @enderror"
                                                    aria-required="true" aria-invalid="false" placeholder="">
                                                @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mt-2">
                                                <button type="submit" class="btn btn-dark w-100"><i
                                                        class="fas fa-arrow-circle-right mr-2"></i>Update</button>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Name</label>
                                                <input id="cc-pament" name="name"
                                                    value="{{ old('name', Auth::user()->name) }}"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    aria-required="true" aria-invalid="false" placeholder="">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Email</label>
                                                <input id="cc-pament" name="email"
                                                    value="{{ old('email', Auth::user()->email) }}" class="form-control @error('email') is-invalid @enderror"
                                                    aria-required="true" aria-invalid="false">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Phone</label>
                                                <input id="cc-pament" name="phone"
                                                    value="{{ old('phone', Auth::user()->phone) }}" class="form-control @error('phone') is-invalid @enderror"
                                                    aria-required="true" aria-invalid="false">
                                                @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Gender</label>
                                                <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                                    <option value="" disabled >Choose gender</option>
                                                    <option value="male" @if (Auth::user()->gender == 'male') selected @endif>
                                                    Male</option>
                                                <option value="female" @if (Auth::user()->gender == 'female') selected @endif>
                                                    Female</option>
                                                </select>
                                                @error('gender')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Address</label>
                                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="" cols="10" rows="5">{{ old('address', Auth::user()->address) }}</textarea>
                                                @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="cc-payment" class="control-label mb-1">Role</label>
                                                <input id="cc-pament" name="role"
                                                    value="{{ old('role', Auth::user()->role) }}" class="form-control"
                                                    disabled aria-required="true" aria-invalid="false">
                                            </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
