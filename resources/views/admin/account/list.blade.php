@extends('admin.layouts.master')

@section('title', 'Admin List')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Admin List</h2>

                            </div>
                        </div>
                        {{-- <div class="table-data__tool-right">
                            <a href="{{ route('category#createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add category
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div> --}}
                    </div>
                    @if (session('createMessage'))
                        <div class="row">
                            <div class="col-md-4 offset-8">

                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ session('createMessage') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('deleteMessage'))
                        <div class="row">
                            <div class="col-md-4 offset-8">

                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>{{ session('deleteMessage') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('updateMessage'))
                        <div class="row">
                            <div class="col-md-4 offset-8">

                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>{{ session('updateMessage') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row d-flex justify-content-between">
                        @if (request('searchKey'))
                            <div class="col-12 col-sm-3">
                                <h4 class="text-secondary">
                                    Search Key : <span class="text-danger">{{ request('searchKey') }}</span>
                                </h4>
                            </div>
                        @endif
                        <div
                            class="col-12 col-sm-7 col-md-5 col-xl-3 @if (request('searchKey')) offset-0 @else offset-xl-9 offset-md-7 offset-sm-5 @endif">
                            <form action="{{ route('admin#list') }}" method="GET">
                                <input type="hidden" name="adminRole" value="admin">
                                <div class="d-flex">
                                    <input type="text" class="form-control" name="searchKey"
                                        value="{{ request('searchKey') }}" placeholder="Search...">
                                    <button type="submit" class="btn bg-dark text-white">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row justify-content-end my-2">
                        <div class="col-5 col-sm-3 col-md-2">
                            <div class="bg-white text-center p-2">
                                <h3><i class="fas fa-database mr-3"></i> {{ $admins->total() }}</h3>
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th class="">Name</th>
                                    <th class="">Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($admins as $admin)
                                    <tr class="tr-shadow">
                                        <input type="hidden" value="{{ $admin->id }}" id="userId">

                                        <td class="col-2">
                                            @if ($admin->image == null)
                                                @if ($admin->gender == 'male')
                                                    <img class="img-thumbnail" src="{{ asset('image/default_male.png') }}"
                                                        alt="">
                                                @else
                                                    <img class="img-thumbnail" src="{{ asset('image/default_female.png') }}"
                                                        alt="">
                                                @endif
                                            @else
                                                <img class="img-thumbnail"
                                                    src="{{ asset('storage/profileImage/' . $admin->image) }}"
                                                    alt="">
                                            @endif
                                        </td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->gender }}</td>
                                        <td>{{ $admin->phone }}</td>
                                        <td>{{ $admin->address }}</td>
                                        <td>
                                            @if (Auth::user()->id == $admin->id)
                                            @else
                                                <select class="form-control roleChange" >
                                                    <option value="user"
                                                        @if ($admin->role == 'user') selected @endif>user</option>
                                                    <option value="admin"
                                                        @if ($admin->role == 'admin') selected @endif>admin</option>

                                                </select>

                                            @endif
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        {{-- request()->query() သည် every pagination link တိုင်းအတွက်
                                query result ကို append လုပ်ပေးသွားတာ
                            --}}
                        {{ $admins->links() }}
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
                <div class="modal-bodyobject">
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
    <script>
        $(document).ready(function() {
            $('.roleChange').change(function() {
                $parentNode = $(this).parents('tr');
                // console.log($parentNode);
                $role = $parentNode.find('.roleChange').val();
                $userId = $parentNode.find('#userId').val();


                $.ajax({
                    type: 'get',
                    url: '/admin/ajax/admin/roleChange',
                    data: {
                        'role': $role,
                        'userId': $userId,
                    },
                    dataType: 'json',
                    success: function(response) {
                        location.reload()
                    }
                })
            })
        })
    </script>
@endsection
