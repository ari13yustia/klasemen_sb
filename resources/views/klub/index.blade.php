@extends('layouts.app')
@section('title','Klasemen')
@section('content')

<div class="row">
    <div class="col-lg-6">
        <h4>Data Klub</h4>
    </div>
    <div class="col-lg-6 text-end">
        <a href="{{url('/')}}" class="btn btn-secondary">Kembali</a>
    </div>
    <hr class="mt-2">
    <form action="{{url('klub')}}" method="POST" class="mt-2">
        @csrf
        <h5>Tambah Klub</h5>
        <div class="row">
            <div class="col-lg-5">
                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukan Nama Klub" value="{{old('nama')}}">
                @error('nama')
                    <div class="text-danger">*{{$message}}</div>
                @enderror
            </div>
            <div class="col-lg-5">
                <input type="text" name="kota" id="kota" class="form-control @error('kota') is-invalid @enderror" placeholder="Masukan Kota Klub" value="{{old('kota')}}">
                @error('kota')
                    <div class="text-danger">*{{$message}}</div>
                @enderror
            </div>
            <div class="col-lg-2">
                <button type="submit" class="btn btn-success w-100">Tambah</button>
            </div>
        </div>
    </form>
</div>
<hr>
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
@endif
<table class="table table-striped table-bordered">
    <thead>
        <tr>
        <th scope="col" class="w-10">#</th>
        <th scope="col" class="w-30">Nama Klub</th>
        <th scope="col" class="w-30">Kota</th>
        <th scope="col" class="w-10">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($klub as $key => $row)
            <tr>
                <th scope="row">{{$key+1}}</th>
                <td>{{$row->nama}}</td>
                <td>{{$row->kota}}</td>
                <td>
                    <form action="{{url('klub/'.$row->id)}}" method="POST">
                        @csrf
                        @method("DELETE")

                        <input class="btn btn-danger" type="button" id="delete-klub{{$key}}" value="Hapus">
                        <script>
                            $('#delete-klub{{$key}}').on('click',function(e){
                                e.preventDefault();
                                if(confirm('Apa kamu yakin ingin menghapus {{$row->nama}}?')){
                                    $(e.target).closest('form').submit();
                                }
                            });
                        </script>
                    </form>
            </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
