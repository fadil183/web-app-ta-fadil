@extends('layouts.app')
@section('content')
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <h2>Daftar Bukti Kemas</h2>
            </div>
            <form action="{{route('products.index')}}" method="get">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control mb-4" placeholder="search" name="query" id="searchUser">
                        <span id="userList"></span>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" class="form-control mb-4 btn btn-secondary" value="Search">
                    </div>
                    @can('product-create')
                    <div class="col-md-2">
                        <a class="btn btn-success form-control mb-4" href="{{ route('products.create') }}"> Tambah Data</a>
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

    @if ($message = Session::get('Failed'))
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
        @if (!empty($products) )
            @foreach ($products as $product)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $product->order_id }}</td>
                <!-- <td>{{ $product->created_at }}</td> -->
                <td>
                    <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                        <a class="btn btn-info" href="{{asset('uploads/images/'.$product->order_image)}}">Lihat Foto</a>
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
        @endif
    </table>

    {!! $products->links() !!}

@endsection
<script>
    $('#searchUser').on('keyup', function()
    {
        var query=$(this).val();
        $.ajax({
            url:"{{route('products.find')}}",
            type:"GET",
            data:{'query':query},
            success:function (data){
                $('#userList').html(data);
            }
        })
    });
    $('body').on('click', 'li', function(){
        var value = $(this).text();
    })

</script>