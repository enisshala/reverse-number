@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.contact.box_title'))

@section('content')
    <div class="row justify-content-center">
        <div class="col col-sm-12 align-self-center">
            <div class="card">
                <div class="card-header">
                    <strong>
                        Terms and Conditions
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    <h1>
                        Terms and Conditions
                    </h1>
                    <p>
                        These Terms and Conditions were last updated on 5/03/2019
                    </p>
                    <p>
                        Thank you for visiting the website located at <a href="{{config('app.name')}}">{{config('app.name')}}</a>
                        (all {{config('app.name')}} platforms will be referred to as the “Website”). The Website is an internet
                        based property of {{config('app.name')}} ("{{config('app.name')}}," "we," "cc," or "us") which allows users to
                        search for information on phone numbers (both regular phone numbers and short code numbers).
                        Please note that your use of our Website constitutes your agreement to follow and be bound by
                        these terms the ‘Terms and Conditions’.
                    </p>
                    <p>
                        {{config('app.name')}}.org does not provide private investigations or consumer reporting. We are not a
                        consumer reporting agency as per the Fair Credit Reporting Act. You are forbidden to use our
                        website or the information we provide in any way to make decisions about employment, consumer
                        credit, insurance, tenant screening, hiring, or any other reason that may require FCRA
                        compliance. All information comes from data sources outside of {{config('app.name')}}.org which could be
                        inaccurate, out of date, or otherwise wrong. We make no guarantee, expressed or implied, as to
                        the accuracy of the data of reports or our service. Errors, including empty reports, may exist
                        in results returned.
                    </p>
                    <p>
                        If you will be using or do use our website, please read the <a href="#clause">Binding
                            Arbitration Clause and the Class Action Waiver</a>.
                    </p>
                    <h4>
                        Scope
                    </h4>
                    <p>
                        These Terms and Conditions apply to you when you: access, view, or use any page on the Website.
                        By using the Website, you acknowledge and agree that you have read, understand, and agree to be
                        bound by these Terms and Conditions in their entirety; consent to the use of electronic
                        signatures, contracts, orders, and other records, and to the electronic delivery of notices,
                        policies, and records of transactions initiated or completed through the site or through any
                        other interactions with {{config('app.name')}}. The Website is available only to individuals that are at
                        least eighteen (18) years of age and that can enter into legally binding contracts under
                        applicable law. If you are under eighteen (18) years of age or do not agree to these Terms and
                        Conditions in their entirety, do not access or use any page on the Website.
                    </p>
                    <p>
                        The {{config('app.name')}}.org Privacy Policy is part of these Terms and Conditions and is incorporated
                        by this reference. By accepting these Terms and Conditions you agree to the collection and use
                        of your information by the Website as described in the <a
                            href="{{config('app.name')}}/privacy-policy">Privacy Policy</a>.
                    </p>
                    <h4>
                        Modifications to the Terms and Conditions
                    </h4>
                    <p>
                        {{config('app.name')}}.org may modify these Terms and Conditions, in whole or in part, from time to time
                        in its sole discretion, effective immediately upon posting modified Terms and Conditions to the
                        Site. If we do update these terms and conditions, we will update our site to reflect the last
                        date they were modified/updated.
                    </p>
                    <h4>
                        Restrictions
                    </h4>
                    <p>
                        {{config('app.name')}}.org is a website database of publicly available information which is aggregated
                        for your viewing. Through {{config('app.name')}}.org, visitors to the Website can view certain text,
                        data, digital conversions, software, and other materials through the Website as compiled and
                        displayed by {{config('app.name')}}.org and other third-party content providers including, but not
                        limited to, third-party websites or services that provide information about individuals and
                        phone numbers that can be searched for and accessed through the Website. You are granted a
                        non-exclusive, non-transferable, revocable, and limited license to access and use the Website
                        and all content contained or displayed on the Website, in accordance with these Terms and
                        Conditions. {{config('app.name')}}.org may terminate this license at any time for any reason at all.
                    </p>
                    <p>
                        In order to access the Website, you agree that you will not:
                    </p>
                    <p>
                        1. Conduct any {{config('app.name')}}.org searches or otherwise obtain or use any information obtained
                        from or through the Website about anyone or any phone number for purposes prohibited under the
                        FCRA.
                    </p>
                    <p>
                        Since {{config('app.name')}}.org is not a Consumer Reporting Agency, you are prohibited under the FCRA
                        from using any information obtained from the Website as a factor in determining a person's
                        eligibility for:
                    </p>
                    <p>
                        Employment, tenancy, personal credit, loans, or insurance, or business transactions.
                    </p>
                    <p>
                        Using information about someone obtained from {{config('app.name')}}.org in these any of the previous
                        ways violates both these Terms and Conditions and the law, which can lead to possible criminal
                        penalties. We reserve the right to terminate user access, delete or ban user accounts, and may
                        even report violations to law enforcement.
                    </p>
                    <p>
                        2. Use the Website in violation of any applicable foreign or domestic laws, rules, and/or
                        regulations; in a way that causes harm to someone, or to harass a person; to seek information
                        about or harm minors in any way.
                    </p>
                    <p>
                        3. Distribute or transmit in any way to any other computer or website, in any way to any third
                        party. You agree to treat any material and information on {{config('app.name')}}.org as confidential
                        information and take all reasonable steps to ensure that it is stored securely.
                    </p>
                    <p>
                        5. Reproduce or compileany part of the Website into any database, website, or information
                        retrieval system in any way.
                    </p>
                    <p>
                        6. Access, retrieve any data from, or do any other activities on or through the Website using
                        any type of software or other automated means (scripts, robots, scrapers, crawlers, or spiders).
                    </p>
                    <p>
                        7. Use any device or software to interfere with the Website working properly.
                    </p>
                    <h4>
                        Our Obligations
                    </h4>
                    <p>
                        {{config('app.name')}}.org allows you to access the Website as it is at any time and has no other
                        obligations, except as expressly stated in these Terms and Conditions. Each user is solely
                        responsible for their use of the Website and any information they obtain from the Website.
                        {{config('app.name')}}.org reserves the right to, but has no obligation to:
                    </p>
                    <p>
                        1. Monitor, review, limit, and/or terminate users' use of the Website, their subscription,
                        and/or their account.
                    </p>
                    <p>
                        2. Moderate any dispute between users and any other third party.
                    </p>
                    <p>
                        3. Verify the identity of users using the Website, including any person who applies to be a
                        Member, as well as the reasoning for which any a person is using the Website.
                    </p>
                    <h4>
                        Subscription Conditions
                    </h4>
                    <p>
                        By submitting an application to create an account, agreeing to these Terms and Conditions, and
                        receiving approval from {{config('app.name')}}.org, visitors of the Website can, for a fee, obtain an
                        account. Accounts are able to, subject to the restrictions contained in these Terms and
                        Conditions and for the applicable fees, conduct phone number searches.
                    </p>
                    <p>
                        The following applies to you only if you submit an application for an account and if your
                        application is approved and you are given an account:
                    </p>
                    <p>
                        1. Registration
                    </p>
                    <p>
                        To access the Website with a membership account, you must be at least eighteen (18) years old
                        with sufficient computer access and an internet connection. {{config('app.name')}}.org may evaluate your
                        account application and may notify you of your acceptance or rejection. {{config('app.name')}}.org may
                        reject your application or terminate your account at any time and for any reason. If you choose
                        to submit an application and create an account, you acknowledge that you have read and agree to
                        these Terms and Conditions.
                    </p>
                    <p>
                        2. Account Termination
                    </p>
                    <p>
                        {{config('app.name')}}.org reserves the right for any reason to restrict, suspend, or terminate your
                        account with or without cause. You may also terminate your Account within seventy-two (72)
                        business hours prior written notice to {{config('app.name')}}.org.
                    </p>
                    <p>
                        Upon any expiration, termination, or suspension of your account:
                    </p>
                    <p>
                        - Any licenses and rights granted to you in connection with these Terms and Conditions shall
                        cease and be terminated.
                    </p>
                    <p>
                        - Any and all information of {{config('app.name')}}.org and the Website that is in your possession or
                        control must be immediately deleted or destroyed. If requested by {{config('app.name')}}.org, you will
                        certify in signed writing that all such confidential information has been deleted or destroyed.
                    </p>
                    <p>
                        - You shall complete payment on any and all fees due at the time and owed to {{config('app.name')}}.org
                        within five (5) days of any account expiration and/or termination.
                    </p>
                    <p>
                        3. Fees and Billing
                    </p>
                    <p>
                        If you want to create a membership account on the Website or purchase any product or service
                        through the Website, you will be presented with the applicable fees and billing arrangement
                        prior to your purchase, which may include the charging of fees to a payment card or Paypal
                        account on a recurring basis. In addition to those fees, you may be responsible for paying any
                        and all sales or use tax due to any and all taxing authorities arising from, or in connection
                        with, your use of the Website. BY SUBMITTING PAYMENT, YOU ACKNOWLEDGE THAT YOU (A) ARE EIGHTEEN
                        (18) YEARS OLD OR OLDER AND (B) HAVE THE LEGAL RIGHT TO USE THE PAYMENT CHOSEN BY YOU. By
                        supplying payment card information, you authorize our use of such information, including our use
                        of such information to third parties for the purposes of payment processing. You also understand
                        and acknowledge that Shortcodes.org uses a third-party payment processor to process credit card
                        payments on our behalf, and when you supply payment information in connection with a purchase
                        you agree that {{config('app.name')}}.org is not responsible for the security of such information when it
                        is in the control of the third-party payment processor.
                    </p>
                    <p>
                        Simply not using the Website or your membership account does not constitute a basis for refusing
                        to pay any of the associated fees or warrant any refund. Upon prior written notice to you
                        (e-mail constitutes sufficient written notice), {{config('app.name')}}.org reserves the right in its sole
                        discretion to change its pricing or billing methods. By choosing to not terminate your
                        membership account within seven (7) days after receiving a notice of changes, you agree to
                        comply with and be bound by the new pricing or billing methods. If you do terminate your
                        account, you must still pay any and all fees that you have already incurred.
                    </p>
                    <p>
                        Your account may be deactivated or deleted, and access to the Website may be denied for a
                        failure to pay.
                    </p>
                    <h4 id="clause">
                        Binding Arbitration and Class Action Waiver
                    </h4>
                    <p>
                        Class action lawsuits, class-wide arbitrations, private attorney-general actions, and any other
                        proceeding where someone acts in a representative capacity are not allowed. Neither is combining
                        individual proceedings without the consent of all parties.
                    </p>
                    <h4>
                        To Contact Us
                    </h4>
                    <p>
                        If you have any questions about these Terms and Conditions, if you would like to register a
                        complaint, or notify {{config('app.name')}}.org of a dispute, please feel free to contact us at <a
                            href="mailto:support@truenumber.cc">support@truenumber.cc</a>.
                    </p>

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
