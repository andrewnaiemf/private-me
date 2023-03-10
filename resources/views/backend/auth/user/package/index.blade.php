@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
@include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card mt-4">
    <div class="card-body">
        <div class="row ">
            <div class="col-sm-5">
                <h4 class="card-title mb-3">
                    {{--  {{ __('labels.backend.access.users.allUsers') }}   --}}
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
                                <th>@lang('labels.backend.access.users.table.id')</th>
                                <th>@lang('labels.backend.access.users.table.name')</th>
                                {{--  <th>@lang('labels.backend.access.users.table.last_name')</th>  --}}
                                <th>@lang('labels.backend.access.users.table.email')</th>
                                {{--  <th>@lang('labels.backend.access.users.table.confirmed')</th>  --}}
                                {{--  <th>@lang('labels.backend.access.users.table.roles')</th>  --}}
                                <th>@lang('labels.backend.access.users.table.created')</th>
                                <th>@lang('labels.backend.access.users.table.subscribe')</th>
                                {{--  <th>@lang('labels.backend.access.users.table.last_updated')</th>  --}}
                                {{--  <th>@lang('labels.general.actions')</th>  --}}
                            </tr>
                        </thead>
                        <tbody>
                            @isset($users)
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user->id + 100000}}</td>
                                        <td>{{$user->first_name . ' '.$user->last_name}}</td>
                                        <td>{{$user->email}}</td>
                                        {{--  <td>{{$user->confirmed == 1 ? 'yes':'no'}}</td>  --}}
                                        {{--  <td></td>  --}}
                                        <td>{{$user->created_at}}</td>
                                        {{--  <td></td>  --}}
                                        <td><i  class="  fas fa-solid fa-check"></i></td>
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
        <div class="row justify-content-center">

            {!! $users->render() !!}

        </div>

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