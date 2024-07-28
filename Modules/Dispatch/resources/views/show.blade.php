@extends("adminlte3.layouts.app")

@pushOnce('css')
    <style></style>
@endpushonce
@section('title', "Adminlte3")
@section("content")

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Inventory Detail Of {{$inventory['id']}}</h3>
        </div>
        <div class="card-body">

            <ul class="list-group">
                <li class="list-group-item">
                    <strong>İD:</strong> {{ $inventory['id'] }}
                </li>
                <li class="list-group-item">
                    <strong>WareHouse Name</strong> {{ $inventory['ware_house']['name'] }}
                </li>
                <li class="list-group-item">
                    <strong>Created At:</strong> {{ $inventory['created_at'] }}
                </li>
                <li class="list-group-item">
                    <strong>Created At:</strong> {{ $inventory['updated_at'] }}
                </li>



            </ul>
        </div>
    </div>
    @foreach($inventory['dispatch_statuses'] as $item)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Inventory Details</h3>
            </div>
            <div class="card-body">

                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Dispatch Status:</strong> {{ $item['status'] }}
                    </li>
                    <li class="list-group-item">
                        <strong>Created At:</strong> {{ $item['created_at'] }}
                    </li>
                    <li class="list-group-item">
                        <strong>Created At:</strong> {{ $item['updated_at'] }}
                    </li>


                </ul>
            </div>
        </div>

    @endforeach
@endsection

@pushOnce('scripts')
    <script>
    $(document).ready(function () {
        $('#inventoryDetails').DataTable({
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
