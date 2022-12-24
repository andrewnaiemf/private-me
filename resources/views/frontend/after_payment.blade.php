@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . 'Payment Status')

@section('content')

<!-- ##### Welcome Area Start ##### -->
<div class="breadcumb-area clearfix auto-init">
    <!-- breadcumb content -->
    <div class="breadcumb-content">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="breadcumb--con text-center">
                        <h2 class="w-text title fadeInUp" data-wow-delay="0.2s">حالة الدفع</h2>
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
                <?php $result = json_decode($responseData); ?>
                <div class="h1">{{$result->result->description}}</div>
            </div>
            <br />
            <!-- <a href="{{route('frontend.index')}}" class="btn btn-success btn-lg">Reurn To Home</a> -->
            <br />
        </div>
    </div>
</section>

@endsection