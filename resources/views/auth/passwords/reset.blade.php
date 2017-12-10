@extends('layouts.app')

@section('main')
	<div class="container">
		<div class="row">
			<div class="col s12 m10 offset-m1 l8 offset-l2 card z-depth-2">
				<div class="card-content">
					<div class="card-title {{ $synthesiscmsMainColor }}-text">{{ trans('synthesiscms/auth.reset') }}</div>
					<div class="col s12 divider row {{ $synthesiscmsMainColor }} {{ $synthesiscmsMainColorClass }}"></div>
					@if (session('status'))
						@include('partials/message', ['message' => session('status')])
					@endif
					<form class="form-horizontal" role="form" method="POST"
						  action="{{ route('password.request') }}">
						{{ csrf_field() }}

						<input type="hidden" name="token" value="{{ $token }}">

						<div class="input-field">
							<label for="email"
							   class="col-md-4 control-label">{{ trans('synthesiscms/auth.email_address') }}</label>
							<input id="email" type="email" class="form-control" name="email"
								   value="{{ $email or old('email') }}" required autofocus>
							@if ($errors->has('email'))
								<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
							@endif
						</div>

						<label for="password"
							   class="col-md-4 control-label">{{ trans('synthesiscms/auth.word_password') }}</label>

						<div class="col-md-6">
							<input id="password" type="password" class="form-control" name="password" required>

							@if ($errors->has('password'))
								<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
							@endif
						</div>

						<label for="password-confirm"
							   class="col-md-4 control-label">{{ trans('synthesiscms/auth.confirm_password') }}</label>
						<div class="col-md-6">
							<input id="password-confirm" type="password" class="form-control"
								   name="password_confirmation" required>
							@if ($errors->has('password_confirmation'))
								<span class="help-block">
								<strong>{{ $errors->first('password_confirmation') }}</strong>
							</span>
							@endif
						</div>

						<button type="submit" class="btn btn-primary">
							{{ trans('synthesiscms/auth.reset') }}
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
