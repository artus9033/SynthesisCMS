@extends('layouts.app')

<!-- Main Content -->
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
					<form role="form" method="POST" action="{{ route('password.email') }}">
						{{ csrf_field() }}
						<div class="input-field">
							<label for="email"
								   class="col-md-4 control-label">{{ trans('synthesiscms/auth.email_address') }}</label>
							<input id="email" type="email" class="form-control" name="email"
								   value="{{ old('email') }}" required>

							@if ($errors->has('email'))
								<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
							@endif
						</div>

						<button type="submit" class="btn btn-primary">
							{{ trans('synthesiscms/auth.send_password_reset_link') }}
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
