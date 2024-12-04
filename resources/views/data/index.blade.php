@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Kelola Sistem</h1>

    <div class="mb-3">
        <button class="btn btn-primary" onclick="window.location.href='{{ route('data.store') }}'">Tambah Data</button>
    </div>

    <div class="d-flex justify-content-between mb-4">
        <div>
            <strong>Jumlah Miskin:</strong> {{ $jumlahMiskin }} <br>
            <strong>Jumlah Kaya:</strong> {{ $jumlahKaya }}
        </div>
        <div>
            <input type="text" class="form-control" placeholder="Cari daerah...">
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Provinsi</th>
                <th>Kab/Kota</th>
                <th>Persentase Penduduk Miskin (%)</th>
                <th>Pengeluaran per Kapita</th>
                <th>Tingkat Pengangguran Terbuka</th>
                <th>Klasifikasi Kemiskinan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->provinsi }}</td>
                    <td>{{ $item->kab_kota }}</td>
                    <td>{{ $item->persentase_miskin }}</td>
                    <td>{{ $item->pengeluaran }}</td>
                    <td>{{ $item->tingkat_pengangguran }}</td>
                    <td>{{ $item->klasifikasi }}</td>
                    <td>
                        <a href="{{ route('data.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('data.destroy', $item->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
