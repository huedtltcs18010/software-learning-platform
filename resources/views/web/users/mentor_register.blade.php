@extends('layouts.web')

@section('content')
    <div class="show-top-grids">
        <h1>Mentor register</h1>

        @include('web.users.register_form', ['legalUrl' => route('legal.users.register.mentor'), 'successMessage' => '<p>Thank you for registering as Mentor. Now you can upload and share your videos.</p>', 'formUrl' => route('user.register.mentor.store')])
    </div>
@endsection
