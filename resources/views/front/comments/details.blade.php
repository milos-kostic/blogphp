@extends('front._layout.layout')

@section('seo_title', __('Comments Details'))

@section('content')


<!-- Breadcumb Area -->
<div class="breadcumb_area">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <h5>Order details</h5>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Order Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Breadcumb Area -->

<!-- Checkout Area -->
<div class="checkout_area mt-50">
    <div class="container">
        <div class="row order_complated_area">
            <div class="col-lg-6">
                <h1>Order #1234567</h1>
                <small class="text-muted">
                    Last change: 
                    3 minutes ago
                </small>
            </div>
            <div class="col-lg-6 text-right">
                <span class="btn border border-secondary">
                    <span class="badge badge-secondary">&nbsp;</span>
                    In Progress
                </span>
              
            </div>
        </div>
    </div>
</div>

<div class="checkout_area mt-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h4>
                    Order for:
                    <u>Aleksandar Dimic</u>
                </h4>
                <p><strong>aleksandar.dimic@cubes.rs</strong></p>
                <p><strong>+381643334445</strong></p>
            </div>
            <div class="col-lg-4 text-right">
                <h4 class="text-left">
                    Total: 
                    <span class="float-right">$781.43</span>
                </h4>
               
                <label class="text-primary">
                    <i class="icofont-bank-transfer-alt align-middle" style="font-size: 6rem"></i> 
                    <span class="align-middle">Direct bank transfer</span>
                </label>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Bank account</td>
                            <td><strong>123-342455465-32</strong></td>
                        </tr>
                        <tr>
                            <td>Reference Number</td>
                            <td><strong>1234567</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-6">
                <h6>Blling Address</h3>
                    <span>Bulevar Mihajla Pupina</span>
                    <span>120</span>,
                    <span>11000</span>
                    <span>Beograd</span>,
                    <span>Srbija</span>
            </div>
            <div class="col-lg-6">
                <h6>Shipping Address</h3>
                    <span>Bulevar Mihajla Pupina</span>
                    <span>120</span>,
                    <span>11000</span>
                    <span>Beograd</span>,
                    <span>Srbija</span>
            </div>
        </div>
    </div>
</div>
<!-- Checkout Area -->

<!-- Cart Area -->
<div class="cart_area mt-50 mb-50 clearfix">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12">
                <div class="cart-table">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Image</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img src="/themes/front/img/product-img/onsale-1.png" alt="Product">
                                    </td>
                                    <td>
                                        <a href="#">Bluetooth Speaker</a>
                                    </td>
                                    <td>$9</td>
                                    <td>
                                        <div class="quantity">
                                            1
                                        </div>
                                    </td>
                                    <td>$9</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="/themes/front/img/product-img/onsale-2.png" alt="Product">
                                    </td>
                                    <td>
                                        <a href="#">Roof Lamp</a>
                                    </td>
                                    <td>$11</td>
                                    <td>
                                        <div class="quantity">
                                            1
                                        </div>
                                    </td>
                                    <td>$11</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="/themes/front/img/product-img/onsale-6.png" alt="Product">
                                    </td>
                                    <td>
                                        <a href="#">Cotton T-shirt</a>
                                    </td>
                                    <td>$6</td>
                                    <td>
                                        <div class="quantity">
                                            1
                                        </div>
                                    </td>
                                    <td>$6</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="/themes/front/img/product-img/onsale-4.png" alt="Product">
                                    </td>
                                    <td>
                                        <a href="#">Water Bottle</a>
                                    </td>
                                    <td>$17</td>
                                    <td>
                                        <div class="quantity">
                                            1
                                        </div>
                                    </td>
                                    <td>$17</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="/themes/front/img/product-img/onsale-5.png" alt="Product">
                                    </td>
                                    <td>
                                        <a href="#">Alka Sliper</a>
                                    </td>
                                    <td>$13</td>
                                    <td>
                                        <div class="quantity">
                                            1
                                        </div>
                                    </td>
                                    <td>$13</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">

            </div>

            <div class="col-12 col-lg-5">
                <div class="cart-total-area">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Total</td>
                                    <td>$71.60</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
