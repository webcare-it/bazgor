@extends('frontend.v-2.master')

@section('title')
    Cart products
@endsection

@section('content-v2')
    {{-- <div id="app">
        @if(isset($auth_user))
            <cart-products :auth_user="{{ $auth_user }}"></cart-products>
        @else
            <cart-products></cart-products>
        @endif
    </div> --}}
<section class="cart-products-section">
    <div class="container">
        <a href="{{url('/')}}" class="continue-shopping-btn">
            <i class="fas fa-long-arrow-alt-left"></i>
            Continue Shopping
        </a>
        <div class="cart-products-wrapper">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>image</th>
                        <th>Product Name</th>
                        <th>price</th>
                        <th>quantity</th>
                        <th>remove</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carts as $cart)
                    <tr>
                        <td class="cart-product-image-outer">
                            <img src="{{ asset('product/images/'.$cart->product->image) }}" height="70" width="120">
                        </td>
                        <td class="cart-product-name-outer">
                            {{$cart->product->name}}
                        </td>
                        <td class="cart-product-price-outer">
                            ৳ {{$cart->product->discount_price ?? $cart->product->regular_price}}
                        </td>
                        <td class="qty-increment-decrement-outer">
                            <button title="Increment" class="increment-btn" data-id="{{ $cart->id }}">
                                <i class="fas fa-plus"></i>
                            </button>
                            <input type="number" name="qty" class="cart-qty" data-id="{{ $cart->id }}" readonly value="{{ $cart->qty }}" min="1" />
                            <button title="Decrement" class="decrement-btn" data-id="{{ $cart->id }}">
                                <i class="fas fa-minus"></i>
                            </button>
                        </td>
                        <td>
                            <a href="{{url('product/delete/form/cart/'.$cart->id)}}" class="remove-product">Remove</a>
                        </td>
                        <td class="cart-product-total-outer" id="cart-total-{{ $cart->id }}">
                            ৳ {{ $cart->price }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <a href="{{ url('/checkout') }}" class="process-checkout-btn">
                Proceed To CheckOut
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</section>
<input type="hidden" name="cartTotal" id="cartTotal" value="{{$cartTotal}}">
@endsection

@push('script')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $('.increment-btn').on('click', function () {
                const id = $(this).data('id');
                updateCartQuantity(id, 'increment');
            });

            $('.decrement-btn').on('click', function () {
                const id = $(this).data('id');
                updateCartQuantity(id, 'decrement');
            });

            function updateCartQuantity(id, type) {
                const url = '{{ route("cart.update", ":id") }}'.replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        type: type
                    },
                    success: function (res) {
                        $('#cart-total-' + id).html('৳ ' + res.updatedPrice);
                        $('input.cart-qty[data-id="' + id + '"]').val(res.updatedQty);
                    }
                });
            }
        });
    </script>

    {{-- Data Layer... --}}
<script type = "text/javascript">
    window.addEventListener('load', function() {
        var cartTotal = document.getElementById('cartTotal').value;
        dataLayer.push({ ecommerce: null });
        dataLayer.push({
            event    : "view_cart",
            ecommerce: {
                currency : "BDT",
                value    : cartTotal,
                items: [@foreach ($auth_user as $cart){
                    item_name     : "{{$cart->product->name}}",
                    item_id       : "{{$cart->product->id}}",
                    price         : "{{$cart->product->regular_price}}",
                    item_brand    : "Unknown",
                    item_category : "Unknown",
                    item_variant  : "",
                    item_list_name: "",
                    item_list_id  : "",
                    index         : 0,
                    quantity      : "{{$cart->qty}}"
                },@endforeach]
            }
        });
    });
    </script>
@endpush
