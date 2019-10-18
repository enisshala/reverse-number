@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.access.users.cancel') }}
                    </h4>
                </div><!--col-->

                <div class="col-sm-7">
                    {{--                    @include('backend.auth.user.includes.header-buttons')--}}
                </div><!--col-->
            </div><!--row-->

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>@lang('labels.backend.access.users.table.last_name')</th>
                                <th>@lang('labels.backend.access.users.table.first_name')</th>
                                <th>@lang('labels.backend.access.users.table.email')</th>
                                <th>@lang('labels.backend.access.users.table.created_date')</th>
                                <th>@lang('labels.backend.access.users.table.confirmed')</th>
                                <th>@lang('labels.backend.access.users.table.created_at')</th>
                                <th>@lang('labels.general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cancel_requests as $cancel_request)
                                <tr>
                                    {{--                                    {{dd($cancel_request->user->last_name)}}--}}
                                    <td>{{ $cancel_request->user->last_name }}</td>
                                    <td>{{ $cancel_request->user->first_name }}</td>
                                    <td>{{ $cancel_request->user->email }}</td>
                                    <td>{{ \Carbon\Carbon::parse($cancel_request->user->subscription->created_at)->diffForHumans() }}</td>
                                    <td>@if ($cancel_request->approved === 1) <span
                                            class="badge badge-success">Approved</span>
                                        @else <span
                                                class="badge badge-info">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($cancel_request->created_at)->diffForHumans() }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="User Actions">
                                            <a href="javascript:void(0)" data-request-id="{{ $cancel_request->id }}"
                                               id="approve-request" data-toggle="tooltip" data-placement="top"
                                               title="" class="btn btn-info" data-original-title="Approve"><i
                                                    class="fas fa-check"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->
            <div class="row">
                <div class="col-7">
                    <div class="float-left">
                        {!! $cancel_requests->total() !!} {{ trans_choice('labels.backend.access.users.table.req_total', $cancel_requests->total()) }}
                    </div>
                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">
                        {!! $cancel_requests->render() !!}
                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
@endsection
