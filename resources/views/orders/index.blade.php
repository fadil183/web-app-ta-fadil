@extends('layouts.app')
@section('content')
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    

</head>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <h2>Daftar Bukti Kemas</h2>
            </div>
            <form action="{{route('orders.find')}}" method="get">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control mb-4" placeholder="Pencarian nomor depan dan belakang" name="query" id="searchOrder">
                        <span id="userList"></span>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" class="form-control mb-4 btn btn-secondary" value="Search">
                    </div>
                    @can('order-create')
                    <div class="col-md-2">
                        <a class="btn btn-success form-control mb-4" href="{{ route('orders.create') }}"> Tambah Data</a>
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
        <div class="alert alert-danger">
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
        @if (isset($orders)&&!empty($orders))
            @foreach ($orders as $order)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $order->id_order }}</td>
                <!-- <td>{{ $order->created_at }}</td> -->
                <td>
                    <form action="{{ route('orders.destroy',$order->id) }}" method="POST">
                        <a class="btn btn-info" href="{{asset('uploads/images/'.$order->image_order)}}">Lihat Foto</a>
                        @can('order-edit')
                        <a class="btn btn-warning" href="{{ route('orders.edit',$order->id) }}">Edit</a>
                        @endcan

                        @csrf
                        @method('DELETE')
                        @can('order-delete')
                        <button type="submit" class="btn btn-danger">Delete</button>
                        @endcan
                    </form>
                </td>
            </tr>
            @endforeach
        @endif
        @if($orders!==null)
        <script>
            $(document).ready(function(){
                var datas = {!! json_encode($orders) !!}; // Pastikan $orders adalah array PHP

                datas.forEach(function(data){
                    console.log('nomor: ' + data.id_order);
                    console.log('nama gambar: ' + data.image_order);
                });
            });
        </script>
        @endif
    </table>

    {!! $orders->links() !!}

@endsection
<script type="text/javascript">
    $('#searchOrder').on('keyup', function()
    {
        var query=$(this).val();
        $jQuery.ajax({
            url:"{{route('orders.find')}}",
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