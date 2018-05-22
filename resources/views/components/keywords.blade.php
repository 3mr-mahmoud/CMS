<div class="form-group">
	<label for="keywords">{{ __('Validation.attributes.keywords') }}</label>
<select name="keywords[]" id="keywords" multiple data-role="tagsinput">
	@if(isset($data))
	@foreach($data->keywords as $keyword)
  <option value="{{ $keyword }}">{{ $keyword }}</option>
  @endforeach
  @endif
</select>
</div>