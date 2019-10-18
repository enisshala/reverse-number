@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.register_box_title'))

@section('content')
    <div class="row justify-content-center align-items-center">
        <div class="col col-sm-8 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                        @lang('labels.frontend.auth.register_box_title')
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    <form action="{{route('frontend.create-account')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.first_name'))->for('first_name') }}

                                    {{ html()->text('first_name')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.first_name'))
                                        ->attribute('maxlength', 191)
                                        ->required()}}
                                </div><!--col-->
                            </div><!--row-->

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.last_name'))->for('last_name') }}

                                    {{ html()->text('last_name')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.last_name'))
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                                    {{ html()->email('email')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.email'))
                                        ->attribute('maxlength', 191)
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}

                                    {{ html()->password('password')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.password'))
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                                    {{ html()->password('password_confirmation')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                        <div class="row">
                            <div class="col">
                                <p>Your trial will last for 3 days. You may cancel before your trial ends for any reason and you will not incur further charges. You may visit subscription page to cancel your trial.</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" required>
                                    <label class="form-check-label sign-up" for="defaultCheck1">
                                        I understand that unless I cancel before the <span>3</span> day trial period ends, I will be automatically enrolled in a monthly subscription plan and billed <span>$19.22</span> per month on a recurring monthly basis unless and until I cancel. I agree that there are no refunds.<br>
                                        I certify that I am over <span>18</span> years of age and agree to accept the <a href="{{route('frontend.terms')}}">Terms & Conditions</a> and <a href="{{route('frontend.privacy')}}">Privacy Policy</a>.<br><br>
                                    </label>
                                </div>
                            </div>
                        </div>

                        @if(config('access.captcha.registration'))
                            <div class="row">
                                <div class="col">
                                    @captcha
                                    {{ html()->hidden('captcha_status', 'true') }}
                                </div><!--col-->
                            </div><!--row-->
                        @endif

                        @if (isset($_GET['nr_search']))
                            <input type="hidden" value="{{$_GET['nr_search']}}" name="nr_search" id="nr_search">
                        @endif

                        <input type="hidden" value="{{config('paypal.plan_id')}}" name="plan_id" id="plan_id">

                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-0 clearfix">
                                    <button class="btn btn-success btn-md pull-right" type="submit"><i class="fab fa-paypal"></i> Pay & Join</button>
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                    </form>

                    {{--                    <div class="row">--}}
                    {{--                        <div class="col">--}}
                    {{--                            <div class="text-center">--}}
                    {{--                                {!! $socialiteLinks !!}--}}
                    {{--                            </div>--}}
                    {{--                        </div><!--/ .col -->--}}
                    {{--                    </div><!-- / .row -->--}}

                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col-md-8 -->
    </div><!-- row -->
@endsection

@push('after-scripts')
    @if(config('access.captcha.registration'))
        @captchaScripts
    @endif
@endpush
