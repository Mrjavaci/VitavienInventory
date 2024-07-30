<div class="form-group">

    <label>Select WareHouse</label>
    <select class="form-control selectWareHouse">
        <option value="0">Please Select</option>
        @foreach($warehouses as $warehouse)
            <option value="{{ $warehouse['id'] }}">{{ $warehouse['name'] }}</option>
        @endforeach
    </select>

    <br>
    <label>Stock List</label>

    <table id="stocksAndAmounts" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>StockId</th>
                <th>Stock Name</th>
                <th>Amount</th>
                <th>Stock Total Amount</th>
                <th>Remaining After Dispatch</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <label>Add Stock</label>

    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Add Stock</h3>
        </div>
        <div class="card-body">
            @csrf
            <div class="form-group">
                <label>Select Stock</label>
                <select class="form-control selectStock">

                </select>
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="text" name="amount" class="form-control amount">
            </div>

            <div class="form-group stockInfo">
                <label>Info</label>

            </div>

            <div class="form-group">
                <div class="btn btn-success addShipping">Add Shipping</div>
            </div>

        </div>
    </div>

</div>

@pushOnce('scripts')
    <script>
    let Toast = Swal.mixin({
        toast: false,
        position: 'top',
        showConfirmButton: false,
        timer: 3000
    })

    let stockList = @json($stocks);
    let warehouseList = @json($warehouses);

    $('#stocksAndAmounts').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false,
        'responsive': true,
    })

    $('.selectWareHouse').on('change', function () {
        let warehouseId = $('.selectWareHouse').val()
        let wareHouse = warehouseList.find(warehouse => warehouse['id'] === parseInt(warehouseId))

        let table = $('#stocksAndAmounts').DataTable()
        table.clear()
        if (wareHouse['inventory'].length === 0) {

            Toast.fire({
                icon: 'error',
                title: 'No Stock Found'
            })
            return
        }

        wareHouse['inventory'].forEach(inventory => {
            $('.selectStock').append(`<option value="${inventory['stock'][0]['id']}">${inventory['stock'][0]['name']}</option>`)
        })

    })

    $('.amount').on('input', function () {

        if($('input[name="amount"]').val() === '') return
        let stockId = $('.selectStock').val()
        let wareHouseId = $('.selectWareHouse').val()
        let wareHouse = warehouseList.find(warehouse => warehouse['id'] === parseInt(wareHouseId))
        let amount = parseInt($('input[name="amount"]').val())
        if (isNaN(amount)) {
            Toast.fire({
                icon: 'error',
                title: 'Invalid Amount'
            })
            $('input[name="amount"]').val(0);

            return
        }

        wareHouse['inventory'].forEach(inventory => {

            if ((inventory['amount'] - amount) < 0) {
                Toast.fire({
                    icon: 'error',
                    title: 'Stock Not Available'
                })
                $('input[name="amount"]').val(0);
                return
            }

            if (inventory['stock'][0]['id'] === parseInt(stockId)) {
                let html = `<p>Unit: ${inventory['stock'][0]['stock_unit']['name']}</p>`
                html += `<p>Total Amount: ${inventory['amount']}</p>`
                html += `<p>Remaining Amount After Dispatch: ${inventory['amount'] - amount}</p>`

                $('.stockInfo').html(html)
            }
        })
    })
    $('.addShipping').on('click', function () {

        let stockId = $('.selectStock').val()
        let amount = $('input[name="amount"]').val()

        let stock = stockList.find(stock => stock['id'] === parseInt(stockId))
        console.log(stock, stockId)
        let table = $('#stocksAndAmounts').DataTable()

        table.row.add([
            stockId,
            stock['name'],
            amount,
            stock['stockTotalAmount'],
            stock['stockTotalAmount'] - amount
        ]).draw()
    })


    </script>
@endpushonce
