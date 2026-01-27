@extends('layouts.base_admin.base_dashboard') @section('judul', 'Tambah Klien') @section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Klien</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('klien.index') }}">Klien</a></li>
                        <li class="breadcrumb-item active">Tambah Klien</li>
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
        <form method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Klien</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Nama Klien</label>
                                <input type="text" id="nama" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    placeholder="Masukkan Nama Klien" value="{{ old('nama') }}" required>
                                @error('nama') <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select name="kategori" id="kategori"
                                    class="form-control @error('kategori') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Pemerintahan">Pemerintahan</option>
                                    <option value="Fasilitas Kesehatan">Fasilitas Kesehatan</option>
                                    <option value="Pendidikan">Pendidikan</option>
                                    <option value="Swasta">Swasta</option>
                                </select>
                                @error('kategori') <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="logo">Logo Klien</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('logo') is-invalid @enderror"
                                        id="logo" name="logo" accept="image/*">
                                    <label class="custom-file-label" for="logo">Pilih file</label>
                                </div>
                                @error('logo') <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('klien.index') }}" class="btn btn-secondary">Cancel</a>
                    <input type="submit" value="Tambah Klien" class="btn btn-success float-right">
                </div>
            </div>
        </form>
    </section>
@endsection

@section('script_footer')
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endsection