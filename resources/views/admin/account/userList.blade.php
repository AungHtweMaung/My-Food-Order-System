@extends('admin.layouts.master')

@section('title', 'User List')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">User List</h2>

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
                            <form action="{{ route('admin#normalUserList') }}" method="GET">
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
                                <h3><i class="fas fa-database mr-3"></i>{{ $normalUsers->total() }}</h3>
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

                                @foreach ($normalUsers as $user)
                                    <tr class="tr-shadow">
                                        <input type="hidden" value="{{ $user->id }}" id="userId">

                                        <td class="col-2">
                                            @if ($user->image == null)
                                                @if ($user->gender == 'male')
                                                    <img class="img-thumbnail" src="{{ asset('image/default_male.png') }}"
                                                        alt="">
                                                @else
                                                    <img class="img-thumbnail" src="{{ asset('image/default_female.png') }}"
                                                        alt="">
                                                @endif
                                            @else
                                                <img class="img-thumbnail"
                                                    src="{{ asset('storage/profileImage/' . $user->image) }}"
                                                    alt="">
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->gender }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>
                                            @if (Auth::user()->id == $user->id)
                                            @else
                                                <div class="d-flex">
                                                    <select class="form-control roleChange">
                                                        <option value="user"
                                                            @if ($user->role == 'user') selected @endif>
                                                            user</option>
                                                        <option value="admin"
                                                            @if ($user->role == 'admin') selected @endif>
                                                            admin</option>

                                                    </select>
                                                    <a href="{{ route('admin#deleteNormalUser', $user->id) }}"
                                                        class="btn btn-dark ml-2"><i class="fa-solid fa-trash"></i></a>
                                                </div>
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
                        {{ $normalUsers->links() }}
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
                    url: '/admin/ajax/user/roleChange',
                    data: {
                        'role': $role,
                        'userId': $userId
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
