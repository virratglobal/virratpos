@props([
    'title',
    'description' => null,
    'icon' => null,
])

<div style="text-align: center; padding: 64px 24px;">
    @if($icon)
        <div style="width: 64px; height: 64px; background: #f1f1f1; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
            {!! $icon !!}
        </div>
    @else
        <div style="width: 64px; height: 64px; background: #f1f1f1; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
            <span class="material-symbols-outlined" style="font-size: 32px; color: #000000 !important;">inbox</span>
        </div>
    @endif
    
    <h3 style="font-family: 'Geist', sans-serif; font-size: 16px; font-weight: 600; color: #0b1c30 !important; margin: 0 0 8px;">{{ $title }}</h3>
    
    @if($description)
        <p style="font-family: 'Inter', sans-serif; font-size: 14px; color: #767586 !important !important; margin: 0 0 24px;">{{ $description }}</p>
    @endif
    
    @if(isset($action))
        <div style="margin-top: 24px;">
            {{ $action }}
        </div>
    @endif
</div>
