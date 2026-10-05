@extends('layouts.app')

@section('title', 'Edit Berita')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-berita">
            <div class="filter-header">
                <i class="bi bi-pencil-square me-1"></i> Edit Berita
            </div>
            <div class="card-body">
                <form action="{{ route('berita.update', $berita) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul</label>
                        <input type="text" name="judul" id="judul" class="form-control"
                               value="{{ old('judul', $berita->judul) }}">
                        @error('judul') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">Kategori</label>
                        <select name="kategori" id="kategori" class="form-select">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach (['Olahraga', 'Pendidikan', 'Potensi', 'Pembangunan'] as $k)
                                <option value="{{ $k }}" @selected(old('kategori', $berita->kategori) == $k)>{{ $k }}</option>
                            @endforeach
                        </select>
                        @error('kategori') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label fw-semibold">Gambar Berita</label>

                        @if ($berita->gambar)
                            <div class="mb-2">
                                <img src="{{ asset('images/berita/' . $berita->gambar) }}"
                                    alt="{{ $berita->judul }}"
                                    style="width: 200px; height: 120px; object-fit: cover; border-radius: 8px;">
                            </div>
                        @endif

                        <input type="file"
                            name="gambar"
                            id="gambar"
                            class="form-control"
                            accept="image/*">

                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti gambar.
                        </small>

                        @error('gambar')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="isi" class="form-label fw-semibold">Isi Berita</label>
                        <textarea name="isi" id="isi" rows="6" class="form-control">{{ old('isi', $berita->isi) }}</textarea>
                        @error('isi') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="bi bi-eye"></i> Dilihat {{ $berita->views }} kali •
                            Terakhir diubah {{ $berita->updated_at->diffForHumans() }}
                        </small>
                    </div>

                    <div class="d-flex gap-2 pt-2 border-top mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update
                        </button>
                        <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
