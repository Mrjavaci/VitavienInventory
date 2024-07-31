@extends("adminlte3.layouts.app")

@pushOnce('css')
    <style></style>
@endpushonce
@section('title', "Adminlte3")
@section("content")


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Inventory Details</h3>
        </div>
        <div class="card-body">
            <table id="waitingDispatchesList" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Stock Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventory as $item)
                        <tr>
                            <td>{{ $item['id'] }}</td>
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
    $(document).ready(function () {
        $('#waitingDispatchesList').DataTable({
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
