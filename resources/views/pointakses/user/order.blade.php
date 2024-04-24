@extends('frontend.customer.layouts.menu')
@include('frontend.include.header')
@section('menu')

    <style>
        .wrap-iten-in-cart {
            padding-left: 70px;
            padding-right: 70px;
        }

        @media screen and (max-width: 768px) {
            .wrap-iten-in-cart {
                padding-left: 20px;
                padding-right: 20px;
            }
        }

        .wrap-iten-in-cart .products-cart {
            padding: 0;
            border-top: 1px solid #e6e6e6;
        }

        .wrap-iten-in-cart .products-cart .pr-cart-item {
            list-style: none;
            display: flex;
            /* Mengubah tata letak menjadi flexbox */
            justify-content: space-between;
            /* Menyusun elemen ke tepi kanan dan kiri */
            align-items: center;
            /* Memusatkan vertikal */
            padding: 20px 0px;
            width: 100%;
        }

        .wrap-iten-in-cart .products-cart .pr-cart-item:not(:first-child) {
            border-top: 1px solid #e6e6e6;
        }

        .wrap-iten-in-cart .products-cart .delete,
        .wrap-iten-in-cart .products-cart .quantity,
        .wrap-iten-in-cart .products-cart .price-field,
        .wrap-iten-in-cart .products-cart .product-name,
        .wrap-iten-in-cart .products-cart .product-image {
            display: table-cell;
            vertical-align: middle;
        }

        .wrap-iten-in-cart .products-cart .product-image {
            flex: 0 0 auto;
            /* Tetapkan lebar tetap untuk gambar produk */
            width: 100px;
            margin-right: 20px;
            /* Menambahkan ruang di antara gambar dan nama produk */
        }

        @media screen and (-ms-high-contrast: active),
        (-ms-high-contrast: none) {
            .wrap-iten-in-cart .products-cart .product-image img {
                width: 100%;
            }
        }

        .wrap-iten-in-cart .products-cart .quantity {
            width: 157px;
        }

        .wrap-iten-in-cart .products-cart .price-field {
            width: 182px;
            text-align: center;
        }

        .wrap-iten-in-cart .products-cart .delete {
            width: 39px;
            text-align: right;
        }

        .wrap-iten-in-cart .products-cart .product-name {
            padding-left: 20px;
        }

        .wrap-iten-in-cart .products-cart .product-name a {
            font-size: 14px;
            line-height: 20px;
            font-weight: 600;
            color: #333333;
            text-align: left;
        }

        .wrap-iten-in-cart .products-cart .price-field p {
            font-size: 22px;
            line-height: 18px;
            color: #222222;
            font-weight: 600;
        }

        .wrap-iten-in-cart .products-cart .quantity .quantity-input {
            display: inline-block;
            border: 1px solid #e6e6e6;
            width: 100%;
            max-width: 157px;
        }

        .wrap-iten-in-cart .products-cart .quantity .quantity-input input[type=number],
        .wrap-iten-in-cart .products-cart .quantity .quantity-input input[type=text] {
            max-width: 71px;
            float: right;
            border: none;
            outline: none;
            height: 37px;
            font-size: 16px;
            line-height: 20px;
            color: #222222;
            text-align: right;
            padding-right: 15px;
            padding-left: 10px;
        }

        .wrap-iten-in-cart .products-cart .quantity .quantity-input .btn {
            display: inline-block;
            float: right;
            width: 28px;
            height: 28px;
            background-color: #dddddd;
            border: none;
            padding: 0;
            line-height: 20px;
            margin: 4.5px 0 0 10px;
            border-radius: 50%;
            position: relative;
        }

        .wrap-iten-in-cart .products-cart .quantity .quantity-input .btn::after,
        .wrap-iten-in-cart .products-cart .quantity .quantity-input .btn::before {
            position: absolute;
            top: 50%;
            left: 50%;
            /*transform: translate( -50% , -50% );*/
            /*-webkit-transform: translate( -50% , -50% );*/
            /*-ms-transform: translate( -50% , -50% );*/
        }

        .wrap-iten-in-cart .products-cart .quantity .quantity-input .btn:hover::before,
        .wrap-iten-in-cart .products-cart .quantity .quantity-input .btn:hover::after {
            background-color: #ffffff !important;
        }

        .wrap-iten-in-cart .products-cart .quantity .quantity-input .btn::before {
            content: "";
            width: 10px;
            height: 2px;
            margin-left: -5px;
            margin-top: -1px;
            background-color: #666666;
            display: inline-block;
        }

        .wrap-iten-in-cart .products-cart .quantity .quantity-input .btn.btn-increase {
            background-color: #999999;
        }

        .wrap-iten-in-cart .products-cart .quantity .quantity-input .btn.btn-increase::after {
            content: "";
            width: 2px;
            height: 10px;
            margin-left: -1px;
            margin-top: -5px;
            background-color: #666666;
            display: block;
            /*    transform: translate(-6px, 4px);
                                                                    -webkit-transform: translate(-6px, 4px);
                                                                    -ms-transform: translate(-6px, 4px);*/

        }

        .wrap-iten-in-cart .products-cart .delete a:focus,
        .wrap-iten-in-cart .products-cart .delete a.btn {
            padding: 0;
            margin: 0;
            outline: none;
            box-shadow: none;
        }

        .wrap-iten-in-cart .products-cart .delete a.btn span {
            display: none;
        }

        .wrap-iten-in-cart .products-cart .delete a.btn i {
            font-size: 20px;
            line-height: 24px;
            color: #888888;
            outline: none;
        }

        .wrap-iten-in-cart .products-cart .delete a.btn:hover i {
            color: #ff2832;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Menambahkan efek bayangan */
        }


        .product-image img {
            max-width: 100px;
            height: auto;
            margin-right: 20px;
        }

        .product-details {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-name {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .vendor {
            margin: 20;
            font-size: 16px;
        }

        .box {
            background-color: #fdfdfd;
            width: 600px;
            border: 1px solid #e6e6e6;
            padding: 40px 40px 21px 40px;
            position: relative;
            /* Mengatur posisi relatif */
            margin: 0 auto;
            /* Menyamakan margin kiri dan kanan (margin otomatis) */
        }

        .detail-order {
            position: absolute;
            top: 10;
            left: 10;
            /* Mengatur posisi ke kiri */
        }

        .detail-order p {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: black;
            /* Warna teks hitam */
        }

        .total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 22px;
            font-weight: 600;
        }

        .total p:first-child {
            margin-right: 10px;
        }

        .checkout-btn {
            display: flex;
            justify-content: space-between;
            margin-top: 0px;
        }

        .continue-btn {
            flex: 2;
            /* Mengatur agar ukuran tombol menjadi sama */
            background-color: #1c33b8;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
            /* Tambahkan margin kanan */
        }

        .checkout-btn button {
            flex: 2;
            /* Mengatur agar ukuran tombol menjadi sama */
            background-color: #45a049;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .continue-btn:hover,
        .checkout-btn button:hover {
            background-color: #000;
        }

        /* Menambahkan aturan media query untuk layar dengan lebar maksimum 768px */
        @media screen and (max-width: 768px) {

            /* Menyesuaikan ukuran font pada tulisan nama produk */
            .wrap-iten-in-cart .products-cart .product-name a {
                font-size: 14px;
                /* Mengubah ukuran font menjadi 14px */
                line-height: 18px;
                /* Menyesuaikan jarak antara baris menjadi 18px */
            }

            /* Menyesuaikan ukuran font pada tulisan harga produk */
            .wrap-iten-in-cart .products-cart .price-field p {
                font-size: 14px;
                /* Mengubah ukuran font menjadi 12px */
                line-height: 14px;
                /* Menyesuaikan jarak antara baris menjadi 14px */
            }


            /* Mengubah elemen <h2> menjadi <p> pada bagian produk-details */
            .wrap-iten-in-cart .products-cart .product-details h2 {
                display: inline;
                /* Atur elemen <h2> menjadi inline */
            }

            .wrap-iten-in-cart .products-cart .product-details p {
                display: block;
                /* Atur elemen <p> menjadi block */
                font-size: 16px;
                /* Atur ukuran font menjadi 16px */
                line-height: 20px;
                /* Atur jarak antar baris menjadi 20px */
                font-weight: bold;
                /* Atur tebal huruf menjadi tebal */
            }
    </style>

    <!--Page header & Title-->
    <section id="page_header">
        <div class="page_title">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title">Shopping Cart</h2>
                        <p>UINSA FOOD</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (session('order_' . auth()->id()) && count(session('order_' . auth()->id())) > 0)
        <div class="wrap-iten-in-cart" id="cart">
            <ul class="products-cart">
                @php
                    $total = 0;
                @endphp
                @foreach (session('order_' . auth()->id()) as $id => $order_detail)
                    <li class="pr-cart-item" rowId="{{ $id }}">
                        <div class="product-image">
                            <img src="{{ url('storage/menu_images/' . basename($order_detail['menu_pic'])) }}"
                                alt="Product Image">
                        </div>
                        <div class="product-details">
                            <h2 class="product-name">{{ $order_detail['menu_name'] }}</h2>
                            <p class="vendor">{{ $order_detail['seller'] }}</p>
                        </div>
                        <div class="price-field product-price">
                            <p class="price">Rp. {{ number_format($order_detail['menu_price'], 0, ',', '.') }}</p>
                        </div>
                        <div class="quantity">
                            <div class="quantity-input">
                                <input type="number" name="product-quantity" value="{{ $order_detail['quantity'] }}"
                                    data-max="120" pattern="[0-9]*" class="edit-cart-info">
                                <a class="btn btn-increase" href="#"></a>
                                <a class="btn btn-reduce" href="#"></a>
                            </div>
                        </div>
                        <div class="price-field sub-total">
                            <p class="price">Rp. {{ number_format($order_detail['subtotal'], 0, ',', '.') }}</p>
                        </div>
                        <div class="delete">
                            <a href="#" class="btn btn-delete delete-product" title="">
                                <span>Delete from your cart</span>
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                            </a>
                        </div>
                    </li>
                    @php
                        $total += $order_detail['subtotal'];
                    @endphp
                @endforeach
            </ul>
        </div>
        <br>
        <div class="box">
            <div class="detail-order">
                <p>Detail Order</p>
            </div>
            <br>
            <div class="total">
                <h3>Total: </h3>
                <h3><strong> Rp. {{ number_format($total, 0, ',', '.') }}</strong></h3>
            </div>
            <br>
            <div class="checkout-btn">
                <button class="checkout-btn" onclick="window.location.href='{{ url('/checkout') }}'">Checkout</button>
            </div>
        </div>
        <br>
        <br>
    @else
        <br>
        <div class="text-center">
            <h3><em>Belum ada menu yang ditambahkan.</em></h3>
        </div>
        <br>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Function to increase quantity
            $(document).on('click', '.btn-increase', function(e) {
                e.preventDefault();
                var input = $(this).siblings('input[type="number"]');
                var currentValue = parseInt(input.val());
                input.val(currentValue + 1);
                updateCart(input); // Panggil fungsi untuk mengirim permintaan ke server
            });

            // Function to decrease quantity
            $(document).on('click', '.btn-reduce', function(e) {
                e.preventDefault();
                var input = $(this).siblings('input[type="number"]');
                var currentValue = parseInt(input.val());
                if (currentValue > 1) {
                    input.val(currentValue - 1);
                    updateCart(input); // Panggil fungsi untuk mengirim permintaan ke server
                }
            });

            // Function to update cart via AJAX
            function updateCart(input) {
                var listItem = input.closest('.pr-cart-item');
                var productId = listItem.attr('rowId');
                var quantity = input.val();

                $.ajax({
                    url: '{{ route('update.sopping.order') }}',
                    method: "PATCH",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: productId,
                        quantity: quantity,
                    },
                    success: function(response) {
                        // Reload the page after successful update
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert("Failed to update cart. Please try again later.");
                    }
                });
            }

            // Function to handle product deletion
            $(".delete-product").click(function(e) {
                e.preventDefault();

                var ele = $(this);
                var rowId = ele.closest("li").attr("rowId");

                if (confirm("Do you really want to delete?")) {
                    $.ajax({
                        url: '{{ route('delete.cart.menu') }}',
                        method: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: rowId
                        },
                        success: function(response) {
                            location.reload(); // Reload the page after successful deletion
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            alert("Failed to delete item from cart. Please try again later.");
                        }
                    });
                }
            });

            // Function to handle checkout button
            $(".checkout-btn").click(function(e) {
                e.preventDefault();
                var total = {{ $total ?? 0 }};
                if (total > 0) {
                    // Redirect to checkout page if there are items in the cart
                    window.location.href = '{{ url('/checkout') }}';
                } else {
                    // Show alert if there are no items in the cart
                    alert("Your cart is empty. Please add items before checkout.");
                }
            });
        });
    </script>

@endsection
