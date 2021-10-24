@extends('layouts.app')

@section('content')

    <div class="container mt-5 mb-5">
        <div class="card">
            @if($product)
                <form id="detailForm" action="{{route('add')}}" method="POST">

                    <input type="hidden" name="product[product_id]" value="{{$product->id}}">
                    <input type="hidden" name="product[unit_price]" value="{{$product->price}}">
                    <input type="hidden" name="cart[customer_id]"
                           @guest value="0" @else
                           value="{{\Illuminate\Support\Facades\Auth::id()}}" @endif>
                    @csrf
                    <div class="row g-0">
                        <div class="col-md-6 border-end">
                            <div class="d-flex flex-column justify-content-center">
                                <div class="main_image"><img src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg"
                                                             id="main_product_image"
                                                             style="width: -webkit-fill-available;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 right-side">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3>{{$product->name}}</h3> <span class="heart"><i class='bx bx-heart'></i></span>
                                </div>
                                <div class="mt-2 pr-3 content">
                                    <p></p>
                                </div>

                                @guest
                                    <a href="{{route('login')}}">Log in to view your pricing</a>
                                @else
                                    <h3>${{number_format($product->price,2)}}</h3>
                                @endif
                                <br/>
                                <div class="ratings d-flex flex-row align-items-center">
                                    <h5>Current Inventory: {{$product->stock}}</h5>
                                </div>
                                @if(!empty($product->option_names))
                                    @foreach($product->option_names as $option_name)
                                        <div class="mt-5"><span class="fw-bold">{{ucfirst($option_name->name)}}</span>
                                            <div class="colors">
                                                <select name="product[option_id]">
                                                    @foreach($product->options as $option)
                                                        @if($option->name == $option_name->name)
                                                            <option value="{{$option->id}}">{{$option->value}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-sm-6" style="margin-top: 5%">
                                                <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <button type="button" class="btn btn-outline-secondary btn-number"
                                                            disabled="disabled"
                                                            data-type="minus" data-field="product[quantity]">
                                                        <span class="fa fa-minus"></span>
                                                    </button>
                                                </span>
                                                    <input type="text" name="product[quantity]"
                                                           class="form-control input-number"
                                                           value="1" min="1" max="5">
                                                    <span class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary btn-number"
                                                        data-type="plus"
                                                        data-field="product[quantity]">
                                                    <span class="fa fa-plus"></span>
                                                </button>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="buttons d-flex flex-row mt-5 gap-3">
                                            <button type="button" id="addToCartBtn" class="btn btn-dark">Add to Basket
                                            </button>
                                        </div>
                            </div>
                        </div>
                    </div>
                </form>

            @endif
        </div>
    </div>

@endsection
