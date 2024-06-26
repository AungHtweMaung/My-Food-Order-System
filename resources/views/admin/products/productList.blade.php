@extends('admin.layouts.master')

@section('title', 'Products')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Product List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('product#createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add product
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

                    <div
                        class="row @if (request('searchKey')) justify-content-between  @else justify-content-end @endif">
                        @if (request('searchKey'))
                            <div class="col-4">
                                <h4 class="text-secondary">
                                    Search Key : <span class="text-danger">{{ request('searchKey') }}</span>
                                </h4>
                            </div>
                        @endif
                        <div class="col-4">
                            <form action="{{ route('product#list') }}" method="GET">
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
                        <div class="col-2">
                            <div class="bg-white text-center p-2">
                                <h3><i class="fas fa-database mr-3"></i> {{ $products->total() }} </h3>
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>View Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- products --}}
                                @foreach ($products as $p)
                                    <tr>
                                        <td class="col-2"><a href="{{ route('product#detail', $p->id) }}">
                                                <img src="{{ asset('storage/productImage/' . $p->image) }}" alt="">
                                            </a>
                                        </td>
                                        <td class="col-2">{{ $p->name }}</td>
                                        <td class="col-2">{{ $p->price }}</td>
                                        <td class="col-2">{{ $p->category_name }}</td>
                                        <td class="col-2"><i class="fa-solid fa-eye mr-2"></i>{{ $p->view_count }}</td>
                                        <td class="col-2">
                                            <div class="table-data-feature d-flex justify-content-start ">
                                                <a href="{{ route('product#detail', $p->id) }}">
                                                    <button class="item mr-3" data-toggle="tooltip" data-placement="top"
                                                        title="View">
                                                        <i class="fas fa-eye"></i>

                                                    </button>
                                                </a>

                                                <a href="{{ route('product#editPage', $p->id) }}">
                                                    <button class="item mr-3" title="edit" data-toggle="tooltip"
                                                        data-placement="top" data-target="#exampleModal">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button>
                                                </a>

                                                <a href="{{ route('product#delete', $p->id) }}">
                                                    <button class="item mr-3" title="Delete" data-toggle="tooltip"
                                                        data-placement="top" data-target="#exampleModal">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </a>

                                            </div>
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
                        {{ $products->links() }}
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
