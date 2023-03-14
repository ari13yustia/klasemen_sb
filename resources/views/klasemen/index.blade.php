@extends('layouts.app')
@section('title','Klasemen')
@section('content')

<div class="row">
    <div class="col-lg-6">
        <h4>Data Klasemen</h4>
    </div>
    <div class="col-lg-6 text-end">
        <a href="{{url('klub')}}" class="btn btn-success">Data Klub</a>
        <a href="{{url('create')}}" class="btn btn-primary">Masukan Skor</a>
    </div>
</div>
<hr>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
        <th scope="col" class="w-5">#</th>
        <th scope="col" class="w-25">Nama Klub</th>
        <th scope="col" class="w-10">Ma</th>
        <th scope="col" class="w-10">Me</th>
        <th scope="col" class="w-10">S</th>
        <th scope="col" class="w-10">K</th>
        <th scope="col" class="w-10">GM</th>
        <th scope="col" class="w-10">GK</th>
        <th scope="col" class="w-10">Point</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $row)
        <tr>
            <th scope="row">{{$key+1}}</th>
            <td>{{$row['nama']}}</td>
            <td>{{$row['ma']}}</td>
            <td>{{$row['me']}}</td>
            <td>{{$row['s']}}</td>
            <td>{{$row['k']}}</td>
            <td>{{$row['gm']}}</td>
            <td>{{$row['gk']}}</td>
            <td>{{$row['point']}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
