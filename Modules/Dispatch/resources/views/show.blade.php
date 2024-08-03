@extends("adminlte3.layouts.app")

@pushOnce('css')
    <style></style>
@endpushonce
@section('title', "Adminlte3")
@section("content")
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Dispatch Detail Of {{$inventory['id']}}</h3>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>İD:</strong> {{ $inventory['id'] }}
                </li>
                <li class="list-group-item">
                    <strong>From Name:</strong> {{ $inventory['ware_house']['name'] }}
                </li>
                <li class="list-group-item">
                    <strong>To Name:</strong> {{ $inventory['branch']['name'] }}
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
                        <th>Created At</th>
                        <th>Dispatch Status</th>
                        <th>Updated At</th>
                        <th>Causer Type</th>
                        <th>Causer Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventory['dispatch_statuses'] as $item)
                        <tr>
                            <td>{{ $item['created_at'] }}</td>
                            <td>{{ $item['status'] }}</td>
                            <td>{{ $item['updated_at'] }}</td>
                            <td>{{ $item['causer_type'] }}</td>
                            <td>{{ $item['causerDetails']['causer']['name'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Set New Status</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('dispatch.status.change', ['id' => $inventory['id']]) }}" method="POST">
                @csrf
                <select name="status" id="status" class="form-control">
                    @foreach($dispatchStatusEnums as $case)
                        <option value="{{ $case->name }}" @if($case->name == collect($inventory['dispatch_statuses'])->last()['status'])
                                                              selected
                        @endif>{{ $case->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="mt-2 btn btn-primary">Set Status</button>

            </form>

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
