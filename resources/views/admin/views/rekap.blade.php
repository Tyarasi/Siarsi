@extends('admin.master_admin')

@section('home_admin')
    <style>
        .card-table {
            margin-bottom: 30px;
            border: none;
            border-radius: 5px;
            box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
            display: inline-block;
            width: auto;
            /* atau width: fit-content; */
        }

        .card-body-table {
            padding: 0 20px 20px 20px;
            overflow-x: auto;
        }

        .card-title-table {
            padding: 20px 0 15px 0;
            font-size: 18px;
            font-weight: 500;
            color: #012970;
            font-family: "Poppins", sans-serif;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        .table th {
            font-weight: bold;
            background-color: #f0f0f0;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tfoot th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: right;
        }
    </style>

    <div class="card-table">
        <div class="card-body-table">
            <h5 class="card-title-table">Rekapitulasi Upload Kegiatan</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Kategori Kegiatan</th>
                            <th scope="col">Jan</th>
                            <th scope="col">Feb</th>
                            <th scope="col">Mar</th>
                            <th scope="col">Apr</th>
                            <th scope="col">Mei</th>
                            <th scope="col">Jun</th>
                            <th scope="col">Jul</th>
                            <th scope="col">Agust</th>
                            <th scope="col">Sept</th>
                            <th scope="col">Okt</th>
                            <th scope="col">Nov</th>
                            <th scope="col">Des</th>
                            <th scope="col">Total Pertahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $rowspan = [];
                            $no = 1;
                        @endphp
                        @foreach ($rekap as $index => $data)
                            @php
                                $rowspan[$data->nama_kategori] ??= 0;
                                $rowspan[$data->nama_kategori]++;
                            @endphp
                            @if ($rowspan[$data->nama_kategori] === 1)
                                <tr>
                                    <th scope="row" rowspan="{{ $rowspan[$data->nama_kategori] }}">{{ $no++ }}
                                    </th>
                                    <td rowspan="{{ $rowspan[$data->nama_kategori] }}">{{ $data->nama_kategori }}</td>
                                    <td>{{ $totalPerBulan[$data->nama_kategori][1] ?? '-' }}</td>
                                    <td>{{ $totalPerBulan[$data->nama_kategori][2] ?? '-' }}</td>
                                    <td>{{ $totalPerBulan[$data->nama_kategori][3] ?? '-' }}</td>
                                    <td>{{ $totalPerBulan[$data->nama_kategori][4] ?? '-' }}</td>
                                    <td>{{ $totalPerBulan[$data->nama_kategori][5] ?? '-' }}</td>
                                    <td>{{ $totalPerBulan[$data->nama_kategori][6] ?? '-' }}</td>
                                    <td>{{ $totalPerBulan[$data->nama_kategori][7] ?? '-' }}</td>
                                    <td>{{ $totalPerBulan[$data->nama_kategori][8] ?? '-' }}</td>
                                    <td>{{ $totalPerBulan[$data->nama_kategori][9] ?? '-' }}</td>
                                    <td>{{ $totalPerBulan[$data->nama_kategori][10] ?? '-' }}</td>
                                    <td>{{ $totalPerBulan[$data->nama_kategori][11] ?? '-' }}</td>
                                    <td>{{ $totalPerBulan[$data->nama_kategori][12] ?? '-' }}</td>
                                    <td>{{ array_sum($totalPerBulan[$data->nama_kategori]) ?? 0 }}</td>

                                </tr>
                            @else
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="13"></td>
                            <td>Total Keseluruhan</td>
                            <td>{{ array_sum($totalPerTahun) ?? 0 }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
