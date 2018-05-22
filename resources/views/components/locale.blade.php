
<div class="row">
	@foreach(config('app.locales') as $locale)
		<label class="radio-inline mr-2 ml-2">
			<input type="radio" name="locale" value="{{ $locale }}" 
		{{ ($locale == config('app.fallback_locale') && !isset($data)) ? 'checked' : ''}}
			{{ (isset($data) && $locale == $data->locale) ? 'checked' : '' }}
			/> {{ $locale }}
		</label>
		@endforeach
</div>