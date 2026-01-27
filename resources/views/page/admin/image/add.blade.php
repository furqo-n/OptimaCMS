@extends('layouts.base_admin.base_dashboard') @section('judul', 'Tambah Gambar') @section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Gambar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('gambar.index') }}">Gambar</a></li>
                        <li class="breadcrumb-item active">Tambah Gambar</li>
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
        <form method="post" action="{{ route('gambar.add') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Gambar</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select name="kategori" id="kategori"
                                    class="form-control @error('kategori') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Hero">Hero</option>
                                    <option value="Logo">Logo</option>
                                    <option value="Text">Text</option>
                                    <option value="Footer">Footer</option>
                                    <option value="TK_1">TK_1</option>
                                    <option value="TK_2">TK_2</option>
                                    <option value="TK_visi">TK_visi</option>
                                    <option value="TK_misi">TK_misi</option>
                                    <option value="PAW_1">PAW_1</option>
                                    <option value="PAW_2">PAW_2</option>
                                    <option value="PAW_3">PAW_3</option>
                                    <option value="PAM_1">PAM_1</option>
                                    <option value="PAM_2">PAM_2</option>
                                    <option value="PAM_3">PAM_3</option>
                                    <option value="TPLK_1">TPLK_1</option>
                                    <option value="TPLK_2">TPLK_2</option>
                                </select>
                                @error('kategori') <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="gambar">Gambar</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('gambar') is-invalid @enderror"
                                        id="gambar" name="gambar" accept="image/*">
                                    <label class="custom-file-label" for="gambar">Pilih file</label>
                                </div>
                                @error('gambar') <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('gambar.index') }}" class="btn btn-secondary">Cancel</a>
                    <input type="submit" value="Tambah Gambar" class="btn btn-success float-right">
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