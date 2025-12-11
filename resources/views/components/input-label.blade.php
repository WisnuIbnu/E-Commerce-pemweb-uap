<label {{ $attributes->merge(['class' => 'form-label']) }} 
    style="font-weight: 500; color:#1b1b1b;">
    {{ $value ?? $slot }}
</label>