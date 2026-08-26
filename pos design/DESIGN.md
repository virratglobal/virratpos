---
name: Precision Engineering
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#464554'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#767586'
  outline-variant: '#c7c4d7'
  surface-tint: '#494bd6'
  primary: '#4648d4'
  on-primary: '#ffffff'
  primary-container: '#6063ee'
  on-primary-container: '#fffbff'
  inverse-primary: '#c0c1ff'
  secondary: '#565e74'
  on-secondary: '#ffffff'
  secondary-container: '#dae2fd'
  on-secondary-container: '#5c647a'
  tertiary: '#904900'
  on-tertiary: '#ffffff'
  tertiary-container: '#b55d00'
  on-tertiary-container: '#fffbff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#e1e0ff'
  primary-fixed-dim: '#c0c1ff'
  on-primary-fixed: '#07006c'
  on-primary-fixed-variant: '#2f2ebe'
  secondary-fixed: '#dae2fd'
  secondary-fixed-dim: '#bec6e0'
  on-secondary-fixed: '#131b2e'
  on-secondary-fixed-variant: '#3f465c'
  tertiary-fixed: '#ffdcc5'
  tertiary-fixed-dim: '#ffb783'
  on-tertiary-fixed: '#301400'
  on-tertiary-fixed-variant: '#703700'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  display:
    fontFamily: Geist
    fontSize: 36px
    fontWeight: '600'
    lineHeight: 40px
    letterSpacing: -0.04em
  headline-lg:
    fontFamily: Geist
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
    letterSpacing: -0.02em
  headline-md:
    fontFamily: Geist
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
    letterSpacing: -0.02em
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  body-sm:
    fontFamily: Inter
    fontSize: 13px
    fontWeight: '400'
    lineHeight: 18px
  label-md:
    fontFamily: Geist
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
    letterSpacing: 0.02em
  mono:
    fontFamily: jetbrainsMono
    fontSize: 13px
    fontWeight: '400'
    lineHeight: 20px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 4px
  container-max: 1440px
  sidebar-width: 240px
  sidebar-collapsed: 64px
  gutter: 24px
  margin-mobile: 16px
  margin-desktop: 32px
---

## Brand & Style
The design system embodies a **Modern SaaS/Enterprise** aesthetic, prioritizing clarity, efficiency, and professional rigor. It draws inspiration from high-performance developer tools and commerce platforms, utilizing a **Minimalist-Professional** style. 

The visual narrative is built on high data density and structural integrity. It avoids decorative elements in favor of functional clarity, using whitespace not just as "room to breathe" but as a deliberate tool for grouping information. The emotional response should be one of reliability, speed, and absolute control over complex workflows.

## Colors
The palette is rooted in a sophisticated range of slates and grays to maintain a neutral backdrop for complex data. 

- **Primary Indigo** is reserved for high-intent actions and active states.
- **Surface Neutrals** define the structural hierarchy; use `#f8fafc` for subtle containment and background layering.
- **Semantic Colors** follow industry standards for immediate recognition but are applied with restraint—primarily through small indicators, text, or subtle background washes.
- **Dark Mode** should invert the scale, using `#020617` as the deep base and `#1e293b` for elevated surfaces.

## Typography
The system utilizes a dual-font approach for maximum precision. 

- **Geist** is used for headings and labels to provide a technical, modern edge with its slightly condensed proportions and tight tracking.
- **Inter** handles all body copy and tabular data to ensure maximum legibility at small scales.
- **Tabular figures** should be enabled for all data-heavy tables to ensure vertical alignment of numbers.
- **Tracking:** Apply `-2%` to `-4%` tracking on all headlines above 20px to achieve the "Vercel-style" density.

## Layout & Spacing
The layout follows a **Fluid-Fixed Hybrid** model. The sidebar remains fixed (or collapsible) while the main content area occupies the remaining width up to a maximum of 1440px.

- **Grid:** Use a 12-column grid for dashboard layouts.
- **Density:** Spacing is tight (utilizing a 4px baseline) to accommodate complex commerce and data views. 
- **Adaptation:** On mobile, sidebars transition to a drawer overlay. Margins reduce from 32px to 16px. Content-heavy tables should allow horizontal scroll with frozen first columns.

## Elevation & Depth
Depth is created through **Tonal Layering** supplemented by extremely subtle ambient shadows. 

- **Level 0 (Background):** `#ffffff` or `#020617`.
- **Level 1 (Cards/Sidebar):** `#f8fafc` or `#0f172a` with a 1px border of `10% contrast`.
- **Shadows:** Use "Stripe-style" shadows—multi-layered, high-diffusion, and low-opacity (e.g., `0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px -1px rgba(0,0,0,0.1)`).
- **Interactivity:** Elements should feel "pressed" rather than "lifted" when active. Use subtle inner shadows for active states on buttons and inputs.

## Shapes
A **Rounded** language is applied consistently to soften the technical nature of the UI.

- **Standard (8px):** Applied to buttons, input fields, and small cards.
- **Large (12px):** Applied to main content containers and modals.
- **Pill:** Reserved exclusively for status badges and tags.
- **Borders:** All bordered elements use a consistent 1px width. Use `slate-200` for light mode and `slate-800` for dark mode.

## Components
- **Buttons:** Primary buttons use solid Indigo with white text. Secondary buttons use a subtle gray border with a white surface. Ghost buttons are reserved for utility actions in toolbars.
- **High-Density Tables:** Use a 13px font size (`body-sm`). Rows should have a height of 40px with subtle dividers. Header rows use `label-md` with a background of `surface_hex`.
- **Status Badges:** Use a "Soft" style—10% opacity background of the semantic color with 100% opacity text of the same color.
- **Sidebar:** 
    - *Inset:* Floating within a container with a 12px margin from the screen edge.
    - *Minimal:* Icon-only with tooltips.
- **Input Fields:** Use a 1px border. On focus, apply a 2px Indigo ring with 20% opacity.
- **Motion:** Transitions for hover states and sidebar toggles are set to `150ms ease-out`.