@extends("adminlte3.layouts.app")

@pushOnce('css')
    <style></style>
@endpushonce
@section('title', "Adminlte3")
@section("content")
    @if(count($dispatches) === 0)

        <div class="alert alert-info">
            There is no waiting dispatches
        </div>

    @else
        @foreach($dispatches as $dispatch)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Inventory Details</h3>
                </div>
                <div class="card-body">
                    <p>Branch requesting products: {{ \Modules\Branch\App\Models\Branch::query()->findOrFail($dispatch->branch_id)->name }}</p>
                    <p>Created At: {{ $dispatch->created_at }}</p>
                    <p>Updated At: {{ $dispatch->updated_at }}</p>

                    <table id="waitingDispatchesList-{{$dispatch['id']}}" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dispatch->normalizedStockAndAmount as $amount => $stock)
                                <tr>
                                    <td>{{ $stock['stock']['id'] }}</td>
                                    <td>{{ $stock['stock']['name'] }}</td>
                                    <td>{{ $stock['stock']->stockUnit->name }}</td>
                                    <td>{{ $amount }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif

@endsection

@pushOnce('scripts')
    <script>
    $(document).ready(function () {
        @if(count($dispatches) !== 0)
        @foreach($dispatches as $dispatche)
        $('#waitingDispatchesList-{{$dispatche['id']}}').DataTable({
            'paging': true,
            'lengthChange': false,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            'responsive': true,
        })
        @endforeach
        @endif
    })
    </script>
@endpushonce
