@extends("adminlte3.layouts.app")

@pushOnce('css')
    <style></style>
@endpushonce
@section('title', "Adminlte3")
@section("content")
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Dispatch List</h3>
            <a href="{{ route('dispatch.create') }}">
                <button type="button" class="btn btn-success float-right"><i class="far fa-plus-square"></i> Make Dispatch</button>
            </a>
        </div>
        <div class="card-body">

            <table id="dispatchList" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>İD</th>
                        <th>WareHouse Name</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Last Status</th>
                        <th>Detail:</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $inventory)
                        <tr>
                            <td>{{ $inventory['id'] }}</td>
                            <td>{{ $inventory['ware_house']['name'] }}</td>
                            <td>{{ $inventory['created_at'] }}</td>
                            <td>{{ $inventory['updated_at']  }}</td>
                            <td>{{ $inventory['lastStatus'] }}</td>
                            <td><a href="{{ route('dispatch.show', $inventory['id']) }}">Detail</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@pushOnce('scripts')
    <script>
    $(document).ready(function () {
        $('#dispatchList').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'responsive': true,
        })
    })
    </script>
@endpushonce
