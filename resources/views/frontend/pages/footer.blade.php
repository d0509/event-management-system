@section('footer')
    <footer class="footer-section  ">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-text">
                        <div class="ft-logo">
                            <a href="#" class="footer-logo"><img src="img/footer-logo.png" alt=""></a>
                        </div>
                        <ul>
                            <li><a href="{{ route('home') }}"> {{ __('footer_home') }} </a></li>

                            <li><a href="{{ route('user.contact-us.index') }}"> {{ __('footer_contact') }} </a></li>
                        </ul>
                        <div class="copyright-text">
                            {{ __('footer_copyright') }} &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            {{ __('footer_rights_reserved') }}
                        </div>
                        <div class="ft-social">
                            <a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a>
                            <a href="https://twitter.com/"><i class="fa fa-twitter"></i></a>
                            <a href="https://www.linkedin.com/in/"><i class="fa fa-linkedin"></i></a>
                            <a href="https://www.instagram.com/"><i class="fa fa-instagram"></i></a>
                            <a href="https://www.youtube.com/"><i class="fa fa-youtube-play"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endsection
