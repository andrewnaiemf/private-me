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
                    {{ __('menus.backend.access.packages.all') }}
                    {{--  <small class="text-muted">{{ __('labels.backend.access.users.active') }}</small>  --}}
                </h4>
            </div>
            <!--col-->
        </div>
        <!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive" style="overflow-y:visible;overflow-x:visible;">
                    <table class="table" id="users-table" data-ajax_url="{{ route("admin.auth.user.get") }}">
                        <thead>
                            <tr>
                                <th>@lang('labels.backend.access.packages.table.name')</th>
                                {{--  <th>@lang('labels.backend.access.users.table.last_name')</th>  --}}
                                <th>@lang('labels.backend.access.packages.table.price-year')</th>
                                <th>@lang('labels.backend.access.packages.table.price-month')</th>
                                <th>@lang('labels.backend.access.packages.table.storage')</th>
                                <th>@lang('labels.backend.access.packages.table.free-storage')</th>
{{--                                <th>@lang('labels.backend.access.packages.table.chat')</th>--}}
                                {{--  <th>@lang('labels.backend.access.users.table.confirmed')</th>  --}}
                                {{--  <th>@lang('labels.backend.access.users.table.roles')</th>  --}}
                                <th>@lang('labels.backend.access.packages.table.created')</th>
                                {{--  <th>@lang('labels.backend.access.packages.table.subscribe')</th>  --}}
                                {{--  <th>@lang('labels.backend.access.users.table.last_updated')</th>  --}}
                                {{--  <th>@lang('labels.general.actions')</th>  --}}
                            </tr>
                        </thead>
                        <tbody>
                            @isset($packages)
                                @foreach ($packages as $package)
                                    <tr>
                                        <td>{{$package->name }}</td>
                                        <td>{{$package->price_year }}</td>
                                        <td>{{$package->price_month }}</td>
                                        <td>{{$package->storage }}</td>
                                        <td>{{$package->free_storage }}</td>
{{--                                        <td>{{$package->chat }}</td>--}}
                                        <td>{{$package->created_at }}</td>
                                       
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