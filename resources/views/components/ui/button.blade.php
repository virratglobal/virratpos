@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
])

@php
    $variantStyles = [
        'primary' => 'background: #000000; color: #ffffff !importantfff !important;',
        'secondary' => 'background: #f1f1f1; color: #000000 !important;',
        'danger' => 'background: #ba1a1a; color: #ffffff !importantfff !important;',
        'ghost' => 'background: transparent; color: #464554 !important !important;',
        'outline' => 'background: transparent; color: #000000 !important; border: 1px solid rgba(0,0,0,0.15);',
    ];
    $hoverStyles = [
        'primary' => 'onmouseover="this.style.background=\'#222222\'" onmouseout="this.style.background=\'#000000\'"',
        'secondary' => 'onmouseover="this.style.background=\'#e5e5e5\'" onmouseout="this.style.background=\'#f1f1f1\'"',
        'danger' => 'onmouseover="this.style.background=\'#93000a\'" onmouseout="this.style.background=\'#ba1a1a\'"',
        'ghost' => 'onmouseover="this.style.background=\'#eff4ff\'" onmouseout="this.style.background=\'transparent\'"',
        'outline' => 'onmouseover="this.style.background=\'#f1f1f1\'" onmouseout="this.style.background=\'transparent\'"',
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
