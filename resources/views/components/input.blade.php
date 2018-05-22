@php
$usedPrefix = isset($prefix) ? $prefix : 'validation.attributes.';
$usedTitle = __($usedPrefix.$title);
@endphp
<div class="form-group">
                    <label for="{{ $title }}">{{ ucfirst($usedTitle) }}</label>
                    <input type="text" name="{{ $name }}" class="form-control" id="{{ $title }}" placeholder="{{ $usedTitle }}" value="{{ $data ? dataChoice($name,$data) : '' }}">
</div>