@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
{{--  @include('backend.auth.user.includes.breadcrumb-links')  --}}
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    إضافة إعلان
                    {{--  <small class="text-muted">{{ __('labels.backend.access.users.active') }}</small>  --}}
                </h4>
            </div>
            <!--col-->
        </div>
        <!--row-->

        <div class="row mt-4">
            <div  style="margin: 20px 80px">
                <form action="{{url('admin/auth/advertisement/store')}}" method="post" style="padding:20px;border: 1px solid #eee" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="storage" style="display: block">  الإعلان باللغة العربية </label>
                        <div style="display: inline-flex;align-items: center;">
                            <input style="width: auto" placeholder="1"  name="ad_ar" type="file"  required>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="storage" style="display: block"> الإعلان باللغة الانجليزية </label>
                        <div style="display: inline-flex;align-items: center;">
                            <input  style="width: auto" placeholder="1"  name="ad_en" type="file" required>
                        </div>

                    </div>

                    <input type="submit" class="btn btn-primary" value="Save">
                </form>
            </div>
            <!--col-->
        </div>
        <!--row-->


    </div>
    <!--card-body-->
</div>
<!--card-->
@endsection

@section('pagescript')
<script>
    FTX.Utils.documentReady(function() {
        FTX.Users.list.init('active');
    });
</script>
@endsection