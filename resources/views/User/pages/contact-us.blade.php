@extends('User.pages.dashboard')
@section('title', 'Contact Us')
@section('user.contact_us.create')
    <section class="contact-from-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Contact Us By Email!</h2>
                        <p>Fill out the form below to recieve a free and confidential intial consultation.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('user.contact-us.store')}}" method="POST" class="comment-form contact-form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <input type="text" name="name" value="{{old('name')}}" placeholder="Name">
                                @error('name')
                                    <span class="text-danger" > {{$message}} </span>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <input type="text" value="{{old('email')}}" name="email" placeholder="Email">
                                @error('email')
                                    <span class="text-danger" > {{$message}} </span>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <input type="text" name="phone" value="{{old('phone')}}" placeholder="Phone">
                                @error('phone')
                                    <span class="text-danger" > {{$message}} </span>
                                @enderror
                            </div>
                            <div class="col-lg-12 text-center">
                                <textarea placeholder="Messages" name="message" > {{old('message')}} </textarea>
                                @error('message')
                                <span class="text-danger" > {{$message}} </span>
                                @enderror
                            </div>
                            <button type="submit" class="site-btn">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
