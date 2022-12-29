@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
{{--  @include('backend.auth.user.includes.breadcrumb-links')  --}}
@endsection

@section('content')

@if(\Session::has('message'))
    <p class="mt-2 alert {{ Session::get('alert-class', 'alert-info') }} ">{{ Session::get('message') }}</p>
@endif
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    جميع الإعلانات
                    {{--  <small class="text-muted">{{ __('labels.backend.access.users.active') }}</small>  --}}
                </h4>
            </div>
            <!--col-->
        </div>
        <!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive" style="overflow-y:visible;overflow-x:visible;">
                    <table class="table"}}">
                        <thead>
                            <tr>
                                <th>الاعلان باللغة العربية</th>
                                <th>الاعلان باللغة الانجليزية</th>
                                <th>تاريخ الانشاء</th>
                                <th> إجراءات</th>

                            </tr>
                        </thead>
                        <tbody>
                            @isset($advertisements)
                                @foreach ($advertisements as $advertisement)
                                    <tr>
                                        <td><img src="{{asset('storage/Advertising/Files/'.$advertisement->ad_ar) }}" width="100" alt=""></td>
                                        <td><img src="{{asset('storage/Advertising/Files/'.$advertisement->ad_en) }}" width="100" alt=""></td>
                                        <td>{{$advertisement->created_at }}</td>
                                        <td>
                                            <a style="color:red;" href="{{url('admin/auth/advertisement/delete/'.$advertisement->id)}}">
                                                <i class="fas fa-trash"> حذف   </i>
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>

                    </table>
                </div>
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