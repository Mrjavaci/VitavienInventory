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
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Stock Detail</h3>
        </div>
        <div class="card-body">
            <table id="dispatchStockDetail" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Stock Unit</th>
                        <th>Stock Name</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventory['stocksAndAmounts'] as $key=>$stockData)
                        <tr>
                            <td>{{ $stockData['amount'] }}</td>
                            <td>{{ $stockData['stock']->stockUnit->name }}</td>
                            <td>{{ $stockData['stock']->name }}</td>
                            <td>{{ $stockData['stock']->created_at }}</td>
                            <td>{{ $stockData['stock']->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Status Change Detail</h3>
        </div>
        <div class="card-body">


            <table id="dispatchStatusChangeList" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Dispatch Status</th>
                        <th>Created At:</th>
                        <th>Updated At:</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventory['dispatch_statuses'] as $item)
                        <tr>
                            <td>{{ $item['status'] }}</td>
                            <td>{{ $item['created_at'] }}</td>
                            <td>{{ $item['updated_at'] }}</td>
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
        $('#dispatchStockDetail').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'responsive': true,
        })
        $('#dispatchStatusChangeList').DataTable({
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
