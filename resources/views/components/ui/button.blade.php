@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
])

@php
    $variantStyles = [
        'primary' => 'background: #4648d4; color: #ffffff;',
        'secondary' => 'background: #e5eeff; color: #4648d4;',
        'danger' => 'background: #ba1a1a; color: #ffffff;',
        'ghost' => 'background: transparent; color: #464554;',
        'outline' => 'background: transparent; color: #4648d4; border: 1px solid rgba(70,72,212,0.3);',
    ];
    $hoverStyles = [
        'primary' => 'onmouseover="this.style.background=\'#2f2ebe\'" onmouseout="this.style.background=\'#4648d4\'"',
        'secondary' => 'onmouseover="this.style.background=\'#dce9ff\'" onmouseout="this.style.background=\'#e5eeff\'"',
        'danger' => 'onmouseover="this.style.background=\'#93000a\'" onmouseout="this.style.background=\'#ba1a1a\'"',
        'ghost' => 'onmouseover="this.style.background=\'#eff4ff\'" onmouseout="this.style.background=\'transparent\'"',
        'outline' => 'onmouseover="this.style.background=\'#e5eeff\'" onmouseout="this.style.background=\'transparent\'"',
    ];
    $sizeStyles = [
        'sm' => 'padding: 6px 12px; font-size: 12px;',
        'md' => 'padding: 10px 16px; font-size: 12px;',
        'lg' => 'padding: 12px 20px; font-size: 14px;',
        'icon' => 'padding: 8px; width: 36px; height: 36px;',
    ];
    $variantStyle = $variantStyles[$variant] ?? $variantStyles['primary'];
    $hoverStyle = $hoverStyles[$variant] ?? $hoverStyles['primary'];
    $sizeStyle = $sizeStyles[$size] ?? $sizeStyles['md'];
    $baseStyle = "display: inline-flex; align-items: center; justify-content: center; gap: 6px; border-radius: 8px; font-family: 'Geist', sans-serif; font-weight: 500; letter-spacing: 0.02em; border: none; cursor: pointer; transition: all 0.2s; {$variantStyle} {$sizeStyle}";
@endphp

<button type="{{ $type }}" style="{{ $baseStyle }}" {!! $hoverStyle !!} {{ $attributes }}>
    {{ $slot }}
</button>
