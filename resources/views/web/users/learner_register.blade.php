@extends('layouts.web')

@section('content')
    <div class="show-top-grids">
        <h1>Learner register</h1>

        @include('web.users.register_form', ['legalUrl' => route('legal.users.register.learner'), 'successMessage' => '<p>Thank you for registering as Learner. Now you can learn everything with our mentors.</p>', 'formUrl' => route('user.register.learner.store')])
    </div>
@endsection

