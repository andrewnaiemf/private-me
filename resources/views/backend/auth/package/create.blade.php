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
                    إضافة باقة
                    {{--  <small class="text-muted">{{ __('labels.backend.access.users.active') }}</small>  --}}
                </h4>
            </div>
            <!--col-->
        </div>
        <!--row-->

        <div class="row mt-4">
            <div  style="margin: 20px 80px">
                <form action="{{url('admin/auth/package/store')}}" method="post" style="padding:20px;border: 1px solid #eee">
                    @csrf
                    <div class="form-group">
                        <label for="name">اسم الباقة</label>
                        <input class="form-control"  placeholder="name" name="name" type="text" REQUIRED>
                    </div>
                    <div class="form-group">
                        <label for="description">وصف الباقة </label>
                        <textarea class="form-control" placeholder="description"  name="description" REQUIRED></textarea>
                    </div>
{{--                    <div class="form-group">--}}
{{--                        <label for="price">  </label>--}}
{{--                        <input class="form-control" placeholder="1"  name="price" type="number">--}}
{{--                    </div>--}}

{{--                    <div class="form-group">--}}
{{--                        <label for="friends">  </label>--}}
{{--                        <input class="form-control" placeholder=""  name="friends" type="number">--}}
{{--                    </div>--}}

                    <div class="form-group">
                        <label for="storage" style="display: block"> المساحة التخزينية </label>
                        <div style="display: inline-flex;align-items: center;">
                            <input class="form-control" style="width: auto" placeholder="1"  name="storage" type="number"REQUIRED>
                            <span style="margin-right: 10px;">جيجا بايت</span>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="storage" style="display: block"> المساحة التخزينية المجانية </label>
                        <div style="display: inline-flex;align-items: center;">
                            <input class="form-control" style="width: auto" placeholder="1"  name="free_storage" type="number"REQUIRED>
                            <span style="margin-right: 10px;">جيجا بايت</span>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="storage" style="display: block"> سعر الباقة السنوية </label>
                        <div style="display: inline-flex;align-items: center;">
                            <input class="form-control" style="width: auto" placeholder="1"  name="price_year" type="number"REQUIRED>
                            <span style="margin-right: 10px">دينار سعودي </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="storage" style="display: block"> سعر الباقة الشهرية </label>
                        <div style="display: inline-flex;align-items: center;">
                            <input class="form-control" style="width: auto" placeholder="1"  name="price_month" type="number"REQUIRED>
                            <span style="margin-right: 10px;">دينار سعودي </span>
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