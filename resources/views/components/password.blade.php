@php
$segments = request()->segments();
$addPage = end($segments) == 'add';
@endphp
<div class="form-group">
		<label for="passsword">
			{{ __('Validation.attributes.password') }}
			@if(!$addPage)<span class='small'>{{ __('labels.leaveBlank') }}</span>@endif
		</label>
		<input type="password" id="password" class="form-control" name="password" placeholder="{{ __('Validation.attributes.password') }}">
		@if($addPage)
		<label for="passsword"> {{ __('labels.passwordconfirm') }} </label>
		<input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="{{ __('labels.passwordconfirm') }}">
		@endif
</div>