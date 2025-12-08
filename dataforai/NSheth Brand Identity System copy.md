# NSheth Brand Identity System

_A minimal, refined, designer-forward identity built for digital use._

---

## 🖼️ Logo Preview

> *(Insert final logo image here)*  
> Recommended: use full wordmark on soft peach background.

---

## 🎯 Brand Overview

**NSheth** is a digital-first personal brand representing execution-based services in design, tech, and consulting. The identity is professional, minimal, and soft — built for readability, contrast, and timeless digital presentation.

- **Usage**: Portfolio, business site, blog
- **Feel**: Soft luxury, high trust, warm minimalism
- **Focus**: Typography, contrast, digital-first UI

---

## 🎨 Color System

### Light Mode (Primary)

| Role | Name | Hex |
|------|------|-----|
| Background | Soft Peach | `#FFF2D7` |
| Text (Headings/Body) | Rich Brown | `#1E1B18` |
| Accent / CTA | Soft Salmon | `#F98866` |
| Muted Text | Dusty Brown | `#6E645E` |
| Surface (cards) | Pale Peach | `#FAECD0` |
| Dividers / Lines | Warm Gray | `#E6D7C2` |

> All colors meet WCAG contrast standards on background.

### Dark Mode (Optional)

| Role       | Name          | Hex       |
| ---------- | ------------- | --------- |
| Background | Dark Cocoa    | `#1A1816` |
| Text       | Soft Peach    | `#FFF2D7` |
| Accent     | Salmon Bright | `#F98866` |
| Muted      | Taupe         | `#A0897A` |
|            |               |           |

---

## 🔠 Font System

Only two fonts used for a clean, timeless setup:

| Use | Font | Style |
|-----|------|-------|
| Headings | Domine | Slab serif, elegant |
| Body | Manrope | Sans-serif, modern |

### Typography Scale

| Element | Font    | Size | Color     |
| ------- | ------- | ---- | --------- |
| H1      | Domine  | 42px | `#1E1B18` |
| H2      | Domine  | 32px | `#1E1B18` |
| Body    | Manrope | 20px | `#1E1B18` |
| Caption | Manrope | 16px | `#6E645E` |

| Tag | Font Size (Clamp in px)  | Line Height (Clamp in px)  |
| --- | ------------------------ | -------------------------- |
| h1  | `clamp(32px, 8vw, 62px)` | `clamp(38px, 9vw, 72px)`   |
| h2  | `clamp(24px, 6vw, 42px)` | `clamp(30px, 7vw, 52px)`   |
| h3  | `clamp(20px, 5vw, 32px)` | `clamp(26px, 6vw, 40px)`   |
| h4  | `clamp(18px, 4vw, 24px)` | `clamp(24px, 5vw, 32px)`   |
| h5  | `clamp(16px, 3vw, 20px)` | `clamp(22px, 4vw, 28px)`   |
| h6  | `clamp(14px, 3vw, 18px)` | `clamp(20px, 3.5vw, 24px)` |



---

## ✒️ Logo Direction

- **Type**: Wordmark using **Domine Bold**
- **Variants**:
  - Primary: `NSheth` in Rich Brown
  - Inverted: White wordmark on dark background
  - Compact: `NS` monogram for favicon/app
- **Sizes**:
  - Web: 512px+ SVG/PNG
  - Favicon: 32px and 16px

---

## 📁 Brand Folder Structure

```
NSheth-Brand/
├── Fonts/
│   ├── Domine-Regular.ttf
│   └── Manrope-Regular.ttf
├── Logo/
│   ├── Wordmark.svg
│   ├── Wordmark-Dark.svg
│   ├── Wordmark-White.svg
│   └── Favicon/
│       ├── favicon-32.png
│       └── favicon-16.png
├── Colors/
│   └── NSheth-Colors.pdf
├── Styleguide/
│   └── Visual-Identity.md
├── Mockups/
│   ├── Homepage-Hero.png
│   └── BlogPost-Preview\.png

```




## 🔠 Typography Sizes

| Element            | Font            | Desktop (px) | Tablet (px) | Mobile (px) |
| ------------------ | --------------- | ------------ | ----------- | ----------- |
| **H1**             | Domine Bold     | `42px`       | `36px`      | `30px`      |
| **H2**             | Domine Bold     | `32px`       | `28px`      | `24px`      |
| **Body**           | Manrope Regular | `20px`       | `18px`      | `16px`      |
| **Caption / Meta** | Manrope         | `16px`       | `15px`      | `14px`      |

> ✨ **Line Height**:

- `1.2` for headings
- `1.6` for body and paragraphs
- `1.4` for captions and meta

| Tag | Font Size (Clamp in px)  | Line Height (Clamp in px)  |
| --- | ------------------------ | -------------------------- |
| h1  | `clamp(32px, 8vw, 62px)` | `clamp(38px, 9vw, 72px)`   |
| h2  | `clamp(24px, 6vw, 42px)` | `clamp(30px, 7vw, 52px)`   |
| h3  | `clamp(20px, 5vw, 32px)` | `clamp(26px, 6vw, 40px)`   |
| h4  | `clamp(18px, 4vw, 24px)` | `clamp(24px, 5vw, 32px)`   |
| h5  | `clamp(16px, 3vw, 20px)` | `clamp(22px, 4vw, 28px)`   |
| h6  | `clamp(14px, 3vw, 18px)` | `clamp(20px, 3.5vw, 24px)` |
	 


---

## 📐 Spacing System (Padding / Section Gaps)

Use a **modular 4-based scale** to ensure rhythm and consistency. Here’s a practical layout spacing guide:

### 🔲 Global Container Padding

|Viewport|Horizontal Padding|
|---|---|
|Desktop|`40px` (`px-10`)|
|Tablet|`32px` (`px-8`)|
|Mobile|`20px` (`px-5`)|

> Optional max-width: `1280px mx-auto` to center the content.

---

### 📦 Section Padding (Vertical)

|Section Type|Padding Top/Bottom|
|---|---|
|**Hero** (first screen)|`80px` top & bottom|
|**Project Grid / Body**|`64px` top & bottom|
|**Blog List / Archive**|`56px` top & bottom|
|**Footer**|`48px` top, `32px` bottom|
|**Inside Cards / Boxes**|`24px` all sides|

---

## 📏 Margin Rhythm (Between Elements)

|Elements|Vertical Spacing|
|---|---|
|H1 → H2|`24px`|
|H2 → Paragraph|`16px`|
|Paragraph → Paragraph|`12–16px`|
|Section → Section|`64px+`|

---

## ✅ Summary Cheat Sheet

| Token              | Value                                        |
| ------------------ | -------------------------------------------- |
| H1                 | `42px`, `1.2 lh`                             |
| H2                 | `32px`, `1.2 lh`                             |
| Body               | `20px`, `1.6 lh`                             |
| Section Padding    | `80px` hero, `64px` content                  |
| Horizontal Padding | `40px` desktop, `32px` tablet, `20px` mobile |
| Max Width          | `1280px` center-aligned                      |