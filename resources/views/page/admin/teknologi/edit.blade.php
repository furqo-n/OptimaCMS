@extends('layouts.base_admin.base_dashboard') @section('judul', 'Edit Teknologi')

@section('script_head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Teknologi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('teknologi.index') }}">Teknologi</a></li>
                        <li class="breadcrumb-item active">Edit Teknologi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <form method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Teknologi</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Nama Teknologi</label>
                                <input type="text" id="nama" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $teknologi->nama) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea id="deskripsi" name="deskripsi"
                                    class="form-control @error('deskripsi') is-invalid @enderror" rows="4"
                                    required>{{ old('deskripsi', $teknologi->deskripsi) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="logo">Logo Teknologi (Kosongkan jika tidak ingin mengubah)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/*">
                                    <label class="custom-file-label" for="logo">Pilih file</label>
                                </div>
                                @if($teknologi->logo)
                                    <div class="mt-2 text-center">
                                        <img src="{{ asset('storage/teknologi/' . $teknologi->logo) }}" width="150px"
                                            class="img-thumbnail">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('teknologi.index') }}" class="btn btn-secondary">Cancel</a>
                    <input type="submit" value="Simpan Perubahan" class="btn btn-warning float-right">
                </div>
            </div>
        </form>
    </section>
@endsection

@section('script_footer')
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#deskripsi').summernote({
                placeholder: 'Masukkan deskripsi di sini...',
                tabsize: 2,
                height: 300
            });
            bsCustomFileInput.init();
        });
    </script>
@endsection