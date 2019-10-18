@extends('frontend.layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center mb-3">
        <div class="col col-sm-10 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                        Payment Success
                    </strong>
                </div>
                <div class="card-body">
                    <h1>Subscription added successfully</h1><br>
                    <p>Subscription ID: <b>{{$agreement->id}}</b></p>
                    <p>State: <b>{{$agreement->state}}</b></p>
                    <p>Paypal Email: <b>{{$agreement->payer->payer_info->email}}</b></p><br>
                    <a href="{{route('frontend.index')}}" class="btn btn-info btn-sm mb-1"><i class="fas fa-home"></i>
                        Home</a>
                    <a href="{{route('frontend.user.dashboard')}}" class="btn btn-info btn-sm mb-1"><i
                            class="fas fa-columns"></i> Dashboard</a>
                </div><!--card body-->
            </div><!-- card -->
        </div>
    </div>
    @if (isset($phone_data))
        <div class="row justify-content-center align-items-center mb-3">
            <div class="col col-sm-10 align-self-center">
                <div class="card">
                    <div class="card-header">
                        <strong>
                            Number Details - {{$phone_data['phone_number']}}
                        </strong>
                    </div>
                    {{--                {{dd($phone_data)}}--}}
                    <div class="card-body">
                        @if (count($phone_data['belongs_to']) > 0)
                            <p>Owner's Name:
                                <b>{{$phone_data['belongs_to'][0]['name'] != null ? $phone_data['belongs_to'][0]['name'] : 'N/A'}}</b>
                            </p>
                            <p>Owner's Age:
                                <b>{{$phone_data['belongs_to'][0]['age_range'] != null ? $phone_data['belongs_to'][0]['age_range'] : 'N/A'}}</b>
                            </p>
                        @else
                            <p>Owner's Name: <b>N/A</b></p>
                            <p>Owner's Age: <b>N/A</b></p>
                        @endif
                        <p>Alternate Phones:
                            @forelse($phone_data['alternate_phones'] as $phone_alt)
                                <b>{{$phone_alt}}</b>
                            @empty
                                <b>N/A</b>
                            @endforelse
                        </p>
                        <p>Carrier: <b>{{$phone_data['carrier'] != null ? $phone_data['carrier'] : 'N/A'}}</b></p>
                        <p>Line Type: <b>{{$phone_data['line_type'] != null ? $phone_data['line_type'] : 'N/A'}}</b></p>
                        <p>Is Valid: <b>{{$phone_data['is_valid'] == true ? 'YES' : 'N/A'}}</b></p>
                        <p>Address(s):<br>
                            @forelse($phone_data['current_addresses'] as $address)
                                <b>{{$address['street_line_1']}}, {{$address['postal_code']}}
                                    , {{$address['state_code']}}, {{$address['country_code']}}</b><br>
                            @empty
                                <b>N/A</b>
                            @endforelse
                        </p>
                        <p>Associated People:<br>
                            @forelse($phone_data['associated_people'] as $people)
                                <b>{{$people['name']}} - {{$people['relation']}}</b><br>
                            @empty
                                <b>N/A</b>
                            @endforelse
                        </p>
                        {{--                    <a href="{{route('frontend.index')}}" class="btn btn-info btn-sm mb-1"><i class="fas fa-home"></i> Home</a>--}}
                        {{--                    <a href="{{route('frontend.user.dashboard')}}" class="btn btn-info btn-sm mb-1"><i class="fas fa-columns"></i> Dashboard</a>--}}
                    </div><!--card body-->
                </div><!-- card -->
            </div><!-- col-xs-12 -->
        </div><!-- row -->
    @else
        @if(isset($_GET['nr_search']))
            <div class="row justify-content-center align-items-center mb-3">
                <div class="col col-sm-10 align-self-center">
                    <div class="card">
                        <div class="card-header">
                            <strong>
                                Number Details - {{$_GET['nr_search']}}
                            </strong>
                        </div>
                        {{--                {{dd($phone_data)}}--}}
                        <div class="card-body">
                            <p>We cant find the number you searched for, please check you number and try again in our <a
                                    href="{{route('frontend.index')}}">homepage</a></p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection
