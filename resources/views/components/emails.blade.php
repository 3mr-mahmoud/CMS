<div class="form-group">
	<label for="emails">{{ __('Validation.attributes.email') }}</label>
<select name="emails" id="emails" multiple data-role="tagsinput">
	@if(isset($data))
	@foreach($data->emails as $email)
  <option value="{{ $email }}">{{ $email }}</option>
  @endforeach
  @endif
</select>
</div>