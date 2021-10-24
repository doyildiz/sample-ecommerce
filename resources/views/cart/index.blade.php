@extends('layouts.app')

@section('content')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container padding-bottom-3x mb-1">

        <!-- Shopping Cart-->
        <div class="table-responsive shopping-cart">
            <table class="table">
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Subtotal</th>
                    <th class="text-center"><a class="btn btn-sm btn-outline-danger" id="clearBtn" href="#">Clear
                            Cart</a></th>
                </tr>
                </thead>
                <tbody>
                @if($cart)
                    @if(!empty($cart->details))
                        @foreach($cart->details as $detail)
                            <tr>
                                <td>
                                    <div class="product-item">
                                        <a class="product-thumb" href="#"><img
                                                src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg"
                                                alt="Product"></a>
                                        <div class="product-info">
                                            <h4 class="product-title"><a
                                                    href="{{url('product/'.$detail->product->id)}}">
                                                    {{$detail->product->name}}</a></h4>
                                            <span><em>{{ucfirst($detail->option->name)}}:</em>
                                            {{$detail->option->value}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center text-lg text-medium">
                                    <div class="count-input">
                                        {{$detail->quantity}}
                                    </div>
                                </td>
                                <td class="text-center text-lg text-medium">
                                    @guest
                                        <a href="{{route('login')}}">Log in to view your pricing</a>
                                    @else
                                        ${{number_format($detail->product->price,2)}}
                                    @endif
                                </td>
                                <td class="text-center"></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" style="text-align: center;">
                                Your cart is empty
                            </td>
                        </tr>
                        @endif
                @endif

                </tbody>
            </table>
        </div>
        <div class="shopping-cart-footer">
            <div class="column text-lg">Subtotal: <span class="text-medium">
                    @guest
                        <a href="{{route('login')}}">Log in to view your pricing</a>
                    @else
                        ${{number_format($cart->total_price,2)}}
                    @endif
                </span></div>
        </div>
        <div class="shopping-cart-footer">
            <div class="column"><a class="btn btn-outline-secondary" href="{{url('/')}}"><i class="icon-arrow-left"></i>&nbsp;Back
                    to Shopping</a></div>
            <div class="column"><a class="btn btn-success" href="#">Checkout</a></div>
        </div>
    </div>

@endsection
