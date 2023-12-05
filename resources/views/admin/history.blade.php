@extends('admin.master_admin')

@section('home_admin')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">History Admin</h5>

                <!-- Table with hoverable rows -->
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama Admin</th>
                            <th scope="col">Waktu</th>
                            <th scope="col">Jabatan</th>
                            <!--<th scope="col">Data terakhir yang diubah/ tambah</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($history as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}.</th>
                                <td>{{ $item->nama_admin }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->waktu_login)->format('d F Y, H:i:s') }}</td>
                                <td>{{ $item->jabatan }}</td>
                                <!--<td> Melakukan penambahan/pengubahan pada data-->
                                <!--    '@foreach ($video as $items)-->
                                <!--        {{ $items->nama_video }}-->
                                <!--        @endforeach' @foreach ($foto as $items)-->
                                <!--            {{ $items->nama_foto }}-->
                                <!--        @endforeach-->
                                <!--</td>-->
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        {{ $history->links() }}
                    </ul>
                </nav>
                <!-- End Table with hoverable rows -->

            </div>
        </div>
    </div>
@endsection
{{-- <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Table with hoverable rows</h5>

                    <!-- Table with hoverable rows -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Position</th>
                                <th scope="col">Age</th>
                                <th scope="col">Start Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Brandon Jacob</td>
                                <td>Designer</td>
                                <td>28</td>
                                <td>2016-05-25</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Bridie Kessler</td>
                                <td>Developer</td>
                                <td>35</td>
                                <td>2014-12-05</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Ashleigh Langosh</td>
                                <td>Finance</td>
                                <td>45</td>
                                <td>2011-08-12</td>
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>Angus Grady</td>
                                <td>HR</td>
                                <td>34</td>
                                <td>2012-06-11</td>
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>Raheem Lehner</td>
                                <td>Dynamic Division Officer</td>
                                <td>47</td>
                                <td>2011-04-19</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- End Table with hoverable rows -->

                </div>
            </div>
        </div> --}}
