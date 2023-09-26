@extends('layouts.app')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            <h2>Daftar Bukti Kemas</h2>
        </div>
        <form action="{{route('orders.find')}}" method="get">
            <div class="row">
                <div class="col-md-3 mb-3" >
                    <label for="searchOrder">cari no. :</label>
                    <input id="searchOrder" class="searchOrder form-control" type="text" placeholder="pencarian 3-4 digit dari depan dan belakang nomor" name="query">
                    <!-- <span id="userList"></span> -->
                </div>
                <div class="col-md-3 mb-3">
                    <label for="start_date">cari dari tanggal :</label>
                    <input type="date" class="form-control" id="start_date" name="start_date">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="end_date">sampai tanggal :</label>
                    <input type="date" class="form-control" id="end_date" name="end_date">
                </div>
                <div class="col-md-3 mb-3">
                    <input type="submit" class="form-control btn btn-secondary" value="Search">
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
        <th class="col-md">Date Created</th>
        <!-- <th>Tanggal Data Dimasukan</th> -->
        <th class="col-md" width="280dp">Action</th>
    </tr>
    @if (isset($orders)&&!empty($orders))
    @foreach ($orders as $order)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $order->id_order }}</td>
        <td>{{ $order->created_at }}</td>

        <!-- <td>{{ $order->created_at }}</td> -->
        <td>
            <form action="{{ route('orders.destroy',$order->id) }}" method="POST">
                <a class="btn btn-info" href="{{route('orders.view',['id_order'=>$order->id_order])}}">Lihat Foto</a>

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
</table>
{!! $orders->links() !!}
<script type="text/javascript" src="{{asset('js/live_search_ajax.js')}}"></script>

@endsection