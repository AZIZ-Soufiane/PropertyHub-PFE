# Composition - Home Page

## Source
- **Wireframe**: `2.organisation-contenu/wireframes/home.md`
- **Mockup Final**: `3.maquettage/mockups/home.html`

## Structure de Composition

```
Header
└── navbar (Molecule) → components-lib/molecules/navbar/
    ├── logo (Atom) → components-lib/atoms/logo/
    ├── 4x nav-link (Atom) → components-lib/atoms/nav-link/
    └── button (Atom: Login) → components-lib/atoms/button/

Main
├── hero-search (Molecule) → components-lib/molecules/hero-search/
│   ├── title (Atom: h1) → components-lib/atoms/title/
│   ├── text (Atom: lead) → components-lib/atoms/text/
│   └── search-bar (Molecule) → components-lib/molecules/search-bar/
│       ├── input (Atom: text) → components-lib/atoms/input/
│       ├── select (Atom: dropdown) → components-lib/atoms/select/
│       └── button (Atom: primary) → components-lib/atoms/button/
│
├── featured-section (Molecule) → components-lib/molecules/featured-section/
│   ├── title (Atom: h2) → components-lib/atoms/title/
│   └── 3x property-card (Molecule) → components-lib/molecules/property-card/
│       ├── image (Atom) → components-lib/atoms/image/
│       ├── title (Atom: h3) → components-lib/atoms/title/
│       ├── text (Atom: price/details) → components-lib/atoms/text/
│       └── badge (Atom) → components-lib/atoms/badge/
│
└── value-prop (Molecule) → components-lib/molecules/value-prop/
    ├── title (Atom: h2) → components-lib/atoms/title/
    └── 3x feature-icon-block (Molecule) → components-lib/molecules/feature-icon-block/
        ├── icon (Atom) → components-lib/atoms/icon/
        ├── title (Atom: h3) → components-lib/atoms/title/
        └── text (Atom) → components-lib/atoms/text/

Footer
└── footer (Molecule) → components-lib/molecules/footer/
    ├── text (Atom: copyright) → components-lib/atoms/text/
    ├── social-links (Molecule) → components-lib/molecules/social-links/
    └── nav-link (Atom) → components-lib/atoms/nav-link/
```

## Composants Nécessaires

### Atoms (in components-lib/atoms/)
- [ ] `logo/` - Site logo (SVG)
- [ ] `nav-link/` - Navigation links with hover/active states
- [ ] `title/` - Headers (h1, h2, h3)
- [ ] `text/` - Paragraphs and UI text (lead, normal, small)
- [ ] `button/` - Action buttons (Primary, Secondary, Ghost)
- [ ] `input/` - Form text inputs
- [ ] `select/` - Dropdown selection menus
- [ ] `image/` - Responsive property images
- [ ] `badge/` - Status markers (For Sale, Pending, etc.)
- [ ] `icon/` - UI Icons (Lucide or similar set)

### Molécules (in components-lib/molecules/)
- [ ] `navbar/` - Main header navigation
  - **Atoms used**: logo, nav-link, button
- [ ] `hero-search/` - Hero section with search overlay
  - **Atoms used**: title (h1), text (lead)
  - **Molecules used**: search-bar
- [ ] `search-bar/` - Combined search input unit
  - **Atoms used**: input, select, button
- [ ] `property-card/` - Card for listing display
  - **Atoms used**: image, title (h3), text, badge
- [ ] `value-prop/` - Section highlighting benefits
  - **Atoms used**: title (h2)
  - **Molecules used**: feature-icon-block
- [ ] `footer/` - Site footer
  - **Atoms used**: text, nav-link
  - **Molecules used**: social-links

## Statut
- [ ] Style Guide validated
- [ ] All atoms created
- [ ] All molecules created
- [ ] Mockup assembled
