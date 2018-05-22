@php
if(isset($data)) {
$active = ($data->active == 1) ? 'checked' : '';
$unactive = ($data->active == 0) ? 'checked' : '';	
} else {
	$active = 'checked';
}
@endphp
<div class="row">
		<label class="radio-inline mr-2 ml-2">
			<input type="radio" name="active" value="1" {{ $active }}>{{ __('labels.active') }}
		</label>
		<label class="radio-inline mr-2 ml-2">
			<input type="radio" name="active" value="0" {{ isset($unactive) ? $unactive : '' }}>{{ __('labels.unactive') }}
		</label>
</div>