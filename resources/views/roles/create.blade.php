@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Tambah Role Baru</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary form-control" href="{{ route('roles.index') }}"> Back</a>
        </div>
    </div>
</div>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
<div class="form-row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="name" >Role name :</label>
            {!! Form::text('name', null, array('id'=>'name','placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="permission">Permission :</label>
            <br/>
            @foreach($permission as $value)
                <label class="form-check-label">
                {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                {{ $value->name }}</label>
            <br/>
            @endforeach
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary form-control">Submit</button>
    </div>
</div>
{!! Form::close() !!}

@endsection