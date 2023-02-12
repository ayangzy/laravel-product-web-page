<div class="table-responsive">
    <table class="table table-striped" id="tableData">
        <thead class="bg-primary text-white">

            <tr>
                <td><strong> Product name </strong></td>
                <td class="text-center"><strong> Quantity in stock</strong></td>
                <td class="text-center"><strong>Price per item</strong></td>
                <td class="text-right"><strong>Total value number</strong></td>
                <td class="text-center"><strong>Datetime submitted</strong></td>
                <td class="text-center"><strong>Action</strong></td>
            </tr>
        </thead>
        <tbody>
            @if(file_exists('product_data.xml') && filesize('product_data.xml') != 0)
            @if (is_array($products) && count($products) > 0)
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->product_name }}</td>
                <td class="text-center">{{ $product->quantity_in_stock }}</td>
                <td class="text-center">${{ number_format(floatval($product->price_per_item), 2 )}}</td>
                <td class="text-center">${{number_format($product->price_per_item * $product->quantity_in_stock, 2) }}</td>
                <td>{{ $product->datetime }}</td>
                <td><button class="btn btn-info fa fa-edit edit-btn" data-id="{{ $product->id }}" data-product-name="{{ $product->product_name }}" data-quantity-in-stock="{{ $product->quantity_in_stock }}" data-price-per-item="{{ $product->price_per_item }}">Edit</button>
                </td>
            </tr>
            @endforeach
            @endif
            @else

            <td colspan="6" class="text-center">There are currently no products</td>

            @endif
            <tr>
                <td colspan="2"></td>

                <td class="text-center"><strong>Total</strong></td>
                <td class="text-center"><strong>${{ number_format(floatval($totalValueSum), 2)}}</strong></td>
                <td></td>
                <td></td>
            </tr>


        </tbody>
    </table>
</div>
