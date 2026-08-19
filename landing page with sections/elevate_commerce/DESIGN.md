---
name: Elevate Commerce
colors:
  surface: '#fbf9f8'
  surface-dim: '#dbd9d9'
  surface-bright: '#fbf9f8'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f5f3f3'
  surface-container: '#f0eded'
  surface-container-high: '#eae8e7'
  surface-container-highest: '#e4e2e2'
  on-surface: '#1b1c1c'
  on-surface-variant: '#434656'
  inverse-surface: '#303030'
  inverse-on-surface: '#f2f0f0'
  outline: '#737688'
  outline-variant: '#c3c5d9'
  surface-tint: '#004fe6'
  primary: '#0043c8'
  on-primary: '#ffffff'
  primary-container: '#0058ff'
  on-primary-container: '#e6e9ff'
  inverse-primary: '#b6c4ff'
  secondary: '#5f5e5e'
  on-secondary: '#ffffff'
  secondary-container: '#e5e2e1'
  on-secondary-container: '#656464'
  tertiary: '#4f5253'
  on-tertiary: '#ffffff'
  tertiary-container: '#686a6b'
  on-tertiary-container: '#e9ebec'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dce1ff'
  primary-fixed-dim: '#b6c4ff'
  on-primary-fixed: '#00164f'
  on-primary-fixed-variant: '#003bb1'
  secondary-fixed: '#e5e2e1'
  secondary-fixed-dim: '#c8c6c5'
  on-secondary-fixed: '#1c1b1b'
  on-secondary-fixed-variant: '#474646'
  tertiary-fixed: '#e1e3e4'
  tertiary-fixed-dim: '#c5c7c8'
  on-tertiary-fixed: '#191c1d'
  on-tertiary-fixed-variant: '#454748'
  background: '#fbf9f8'
  on-background: '#1b1c1c'
  surface-variant: '#e4e2e2'
typography:
  display-lg:
    fontFamily: Hanken Grotesk
    fontSize: 64px
    fontWeight: '700'
    lineHeight: 72px
    letterSpacing: -0.02em
  display-lg-mobile:
    fontFamily: Hanken Grotesk
    fontSize: 40px
    fontWeight: '700'
    lineHeight: 48px
    letterSpacing: -0.01em
  headline-lg:
    fontFamily: Hanken Grotesk
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Hanken Grotesk
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-sm:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.05em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  xs: 0.25rem
  sm: 0.5rem
  md: 1rem
  lg: 1.5rem
  xl: 2.5rem
  xxl: 4rem
  container-max: 1280px
  gutter: 24px
  margin-mobile: 16px
---

## Brand & Style
The design system is a premium, high-fidelity framework tailored for modern e-commerce SaaS. It prioritizes clarity and high-end aesthetics by blending **Minimalism** with subtle **Glassmorphism**. The target audience is scaling entrepreneurs and luxury brands who require a platform that feels both powerful and invisible.

The emotional response should be one of "effortless sophistication." By utilizing expansive whitespace and a restrained color palette, the UI allows product content to take center stage. Visual interest is generated not through heavy decoration, but through precision, hairline strokes, and high-quality typography.

## Colors
The palette is dominated by "Pure White" to create a sense of infinite space. 

- **Primary (#0058FF):** A vibrant, digital-first blue used exclusively for primary actions, progress indicators, and key focus states.
- **Secondary (#111111):** Used for headlines to provide a grounded, authoritative contrast.
- **Neutral (#444444):** A softened charcoal for body text to reduce eye strain while maintaining legibility.
- **Surface (#F8F9FA):** Used for subtle section nesting and container backgrounds to differentiate from the main page white without adding visual weight.
- **Border (#EEEEEE):** A hairline grey used for structural definition.

## Typography
This design system utilizes **Hanken Grotesk** for headings to provide a sharp, contemporary geometric feel. **Inter** is used for body and UI elements to ensure maximum utility and readability.

Headings should use generous tracking (letter-spacing) in uppercase labels, but tight tracking in large display sizes to maintain a "locked-in" professional look. Ensure body text never drops below 14px to maintain the premium, accessible feel of the brand.

## Layout & Spacing
The layout follows a **Fluid Grid** model with strict adherence to an 8px spacing scale. 

- **Desktop:** 12-column grid, 1280px max-width, 24px gutters.
- **Tablet:** 8-column grid, 24px margins.
- **Mobile:** 4-column grid, 16px margins.

Spacing should be "expansive." When in doubt, increase the vertical margin (`xxl`) between major sections to emphasize the minimalist aesthetic. Elements within cards should use `lg` (24px) padding consistently.

## Elevation & Depth
Depth is conveyed through **Ambient Shadows** and **Tonal Layers**. 

1. **Flat Layer:** Use the `background` white for the primary canvas.
2. **Surface Layer:** Use `#F8F9FA` for secondary containers (sidebar, feed backgrounds) with no shadow and a hairline border.
3. **Elevated Layer:** Use white surfaces with an extremely diffused shadow: `0px 10px 40px rgba(0, 0, 0, 0.04)`. This creates a "floating" effect without looking heavy.
4. **Interactive Layer:** On hover, shadows should subtly deepen to `0px 14px 50px rgba(0, 0, 0, 0.08)` to provide tactile feedback.

## Shapes
The design system uses a "Rounded" language to soften the geometric typography. 

- **Standard Elements:** (Buttons, Inputs, Small Cards) use a **12px** radius.
- **Large Containers:** (Product Cards, Modals, Section Overlays) use a **24px** radius (`rounded-xl`).
- **Interactive Triggers:** Small utility buttons (icon-only) may use a full pill shape for distinctiveness.

## Components
- **Buttons:** Primary buttons use the vibrant blue with white text. Secondary buttons use a hairline border (`#EEEEEE`) with a transparent background. Hover states should include a subtle 2px lift or a slight background darkening.
- **Input Fields:** Fields should be 48px height with a `#F8F9FA` background and no border until focused. Upon focus, they transition to a white background with a 1px `#0058FF` stroke.
- **Cards:** Cards are the cornerstone. They feature a white background, a 1px `#EEEEEE` border, and the signature `0.04` opacity ambient shadow.
- **Chips:** Small, pill-shaped indicators using `#F8F9FA` background and `#444444` text.
- **Animation:** Use a standard transition of `200ms cubic-bezier(0.4, 0, 0.2, 1)`. Page transitions should use a "Fade and Slide Up" reveal (20px offset) to simulate a high-end application experience.