<div class="form-group">
<label for="locale">{{ __('Validation.attributes.locale') }}</label>
	<select id="locale" name="locale" class="form-control">
		@foreach(config('app.locales') as $locale)
		<option value="{{ $locale }}" {{ $locale == config('app.fallback_locale') ? "selected" : ""}}>{{ $locale }}</option>
		@endforeach
	</select>
</div>