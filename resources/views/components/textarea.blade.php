@php
$usedPrefix = isset($prefix) ? $prefix : 'validation.attributes.';
@endphp
<div class="form-group">
                    <label for="{{ $title }}">{{ ucfirst(__($usedPrefix.$title)) }}</label>
                    <textarea rows="{{ isset($rows) ? $rows : 3 }}" name="{{ $name }}" class="form-control" id="{{ $title }}"
                              placeholder="{{ __($usedPrefix.$title) }}">{{ $data ? dataChoice($name, $data) : '' }}</textarea>
</div>