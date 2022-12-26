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

                            $monthly[$package->name] = [];
                            $annual[$package->name ]= [];
                            $users = \App\Models\Auth\User::where('plan_id', $package->id)->get();

                            foreach ($users as $user){
                                  $user_package = \App\Models\Auth\Package::where('user_id', $user->id)->first();
                                  if (isset($user_package)){
                                        if($user_package->price == $package ->price_month){
                                            array_push($monthly[$package->name] , $user_package );
                                        }else{
                                            array_push($annual[$package->name] , $user_package );
                                        }
                                  }
                            }

                        @endphp
                        <div class="col-xl-3 col-sm-6 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="dash-widget-header">
                                            <span class="dash-widget-icon text-primary border-primary">
                                                <i class="fe fe-users"></i>
                                            </span>
                                            <div class="dash-count">
                                                <h3 class="text-center">{{$package->name}}</h3>
                                            </div>
                                        </div>
                                        <div class="dash-widget-info">
                                            <div class="row justify-content-between">
                                               <a href="{{ url('admin/dashboard/package/'.$package->id.'/m')}}">
                                                    <div class="col">
                                                        <h3>شهريا</h3>
                                                        <h6 class="text-muted">{{ count($monthly[$package->name])}} @lang('strings.backend.dashboard.users')</h6>
                                                        <div class="progress progress-sm">
                                                            <div class="progress-bar bg-primary" style="width: {{ count($monthly[$package->name])}}%"></div>
                                                        </div>
                                                    </div>
                                               </a>
                                                <a href="{{ url('admin/dashboard/package/'.$package->id.'/y') }}">
                                                    <div class="col">
                                                        <h3>سنويا</h3>
                                                        <h6 class="text-muted">{{ count($annual[$package->name])}} @lang('strings.backend.dashboard.users')</h6>
                                                        <div class="progress progress-sm">
                                                            <div class="progress-bar bg-primary" style="width: {{count($annual[$package->name])}}%"></div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        @endforeach
                    </div>
                    @endisset


                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
