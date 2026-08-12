<div {{ $attributes->merge(['class' => 'bg-white rounded-xl overflow-hidden']) }} style="box-shadow: 0 1px 8px rgba(0,0,0,0.04); border: 1px solid rgba(199,196,215,0.15);">
    @if(isset($header))
        <div style="padding: 20px 24px; border-bottom: 1px solid rgba(199,196,215,0.15); font-family: 'Geist', sans-serif; font-size: 16px; font-weight: 600; color: #0b1c30; letter-spacing: -0.02em;">
            {{ $header }}
        </div>
    @endif

    {{ $slot }}

    @if(isset($footer))
        <div style="padding: 16px 24px; border-top: 1px solid rgba(199,196,215,0.15); background: #f8f9ff;">
            {{ $footer }}
        </div>
    @endif
</div>
