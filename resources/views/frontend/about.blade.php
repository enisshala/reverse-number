@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.contact.box_title'))

@section('content')
    <div class="row justify-content-center">
        <div class="col col-sm-12 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                        About
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    {{config('app.name')}}.org is not a private investigation service and we do not provide consumer reporting services. You may not use this site or the information on it in any way to make decisions about employment, consumer credit, insurance, tenant screening, hiring, or any other reason that may require FCRA compliance. All information comes from data sources outside of {{config('app.name')}}.org which could be inaccurate, out of date, or otherwise wrong. We make no guarantee, expressed or implied, as to the accuracy of the data of reports or our service. Errors, including empty reports, may exist in results returned. You agree to be fully responsible for your use of the site and to indemnify us against all claims and legal costs that may arise out of your use of it.
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection

@push('after-scripts')
    @if(config('access.captcha.contact'))
        @captchaScripts
    @endif
@endpush
