@extends('layouts.base_admin.base_dashboard') @section('judul', 'Ubah Gambar') @section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Ubah Gambar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('gambar.index') }}">Gambar</a></li>
                        <li class="breadcrumb-item active">Ubah Gambar</li>
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
        <form method="post" action="{{ route('gambar.edit', $gambar->id) }}" enctype="multipart/form-data">
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
                                    <option value="Hero" {{ $gambar->kategori == 'Hero' ? 'selected' : '' }}>Hero</option>
                                    <option value="Logo" {{ $gambar->kategori == 'Logo' ? 'selected' : '' }}>Logo</option>
                                    <option value="Text" {{ $gambar->kategori == 'Text' ? 'selected' : '' }}>Text</option>
                                    <option value="Footer" {{ $gambar->kategori == 'Footer' ? 'selected' : '' }}>Footer
                                    </option>
                                    <option value="TK_1" {{ $gambar->kategori == 'TK_1' ? 'selected' : '' }}>TK_1</option>
                                    <option value="TK_2" {{ $gambar->kategori == 'TK_2' ? 'selected' : '' }}>TK_2</option>
                                    <option value="TK_visi" {{ $gambar->kategori == 'TK_visi' ? 'selected' : '' }}>TK_visi
                                    </option>
                                    <option value="TK_misi" {{ $gambar->kategori == 'TK_misi' ? 'selected' : '' }}>TK_misi
                                    </option>
                                    <option value="PAW_1" {{ $gambar->kategori == 'PAW_1' ? 'selected' : '' }}>PAW_1</option>
                                    <option value="PAW_2" {{ $gambar->kategori == 'PAW_2' ? 'selected' : '' }}>PAW_2</option>
                                    <option value="PAW_3" {{ $gambar->kategori == 'PAW_3' ? 'selected' : '' }}>PAW_3</option>
                                    <option value="PAM_1" {{ $gambar->kategori == 'PAM_1' ? 'selected' : '' }}>PAM_1</option>
                                    <option value="PAM_2" {{ $gambar->kategori == 'PAM_2' ? 'selected' : '' }}>PAM_2</option>
                                    <option value="PAM_3" {{ $gambar->kategori == 'PAM_3' ? 'selected' : '' }}>PAM_3</option>
                                    <option value="TPLK_1" {{ $gambar->kategori == 'TPLK_1' ? 'selected' : '' }}>TPLK_1
                                    </option>
                                    <option value="TPLK_2" {{ $gambar->kategori == 'TPLK_2' ? 'selected' : '' }}>TPLK_2
                                    </option>
                                </select>
                                @error('kategori') <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="gambar">Gambar</label>
                                <br>
                                @if($gambar->gambar)
                                    <img src="{{ asset('storage/gambar/' . $gambar->gambar) }}" alt="Preview"
                                        style="max-width: 200px; margin-bottom: 10px;">
                                @endif
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
                    <input type="submit" value="Ubah Gambar" class="btn btn-success float-right">
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