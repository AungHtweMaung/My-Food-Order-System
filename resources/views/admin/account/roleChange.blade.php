@extends('admin.layouts.master')

@section('title', 'Admin Profile')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">

                <div class="col-lg-10 mt-5">
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

                            <form action="{{ route('admin#change', $account->id) }}" method="post"
                                enctype="multipart/form-data" novalidate="novalidate">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="col-4 ">
                                        @if ($account->image == null)
                                            @if ($account->gender == 'male')
                                                <img class="img-thumbnail" src="{{ asset('image/default_male.png') }}"
                                                    alt="">
                                            @else
                                                <img class="img-thumbnail" src="{{ asset('image/default_female.png') }}"
                                                    alt="">
                                            @endif
                                        @else
                                            <img style="min-height: 150px;"
                                                src="{{ asset('storage/profileImage/' . $account->image) }}" />
                                        @endif


                                        <div class="">
                                            <button type="submit" class="btn btn-dark w-100"><i
                                                    class="fas fa-arrow-circle-right mr-2"></i>Update</button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Role</label>
                                            <select name="role" class="form-control">
                                                <option value="admin" @if ($account->role == 'admin') selected @endif>
                                                    Admin</option>
                                                <option value="user" @if ($account->role == 'user') selected @endif>
                                                    User</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input id="cc-pament" disabled name="name"
                                                value="{{ old('name', $account->name) }}" class="form-control"
                                                aria-required="true" aria-invalid="false" placeholder="">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Email</label>
                                            <input id="cc-pament" disabled name="email"
                                                value="{{ old('email', $account->email) }}" class="form-control"
                                                aria-required="true" aria-invalid="false">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Phone</label>
                                            <input id="cc-pament" disabled name="phone"
                                                value="{{ old('phone', $account->phone) }}" class="form-control"
                                                aria-required="true" aria-invalid="false">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Gender</label>
                                            <select name="gender" disabled class="form-control">
                                                <option value="">Choose gender</option>
                                                <option value="male" @if ($account->gender == 'male') selected @endif>
                                                    Male</option>
                                                <option value="female" @if ($account->gender == 'female') selected @endif>
                                                    Female</option>
                                            </select>
                                            @error('gender')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Address</label>
                                            <textarea name="address" disabled class="form-control" id="" cols="10" rows="5">{{ $account->address }}</textarea>
                                            @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
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
    <!-- END MAIN CONTENT-->
@endsection
