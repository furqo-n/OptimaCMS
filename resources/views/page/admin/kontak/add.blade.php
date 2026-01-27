@extends('layouts.base_admin.base_dashboard') @section('judul', 'Tambah Kontak')

@section('script_head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Kontak</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kontak.index') }}">Kontak</a></li>
                        <li class="breadcrumb-item active">Tambah Kontak</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        @if(session('status'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('status') }}
            </div>
        @endif
        <form method="post" action="{{ route('kontak.add') }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Kontak Office</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="office">Nama Office / Cabang</label>
                                <input type="text" id="office" name="office"
                                    class="form-control @error('office') is-invalid @enderror"
                                    placeholder="Contoh: Kantor Pusat" value="{{ old('office') }}" required>
                                @error('office') <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat Lengkap</label>
                                <textarea id="alamat" name="alamat"
                                    class="form-control @error('alamat') is-invalid @enderror" rows="4"
                                    required>{{ old('alamat') }}</textarea>
                                @error('alamat') <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="no_hp">No. HP / Telepon</label>
                                <input type="text" id="no_hp" name="no_hp"
                                    class="form-control @error('no_hp') is-invalid @enderror"
                                    placeholder="Contoh: 08123456789" value="{{ old('no_hp') }}" required>
                                @error('no_hp') <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Contoh: office@perusahaan.com" value="{{ old('email') }}" required>
                                @error('email') <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('kontak.index') }}" class="btn btn-secondary">Cancel</a>
                    <input type="submit" value="Tambah Kontak" class="btn btn-success float-right">
                </div>
            </div>
        </form>
    </section>
@endsection

@section('script_footer')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#alamat').summernote({
                placeholder: 'Masukkan alamat lengkap di sini...',
                tabsize: 2,
                height: 150
            });
        });
    </script>
@endsection