@extends('layouts.app')

@section('content')
<div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary" href="{{ route('orders.index') }}">Back</a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <img src="data:image/jpeg;base64,{{ base64_encode($data['content']) }}" class="img-fluid" alt="Gambar">
            </div>
            <div class="col-md-6">
                <p>nama foto : {{$data['id']}}</p>
                <a id="downloadLink" type="button" href="{{ route('order.download', ['id_order' => $data['id']]) }}">Download</a>
            </div>
        </div>
    </div>
@endsection