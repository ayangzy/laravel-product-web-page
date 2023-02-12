<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Coalition Technologies Skills Test</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/jquery.3.2.1.min.js') }}"></script>

</head>
<body style="background: #ccc">
    <div class="wrapper">
        <nav class="navbar navbar-dark bg-primary justify-content-between mb-3">
            <a class="navbar-brand text-white">Coalition Technologies Skills Test</a>

        </nav>
        <div class="main-panel">
            <div class="container">
                <div class="page-inner">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-10 col-xl-12">

                            <div class="page-divider"></div>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="card">

                                        <div class="card-body">
                                            <div class="separator-solid"></div>

                                            <div class="row">

                                                <div class="col-md-12">
                                                    <form id="form-create" class="create-form">
                                                        <div class="form-group">
                                                            <label for="productName">Product name</label>
                                                            <input type="text" name="product_name" class="form-control" id="productName" placeholder="Enter product name" required>

                                                        </div>
                                                        <div class="form-group">
                                                            <label for="quantityInStock">Quantity in stock</label>
                                                            <input type="number" name="quantity_in_stock" class="form-control" id="quantityInStock" placeholder="Enter Quantity in stock" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="pricePerItem">Price per item</label>
                                                            <input type="number" name="price_per_item" class="form-control" id="pricePerItem" placeholder="Enter price per item" required>
                                                        </div>
                                                        <input type="hidden" id="hidden" value="">
                                                        <button type="submit" class="btn btn-primary" id="submit-btn">Save Product</button>

                                                    </form>
                                                    <hr>
                                                    <div class="product">
                                                        <div class="product-top">
                                                            <h3 class="title"><strong>Products summary</strong></h3>
                                                        </div>
                                                        <div class="product-item" id="table-data">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped ">
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
                                                        </div>
                                                    </div>
                                                    <div class="separator-solid  mb-3"></div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>

    <script>
        //function that handle create/update of products
        $('#form-create').on('submit', function(event) {

            event.preventDefault();
            var data = new FormData($('#form-create')[0]);

            var id = $('#hidden').val();

            if (id != '') {
                var url = `api/v1/products/${id}`;
            } else {
                var url = 'api/v1/products';
            }

            submitForm(url, data, 'form-create', id);
        });

        //function that load the data
        function loadContent() {
            var url = 'product-data'
            $('#table-data').load(url, function() {});
        }

        //function that update a new record
        $(document).on('click', '.edit-btn', function() {

            var productName = $(this).data('product-name');
            var quantityInStock = $(this).data('quantity-in-stock');
            var pricePerItem = $(this).data('price-per-item');
            var id = $(this).data('id');

            $('#productName').val(productName);
            $('#quantityInStock').val(quantityInStock);
            $('#pricePerItem').val(pricePerItem);
            $('#hidden').val(id);

            $('#form-create').removeClass('create-form');
            $('#form-create').addClass('update-form');

            $('#submit-btn').text('Update product');

        });

        //success message
        function showSuccessMessage(message) {
            var successMessage = $('<div class="alert alert-success">' + message + '</div>');
            successMessage.css({
                'position': 'fixed'
                , 'top': '0'
                , 'left': '50%'
                , 'transform': 'translateX(-50%)'
                , 'width': '50%'
                , 'text-align': 'center'
                , 'z-index': '9999'
            });
            successMessage.appendTo('body');


            setTimeout(function() {
                successMessage.remove();
            }, 4000);
        }

        //error message
        function showErrorMessage(message) {
            var successMessage = $('<div class="alert alert-danger">' + message + '</div>');
            successMessage.css({
                'position': 'fixed'
                , 'top': '0'
                , 'left': '50%'
                , 'transform': 'translateX(-50%)'
                , 'width': '50%'
                , 'text-align': 'center'
                , 'z-index': '9999'
            });
            successMessage.appendTo('body');


            setTimeout(function() {
                successMessage.remove();
            }, 4000);
        }

        function submitForm(url, data, formId, id) {

            $('#submit-btn').prop("disabled", true);
            $.ajax({
                type: 'POST'
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
                , url: url
                , data: data
                , processData: false
                , contentType: false
                , success: function(data) {
                    if (data.status) {
                        $('#submit-btn').prop("disabled", false);
                        loadContent();
                        $('#' + formId)[0].reset();

                        if (id != '') {
                            $('#hidden').val('');
                            $('#submit-btn').text('Save product');
                        }

                        showSuccessMessage(data.message);

                    } else {
                        showSuccessMessage(data.message);
                        $('#submit-btn').prop("disabled", false);

                    }
                }
                , error: function(request, status, error) {

                    var response = JSON.parse(request.responseText);
                    console.log(response.message);

                    showErrorMessage(response.message);

                    $('#submit-btn').prop("disabled", false);
                }
            });
        }

    </script>

</body>
</html>
