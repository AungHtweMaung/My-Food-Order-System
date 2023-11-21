@extends('admin.layouts.master')

@section('title', 'User Contact')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">User Contact</h2>

                            </div>
                        </div>

                    </div>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th class="col-2">Name</th>
                                    <th class="col-3">Email</th>
                                    <th>Message</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userMessages as $message)

                                        <tr class="tr-shadow">
                                            <td class="">{{ $message->name }}</td>
                                            <td class="">{{ $message->email }}</td>
                                            <td>{{ $message->message }}</td>
                                            <td><a href="{{ route('admin#userMessageDetail', $message->id) }}" style="font-size: 20px; "><i class="fas fa-eye"></i></a></td>
                                        </tr>


                                    <!-- Category delete Modal -->
                                @endforeach

                            </tbody>
                        </table>
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
