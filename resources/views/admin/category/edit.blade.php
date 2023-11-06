@extends('admin.layouts.master')

@section('title', 'Edit Category')

@section('content')
    <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6 offset-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h3 class="text-center title-2">Edit Your Category</h3>
                                    </div>
                                    <hr>
                                    <form action="{{ route('category#update', $category->id) }}" method="post" novalidate="novalidate">
                                        @csrf
                                        <input type="hidden" name="categoryId" value="{{ $category->id }}">
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="categoryName" value="{{ old('categoryName', $category->name) }}" type="text" class="form-control @error('categoryName') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Seafood...">
                                            @error('categoryName')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                <span id="payment-button-amount">Save</span>
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
            <!-- END MAIN CONTENT-->
@endsection

