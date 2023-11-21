@extends('admin.layouts.master')

@section('title', 'Message Info')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <a href="#" onclick="history.back()"><i class="fas fa-arrow-left text-muted"></i></a>
                                <h5 class="card-title">{{ $message->name }} <span
                                        class="mx-lg-3">({{ $message->email }})</span></h5>
                                {{-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> --}}
                                <p class="card-text h3 mt-2">{{ $message->message }}</p>

                            </div>
                        </div>
                    </div>

                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->

    {{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="document.querySelector('#deleteCategoryForm').submit()"
                        class="btn btn-primary">Delete</button>
                </div>
            </div>
        </div>
    </div> --}}



@endsection


@section('myjs')
    <script></script>
@endsection
