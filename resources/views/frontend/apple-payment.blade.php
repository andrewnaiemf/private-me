@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . 'Payment')

@section('content')
<?php $c = json_decode($response);
if (!isset($c->id))
    $c->id = 6;
?>
<!-- ##### Welcome Area Start ##### -->
<div class="breadcumb-area clearfix auto-init">
    <!-- breadcumb content -->
    <div class="breadcumb-content">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="breadcumb--con text-center">
                        <h2 class="w-text title fadeInUp" data-wow-delay="0.2s">بيانات الدفع</h2>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ##### Welcome Area End ##### -->

<!-- ##### Blog Area Start ##### -->
<section class="blog-area section-padding-100-0">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Single Blog Post -->
            <div class="col-12 text-center">
                <div class="h1">Total price: {{$price}} SAR</div>
            </div>
            <form action="{{route('frontend.payment.apple.status')}}" class="paymentWidgets" data-brands="APPLEPAY"></form>

        </div>
    </div>
</section>
<!-- ##### Blog Area End ##### -->

<script>
    var wpwlOptions = {
        applePay: {
            displayName: "MyStore",
            total: {
                label: "COMPANY, INC."
            }
        }
    }
</script>
<script src="https://eu-prod.oppwa.com/v1/paymentWidgets.js?checkoutId={{$c->id}}"></script> 

@endsection