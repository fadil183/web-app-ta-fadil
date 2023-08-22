@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <h2>Daftar Bukti Kemas</h2>
            </div>
            <form action="x" method="get">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control mb-3" placeholder="search" name="q" id="searchUser">
                        <span id="userList"></span>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" class="form-control mb-3" value="Search">
                    </div>
                    @can('product-create')
                    <div class="col-md-2">
                        <a class="btn btn-success" href="{{ route('products.create') }}"> Tambah Bukti Kemas</a>
                    </div>
                @endcan
                </div>
            </form>
        </div>
    </div>

    @if ($message = Session::get('Success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th class="col-md">No</th>
            <th class="col-md">Order Number</th>
            <!-- <th>Tanggal Data Dimasukan</th> -->
            <th class="col-md" width="280dp">Action</th>
        </tr>
	    @foreach ($products as $product)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $product->order_id }}</td>
	        <!-- <td>{{ $product->created_at }}</td> -->
	        <td>
                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Lihat Foto</a>
                    @can('product-edit')
                    <a class="btn btn-warning" href="{{ route('products.edit',$product->id) }}">Edit</a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('product-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>

    {!! $products->links() !!}

@endsection