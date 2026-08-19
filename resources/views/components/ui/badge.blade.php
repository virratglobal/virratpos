@props([
    'variant' => 'info',
])

@php
    $variantStyles = [
        'info' => 'background: #f1f1f1; color: #000000 !important;',
        'primary' => 'background: #f1f1f1; color: #000000 !important;',
        'success' => 'background: #e8f5e9; color: #1a7431;',
        'warning' => 'background: #fff3e0; color: #904900;',
        'danger' => 'background: #ffdad6; color: #ba1a1a !important;',
        'error' => 'background: #ffdad6; color: #ba1a1a !important;',
        'gray' => 'background: #eff4ff; color: #464554 !important !important;',
        'secondary' => 'background: #dae2fd; color: #565e74;',
    ];
    $style = $variantStyles[$variant] ?? $variantStyles['info'];
@endphp

<span style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; border-radius: 6px; font-family: 'Geist', sans-serif; font-size: 11px; font-weight: 500; letter-spacing: 0.02em; {{ $style }}" {{ $attributes }}>
    {{ $slot }}
</span>
