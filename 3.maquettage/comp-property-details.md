# Composition - Property Details Page

## Source
- **Wireframe**: `2.organisation-contenu/wireframes/property-details.md`
- **Mockup Final**: `3.maquettage/mockups/property-details.html`

## Structure de Composition

```
Header
└── navbar (Molecule) → components-lib/molecules/navbar/ (REUSED)

Main
├── photo-gallery (Molecule) → components-lib/molecules/photo-gallery/
│   ├── image (Atom: HD) → components-lib/atoms/image/
│   └── button (Atom: icon-button/heart) → components-lib/atoms/button/
│
├── property-main-info (Molecule) → components-lib/molecules/property-main-info/
│   ├── title (Atom: h1) → components-lib/atoms/title/
│   ├── badge (Atom: price) → components-lib/atoms/badge/
│   ├── text (Atom: tags/desc) → components-lib/atoms/text/
│   └── booking-widget (Molecule) → components-lib/molecules/booking-widget/
│       ├── input (Atom: date-picker) → components-lib/atoms/input/
│       ├── select (Atom: time-slot) → components-lib/atoms/select/
│       └── button (Atom: primary) → components-lib/atoms/button/
│
├── property-amenities (Molecule) → components-lib/molecules/property-amenities/
│   ├── title (Atom: h2) → components-lib/atoms/title/
│   ├── icon-text-pair (Molecule) → components-lib/molecules/icon-text-pair/
│   │   ├── icon (Atom) → components-lib/atoms/icon/
│   │   └── text (Atom) → components-lib/atoms/text/
│   └── map-view (Atom: map-placeholder) → components-lib/atoms/image/
│
└── agent-contact-section (Molecule) → components-lib/molecules/agent-contact-section/
    ├── title (Atom: h2) → components-lib/atoms/title/
    └── agent-card (Molecule) → components-lib/molecules/agent-card/
        ├── image (Atom: profile) → components-lib/atoms/image/
        ├── title (Atom: h3/name) → components-lib/atoms/title/
        ├── text (Atom) → components-lib/atoms/text/
        └── message-form (Molecule) → components-lib/molecules/message-form/
            ├── input (Atom: textarea) → components-lib/atoms/input/
            └── button (Atom: primary) → components-lib/atoms/button/

Footer
└── footer (Molecule) → components-lib/molecules/footer/ (REUSED)
```

## Composants Nécessaires

### Atoms (in components-lib/atoms/)
- [ ] `image/` (REUSED)
- [ ] `button/` (REUSED)
- [ ] `title/` (REUSED)
- [ ] `text/` (REUSED)
- [ ] `badge/` (REUSED)
- [ ] `input/` (REUSED - need Datepicker/Textarea variants)
- [ ] `select/` (REUSED)
- [ ] `icon/` (REUSED)

### Molécules (in components-lib/molecules/)
- [ ] `navbar/` (REUSED)
- [ ] `footer/` (REUSED)
- [ ] `photo-gallery/` - High-res image display system
- [ ] `booking-widget/` - Appointment scheduling UI
- [ ] `property-main-info/` - Container for title, price, and booking
- [ ] `property-amenities/` - Features and Map section
- [ ] `icon-text-pair/` - Small feature blocks (Icon + Text)
- [ ] `agent-card/` - Profile display for the agent
- [ ] `message-form/` - Chat/Contact form unit
- [ ] `agent-contact-section/` - Section wrapper for the agent block

## Statut
- [ ] Style Guide validated
- [ ] All atoms created
- [ ] All molecules created
- [ ] Mockup assembled
