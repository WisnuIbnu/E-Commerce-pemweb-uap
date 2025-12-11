<button 
    {{ $attributes->merge(['class' => 'btn w-100 text-white fw-semibold']) }}
    style="
        background: #A2D2FF !important;
        border-radius: 12px;
        padding: 10px 16px;
        font-family: 'Lexend', sans-serif;
    ">
    {{ $slot }}
</button>