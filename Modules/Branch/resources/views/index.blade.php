@extends("adminlte3.layouts.app")

@pushOnce('css')
    <style></style>
@endpushonce
@section('title', "Adminlte3")
@section("content")

    @php
    $pageTitle = $name;
    @endphp


    <div class="mb-3">
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Address:</strong> {{ $address }}
            </li>
            <li class="list-group-item">
                <strong>Phone:</strong> {{ $phone }}
            </li>
            <li class="list-group-item">
                <strong>Email:</strong> {{ $email }}
            </li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Inventory Details</h3>
        </div>
        <div class="card-body">
            <table id="inventoryDetails" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Inventory Type</th>
                    <th>Stock ID</th>
                    <th>Amount</th>
                    <th>Stock Name</th>
                </tr>
                </thead>
                <tbody>
                @foreach($inventory as $item)
                    <tr>
                        <td>{{ $item['id'] }}</td>
                        <td>{{ $item['InventoryType'] }}</td>
                        <td>{{ $item['stock_id'] }}</td>
                        <td>{{ $item['amount'] }}</td>
                        <td>
                            @foreach($item['stock'] as $stockItem)
                                {{ $stockItem['name'] }}
                                {{ $stockItem['stock_unit']['name'] }}
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@pushOnce('scripts')
    <script>
        $(document).ready(function() {
            $('#inventoryDetails').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endpushonce
