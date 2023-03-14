@extends('layouts.app')
@section('title','Klasemen')
@section('content')

<div class="row">
    <div class="col-lg-6">
        <h4>Input Skor</h4>
    </div>
    <div class="col-lg-6 text-end">
        <a href="{{url('/')}}" class="btn btn-secondary">Kembali</a>
    </div>
    <hr class="mt-2">
    <form action="{{url('/')}}" method="POST" class="mt-2">
        @csrf
        <div class="klasemen">
            <div class="row">
                <div class="col-lg-4">
                    <select name="klub1[]" id="" class="form-select @error('klub1') is-invalid @enderror">
                        @foreach ($klub as $row)
                            <option value="{{$row->id}}">{{$row->nama}}</option>
                        @endforeach
                    </select>
                    @error('klub1')
                        <div class="text-danger">*{{$message}}</div>
                    @enderror
                </div>
                <div class="col-lg-2">
                    <input type="number" name="skor1[]" id="nama" class="form-control @error('skor1') is-invalid @enderror" placeholder="Skor" value="{{old('skor1')}}">
                    @error('skor1')
                        <div class="text-danger">*{{$message}}</div>
                    @enderror
                </div>
                <div class="col-lg-4">
                    <select name="klub2[]" id="" class="form-select @error('klub2') is-invalid @enderror">
                        @foreach ($klub as $row)
                            <option value="{{$row->id}}">{{$row->nama}}</option>
                        @endforeach
                    </select>
                    @error('klub2')
                        <div class="text-danger">*{{$message}}</div>
                    @enderror
                </div>
                <div class="col-lg-2">
                    <input type="number" name="skor2[]" id="kota" class="form-control @error('skor2') is-invalid @enderror" placeholder="Skor" value="{{old('skor2')}}">
                    @error('skor2')
                        <div class="text-danger">*{{$message}}</div>
                    @enderror
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-6">
                <button type="button" id="add-field" class="btn btn-primary">Tambah Field</button>
            </div>
            <div class="col-lg-6 text-end">
                <button type="submit" class="btn btn-success">Simpan</button>
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
        <tr class="text-center">
            <th scope="col" class="w-10">#</th>
            <th scope="col" class="w-25">Kode Klasemen</th>
            <th scope="col" class="w-55">Skor</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($klasemen as $key => $row)
        <tr class="text-center">
            <th scope="row">{{$key+1}}</th>
            <td>{{$row->kode_klasemen}}</td>
            <td>{{$row->klasemen_detail->first()->klub->nama.' ( '.$row->klasemen_detail->first()->skor.' vs '.$row->klasemen_detail->last()->skor.' ) '
            .$row->klasemen_detail->last()->klub->nama}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
@section('custom_script')
<script>
    $('#add-field').on('click', function () {
        let field = `
        <div class="row mt-2">
            <div class="col-lg-4">
                <select name="klub1[]" id="" class="form-select @error('klub1') is-invalid @enderror">
                    @foreach ($klub as $row)
                        <option value="{{$row->id}}">{{$row->nama}}</option>
                    @endforeach
                </select>
                @error('klub1')
                    <div class="text-danger">*{{$message}}</div>
                @enderror
            </div>
            <div class="col-lg-2">
                <input type="number" name="skor1[]" id="nama" class="form-control @error('skor1') is-invalid @enderror" placeholder="Skor" value="{{old('skor1')}}">
                @error('skor1')
                    <div class="text-danger">*{{$message}}</div>
                @enderror
            </div>
            <div class="col-lg-4">
                <select name="klub2[]" id="" class="form-select @error('klub2') is-invalid @enderror">
                    @foreach ($klub as $row)
                        <option value="{{$row->id}}">{{$row->nama}}</option>
                    @endforeach
                </select>
                @error('klub2')
                    <div class="text-danger">*{{$message}}</div>
                @enderror
            </div>
            <div class="col-lg-2">
                <input type="number" name="skor2[]" id="kota" class="form-control @error('skor2') is-invalid @enderror" placeholder="Skor" value="{{old('skor2')}}">
                @error('skor2')
                    <div class="text-danger">*{{$message}}</div>
                @enderror
            </div>
        </div>`;
        $('.klasemen').append(field);
    });
</script>
@endsection
