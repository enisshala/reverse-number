@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.dashboard') )

@section('content')
    <div class="row mb-4">
        <div class="col">
            @if (!isset($logged_in_user->subscription))
                <div class="card">
                    <div class="card-header">
                        <strong>
                            <i class="fas fa-tachometer-alt"></i> @lang('navs.frontend.subscription')
                        </strong>
                    </div><!--card-header-->

                    <div class="card-body subscription-body">
                        <p class="card-text"><b>You have no active subscription</b></p>
                        <p class="card-text">Trial Period: <span>1$ / 3 Days</span></p>
                        <p class="card-text" style="font-size: 14px;">Regular Price: <span>$19.22 / Month</span></p>
                        <a href="javascript:void(0)"
                           data-user-id="{{ $logged_in_user->id }}"
                           data-plan-id="{{config('paypal.plan_id')}}"
                           class="btn btn-info btn-md mb-1 subscribe-now"><i class="fab fa-paypal"></i> Subscribe</a>
                    </div>
                </div>
                <br>
            @endif
            <div class="card">
                <div class="card-header">
                    <strong>
                        <i class="fas fa-tachometer-alt"></i> @lang('navs.frontend.dashboard')
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    <div class="row">
                        <div class="col col-sm-4 order-1 mb-4">
                            <div class="card mb-4 bg-light">
                                <img class="card-img-top" src="{{ $logged_in_user->picture }}" alt="Profile Picture">

                                <div class="card-body">
                                    <h4 class="card-title">
                                        {{ $logged_in_user->name }}<br/>
                                    </h4>

                                    <p class="card-text">
                                        <small>
                                            <i class="fas fa-envelope"></i> {{ $logged_in_user->email }}<br/>
                                            <i class="fas fa-calendar-check"></i> @lang('strings.frontend.general.joined') {{ timezone()->convertToLocal($logged_in_user->created_at, 'F jS, Y') }}
                                        </small>
                                    </p>

                                    <p class="card-text">

                                        <a href="{{ route('frontend.user.account')}}" class="btn btn-info btn-sm mb-1">
                                            <i class="fas fa-user-circle"></i> @lang('navs.frontend.user.account')
                                        </a>

                                        @can('view backend')
                                            &nbsp;<a href="{{ route('admin.dashboard')}}"
                                                     class="btn btn-danger btn-sm mb-1">
                                                <i class="fas fa-user-secret"></i> @lang('navs.frontend.user.administration')
                                            </a>
                                        @endcan
                                    </p>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header">Subscription</div>
                                <div class="card-body subscription-body">
                                    {{--                                    <h4 class="card-title">Info card title</h4>--}}
                                    @if (!isset($logged_in_user->subscription))
                                        <p class="card-text"><b>You have no active subscription</b></p>
                                        <p class="card-text" style="font-size: 14px;">Trial Period:
                                            <span>1$ / 3 Days</span></p>
                                        <p class="card-text" style="font-size: 14px;">Regular Price: <span>$19.22 / Month</span>
                                        </p>
                                        <a href="javascript:void(0)"
                                           data-user-id="{{ $logged_in_user->id }}"
                                           data-plan-id="{{config('paypal.plan_id')}}"
                                           class="btn btn-info btn-sm mb-1 subscribe-now"><i class="fab fa-paypal"></i> Subscribe</a>
                                    @else
                                        <p class="card-text">Subscription Type: <i class="fab fa-paypal"></i><span> Paypal</span>
                                        </p>
                                        <p class="card-text">Billing ID:
                                            <span>{{$logged_in_user->subscription->agreement_id}}</span></p>
                                        <p class="card-text" style="font-size: 14px;">Trial Period:
                                            <span>1$ / 3 Days</span></p>
                                        <p class="card-text" style="font-size: 14px;">Regular Price: <span>$19.22 / Month</span>
                                        </p>
                                        <p class="card-text">Start Date:
                                            <span>{{ \Carbon\Carbon::parse($logged_in_user->subscription->created_at)->toFormattedDateString()}}</span>
                                        </p>
                                        @if (isset($logged_in_user->cancelRequest))
                                            @if ($logged_in_user->cancelRequest->approved == 1)
                                                <p class="card-text">Your request to Cancel has been approved.</p>
                                                <a href="javascript:void(0)" id="subscription-cancel"
                                                   data-agreement-id="{{ $logged_in_user->subscription->agreement_id }}"
                                                   data-user-id="{{ $logged_in_user->id }}"
                                                   class="btn btn-info btn-sm mb-1"><i class="fas fa-ban"></i>
                                                    Cancel Subscription</a>
                                            @else
                                                <p class="card-text">You have submitted a Cancellation Request</p>
                                                <p class="card-text">Status: <b>Pending</b></p>
                                            @endif
                                        @else
                                            <a href="javascript:void(0)" id="request-cancel"
                                               data-agreement-id="{{ $logged_in_user->subscription->agreement_id }}"
                                               data-user-id="{{ $logged_in_user->id }}"
                                               class="btn btn-info btn-sm mb-1"><i class="fas fa-power-off"></i> Request
                                                Cancel</a>
                                        @endif
                                    @endif
                                </div>
                            </div><!--card-->
                        </div><!--col-md-4-->

                        <div class="col-md-8 order-2 order-sm-1">
                            <h3>Your searches:</h3>
                            <div id="accordion" class="number-accordion">
                                @forelse($user_searches as $user_search)
                                    <div class="card">
                                        <div class="card-header" id="headingOne" data-toggle="collapse"
                                             data-target="#collapse-{{$loop->index}}" aria-expanded="true"
                                             aria-controls="collapse-{{$loop->index}}">
                                            <h5 class="mb-0">
                                                {{$user_search->number->phone_no}} <i class="fas fa-angle-down"></i>
                                            </h5>
                                        </div>
{{--                                        {{dd($user_search->number->phone_data)}}--}}
                                        <div id="collapse-{{$loop->index}}" class="collapse"
                                             aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body">
                                                <p>Owner's Name: <b>{{ isset($user_search->number->phone_data['belongs_to'][0]['name']) ? $user_search->number->phone_data['belongs_to'][0]['name'] : 'N/A' }}</b></p>
                                                <p>Owner's Age: <b>{{ isset($user_search->number->phone_data['belongs_to'][0]['age_range']) ? $user_search->number->phone_data['belongs_to'][0]['age_range'] : 'N/A'}}</b></p>
                                                <p>Alternate Phones:
                                                    @forelse($user_search->number->phone_data['alternate_phones'] as $phone_alt)
                                                        <b>{{$phone_alt}}</b>
                                                    @empty
                                                        <b>N/A</b>
                                                    @endforelse
                                                </p>
                                                <p>Carrier: <b>{{$user_search->number->phone_data['carrier'] != null ? $user_search->number->phone_data['carrier'] : 'N/A'}}</b></p>
                                                <p>Line Type: <b>{{$user_search->number->phone_data['line_type'] != null ? $user_search->number->phone_data['line_type'] : 'N/A'}}</b></p>
                                                <p>Is Valid: <b>{{$user_search->number->phone_data['is_valid'] == true ? 'YES' : 'N/A'}}</b></p>
                                                <p>Is Commercial: <b>{{$user_search->number->phone_data['is_commercial'] == true ? 'YES' : 'N/A'}}</b></p>
                                                <p>Address(s):<br>
                                                    @forelse($user_search->number->phone_data['current_addresses'] as $address)
                                                        <b>{{$address['street_line_1']}}, {{$address['postal_code']}}, {{$address['state_code']}}, {{$address['country_code']}}</b><br>
                                                    @empty
                                                        <b>N/A</b>
                                                    @endforelse
                                                </p>
                                                <p>Associated People:<br>
                                                    @forelse($user_search->number->phone_data['associated_people'] as $people)
                                                        <b>{{$people['name']}} - {{$people['relation']}}</b><br>
                                                    @empty
                                                        <b>N/A</b>
                                                    @endforelse
                                                </p>
                                                <p>Search Date:<br>
                                                    <b>{{$user_search->created_at->format('d M Y, H:i:s')}}</b>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p>You have made no searches. Go to our <a href="{{route('frontend.index')}}">homepage</a>
                                        and user our unique search tool</p>
                                @endforelse

                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <div class="float-left">
                                        {!! $user_searches->total() !!} {{ trans_choice('labels.backend.access.users.table.search_total', $user_searches->total()) }}
                                    </div>
                                </div><!--col-->

                                <div class="col-5">
                                    <div class="float-right">
                                        {!! $user_searches->render() !!}
                                    </div>
                                </div><!--col-->
                            </div><!--row-->
                        </div><!--col-md-8-->
                    </div><!-- row -->
                </div> <!-- card-body -->
            </div><!-- card -->
        </div><!-- row -->
    </div><!-- row -->
@endsection
