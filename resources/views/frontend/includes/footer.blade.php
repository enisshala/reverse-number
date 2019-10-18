<!-- Footer -->
<footer class="page-footer">
    <!-- Footer Links -->
    <div class="container-fluid text-center">
        <!-- Grid row -->
        <div class="row">
            <!-- Grid column -->
            <div class="col-md-12 text-center">
                <!-- Content -->
{{--                <p>Here you can use rows and columns to organize your footer content.</p>--}}
                <ul class="footer-links list-inline">
                    <li class="list-inline-item"><a href="{{route('frontend.about')}}">About</a></li>
                    <li class="list-inline-item"><a href="{{route('frontend.terms')}}">Terms & Conditions</a></li>
                    <li class="list-inline-item"><a href="{{route('frontend.privacy')}}">Privacy Policy</a></li>
                </ul>
            </div>
            <!-- Grid column -->
        </div>
        <!-- Grid row -->
    </div>
    <!-- Footer Links -->
    <!-- Copyright -->
    <div class="footer-copyright text-center">
        <p>© {{ now()->year }} Copyright <a href="/"> {{ config('app.name') }}</a>. All rights reserved.</p>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->
