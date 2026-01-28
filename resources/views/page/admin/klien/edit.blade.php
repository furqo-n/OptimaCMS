@extends('layouts.base_admin.base_dashboard') @section('judul', 'Edit Klien') @section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Klien</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('klien.index') }}">Klien</a></li>
                        <li class="breadcrumb-item active">Edit Klien</li>
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
                            <h3 class="card-title">Informasi Klien</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Nama Klien</label>
                                <input type="text" id="nama" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $klien->nama) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select name="kategori" id="kategori"
                                    class="form-control @error('kategori') is-invalid @enderror" required>
                                    <option value="Pemerintahan" {{ $klien->kategori == 'Pemerintahan' ? 'selected' : '' }}>
                                        Pemerintahan</option>
                                    <option value="Fasilitas Kesehatan" {{ $klien->kategori == 'Fasilitas Kesehatan' ? 'selected' : '' }}>Fasilitas Kesehatan</option>
                                    <option value="Pendidikan" {{ $klien->kategori == 'Pendidikan' ? 'selected' : '' }}>
                                        Pendidikan</option>
                                    <option value="Swasta" {{ $klien->kategori == 'Swasta' ? 'selected' : '' }}>Swasta
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="logo">Logo Klien (Kosongkan jika tidak ingin mengubah)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/*">
                                    <label class="custom-file-label" for="logo">Pilih file</label>
                                </div>
                                @if($klien->logo)
                                    <div class="mt-2 text-center">
                                        <img src="{{ filter_var($klien->logo, FILTER_VALIDATE_URL) ? $klien->logo : asset('storage/klien/' . $klien->logo) }}"
                                            width="150px" class="img-thumbnail">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('klien.index') }}" class="btn btn-secondary">Cancel</a>
                    <input type="submit" value="Simpan Perubahan" class="btn btn-warning float-right">
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