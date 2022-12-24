@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
                </div><!--card-header-->
                <div class="card-body">
                    {{--  {!! __('strings.backend.welcome') !!}  --}}

                
                    @isset($packages)
                    <div class="row">
                        @foreach ($packages as $package)
                        @php
                            $users = \App\Models\Auth\User::where('plan_id', $package->id)->get();
                        @endphp
                        <div class="col-xl-3 col-sm-6 col-12">
                            <a href="{{ url('admin/dashboard/package/'.$package->id) }}">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="dash-widget-header">
                                            <span class="dash-widget-icon text-primary border-primary">
                                                <i class="fe fe-users"></i>
                                            </span>
                                            <div class="dash-count">
                                                <h3>{{$package->name}}</h3>
                                            </div>
                                        </div>
                                        <div class="dash-widget-info">
                                            <h6 class="text-muted">{{$users->count()}} @lang('strings.backend.dashboard.users')</h6>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-primary" style="width: {{$users->count()}}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endisset
                    

                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
