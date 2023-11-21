@extends('admin.layouts.master')

@section('title', 'CategoryList')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Category List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('category#createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add category
                                </button>
                            </a>
                        </div>
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
                        <div class="col-12 col-sm-7 col-md-5 col-xl-3 @if(request('searchKey')) offset-0 @else offset-xl-9 offset-md-7 offset-sm-5 @endif">
                            <form action="{{ route('category#list') }}" method="GET">
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
                                <h3><i class="fas fa-database mr-3"></i> {{ $categories->total() }}</h3>
                            </div>
                        </div>
                    </div>

                    @if (count($categories) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th class="">Category Name</th>
                                        <th>Created Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr class="tr-shadow">
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td class="ml-5">{{ $category->created_at->format('d-F-Y h:i a') }}</td>
                                            <td class="">
                                                <div class="table-data-feature d-flex justify-content-start ">
                                                    <a href="{{ route('category#editPage', $category->id) }}">
                                                        <button class="item mr-3" data-toggle="tooltip" data-placement="top"
                                                            title="Edit">
                                                            <i class="zmdi zmdi-edit"></i>
                                                        </button>
                                                    </a>

                                                    <a href="{{ route('category#delete', $category->id) }}">
                                                        <button class="item" title="Delete" data-toggle="tooltip"
                                                            data-placement="top" data-target="#exampleModal">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>

                                                    {{-- <form id="deleteCategoryForm"
                                                        action="{{ route('category#delete', $category->id) }}"
                                                        method="get">

                                                    </form> --}}

                                                </div>
                                            </td>

                                        </tr>


                                        <!-- Category delete Modal -->
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            {{-- request()->query() သည် every pagination link တိုင်းအတွက်
                                query result ကို append လုပ်ပေးသွားတာ
                            --}}
                            {{ $categories->appends(request()->query())->links() }}
                        </div>
                    @else
                        <h3 class="text-center text-secondary mt-5">There is no category here!</h3>

                    @endif



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
