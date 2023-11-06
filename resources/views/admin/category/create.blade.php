@extends('admin.layouts.master')

@section('title', 'Create Category')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row justify-content-center">

                    <div class="col-lg-8 ">
                        <div class="text-right">
                            <a href="{{ route('category#list') }}"><button class="btn bg-dark text-white my-3">Category
                                    List</button></a>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h3 class="text-center title-2">Create Your Category</h3>
                                </div>
                                <hr>
                                <form action="{{ route('category#create') }}" method="post" novalidate="novalidate">
                                    @csrf
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="categoryName" value="{{ old('categoryName') }}"
                                            type="text" class="form-control @error('categoryName') is-invalid @enderror"
                                            aria-required="true" aria-invalid="false" placeholder="Seafood...">
                                        @error('categoryName')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                            <span id="payment-button-amount">Create</span>
                                            <i class="fa-solid fa-circle-right"></i>
                                            {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                                        </button>
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
