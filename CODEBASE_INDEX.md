# PropertyHub Complete Codebase Index
**Generated:** April 23, 2026 | **Status:** Comprehensive Inventory

---

## 📊 PROJECT OVERVIEW

**Project Name:** PropertyHub (PropertyHub-PFE)  
**Type:** Real Estate Management Platform  
**Architecture:** Dual Laravel Applications (Backend API + Mobile App)  
**Total Directories:** 50+  
**Total Key Files:** 150+  

---

## 📁 ROOT STRUCTURE

```
PropertyHub-PFE/
├── CODEBASE_STRUCTURE_INVENTORY.md .... Executive summary & architecture overview
├── QUICK_REFERENCE.md ................. One-page quick lookup guide
├── README.md .......................... Project introduction
├── CODEBASE_INDEX.md .................. This file
│
├── .agent/ ............................ AI Agent Configuration (Copilot Skills)
├── 1.analyse-besoin/ .................. Requirements Analysis Phase
├── 2.organisation-contenu/ ............ Content Structuring Phase
├── 3.maquettage/ ...................... Design & Mockups Phase
├── Analysis/ .......................... UX Research & Analysis
├── Class-Diagram/ ..................... Domain Model Documentation
├── Report/ ............................ Project Report & Documentation
├── UseCase/ ........................... Use Case Diagrams
├── Presentation/ ...................... Project Presentation Files
│
├── mobile-app/app/ .................... Mobile Frontend (NativePHP Laravel)
└── PropertyHub-PFE/PropertyHub/ ........ Main Backend API (Laravel REST)
```

---

## 🤖 SECTION 1: AI AGENT CONFIGURATION (.agent/)

### Directory Purpose
Copilot AI agent configuration with domain expertise for PropertyHub project phases.

```
.agent/
├── resources/
│   ├── atomic-design.md ............... Atomic Design System Reference
│   ├── protocoles-workflow.md ......... Project Workflow Protocols
│   └── stack-technique.md ............ Technical Stack Overview
│
├── rules/
│   ├── 00-config-environnement.md .... Environment Configuration Rules
│   ├── 01-identite-persona.md ........ Agent Identity & Persona
│   ├── 02-stack-technique.md ......... Technical Stack Guidelines
│   ├── 03-qualite-securite.md ........ Quality & Security Standards
│   └── 04-optimisation-tokens.md .... Token Optimization Rules
│
├── skills/
│   ├── analyste-besoin/ .............. Requirements Analysis Skill
│   │   ├── SKILL.md .................. Skill Definition
│   │   ├── capacités/
│   │   │   └── capacité-analyse-metier.md ... Business Analysis Capability
│   │   └── templates/
│   │       └── cahier-des-charges-template.md ... Requirements Template
│   │
│   ├── architecte-contenu/ ........... Content Architecture Skill
│   │   ├── SKILL.md .................. Skill Definition
│   │   ├── capacités/
│   │   │   ├── capacité-copywriting.md ........ Copywriting Capability
│   │   │   ├── capacité-seo-semantique.md .... SEO Semantic Capability
│   │   │   ├── capacité-seo-structure.md .... SEO Structure Capability
│   │   │   ├── capacité-ux-zoning.md ........ UX Zoning Capability
│   │   │   └── capacité-wireframing-markdown.md . Wireframing Capability
│   │   └── templates/
│   │       └── content-strategy-template.md ... Content Strategy Template
│   │
│   ├── designer-ui/ .................. UI Designer Skill
│   │   ├── SKILL.md .................. Skill Definition
│   │   ├── capacités/
│   │   │   ├── capacité-analyse-demande.md ......... Requirement Analysis
│   │   │   ├── capacité-composition-page.md ....... Page Composition
│   │   │   ├── capacité-composition-ui.md ......... UI Composition
│   │   │   ├── capacité-css-atomic.md ............ Atomic CSS
│   │   │   ├── capacité-decomposition-atomic.md ... Atomic Decomposition
│   │   │   ├── capacité-design-system.md ......... Design System
│   │   │   ├── capacité-generation-galerie.md .... Gallery Generation
│   │   │   ├── capacité-gestion-manifeste.md .... Manifest Management
│   │   │   ├── capacité-html-semantique.md ...... Semantic HTML
│   │   │   └── capacité-theorie-couleurs.md ..... Color Theory
│   │   └── templates/
│   │       └── galerie-ui.template.html ......... UI Gallery Template
│   │
│   └── developpeur-front/ ............ Frontend Developer Skill
│       ├── SKILL.md .................. Skill Definition
│       └── capacités/
│           └── capacité-clean-code-html.md .... Clean Code HTML
│
└── workflows/
    ├── analyse-besoin.md ............. Requirements Analysis Workflow
    ├── architecture-contenu.md ....... Content Architecture Workflow
    ├── create-page.md ................ Page Creation Workflow
    ├── designe-ui.md ................. UI Design Workflow
    ├── develop.md .................... Backend Development Workflow
    └── develope-front.md ............. Frontend Development Workflow
```

**Key Files:** 30+ configuration files for AI-assisted development

---

## 📋 SECTION 2: REQUIREMENTS ANALYSIS (1.analyse-besoin/)

```
1.analyse-besoin/
└── cahier-des-charges.md ............ Complete Requirements Specification Document
```

**Purpose:** Detailed functional and non-functional requirements for PropertyHub platform.

---

## 🗂️ SECTION 3: CONTENT ORGANIZATION (2.organisation-contenu/)

```
2.organisation-contenu/
├── content-strategy.md ............... Content Strategy & Planning Document
├── sitemap.md ....................... Website Sitemap Structure
│
└── wireframes/
    ├── home.md ...................... Homepage Wireframe Documentation
    └── property-details.md .......... Property Details Page Wireframe
```

**Purpose:** Content architecture and user flow documentation.

---

## 🎨 SECTION 4: DESIGN & MOCKUPS (3.maquettage/)

### 4.1 Main Layout Files
```
3.maquettage/
├── index.html ....................... Design System Index Page
├── comp-home.md ..................... Homepage Components Documentation
├── comp-property-details.md ......... Property Details Components Documentation
```

### 4.2 Design System (charte-graphique/)
```
3.maquettage/charte-graphique/
├── charte.md ........................ Design System Documentation
└── index.html ....................... Design System Website
```

**Purpose:** Complete brand guidelines, color palette, typography, and spacing rules.

### 4.3 Component Library (components-lib/)

#### Atoms (Basic Building Blocks)
```
3.maquettage/components-lib/atoms/
├── atoms-manifest.md ............... Atoms Directory Index
│
├── avatar/ .......................... User Avatar Component
│   └── atom.html
├── badge/ ........................... Badge Component
│   └── atom.html
├── button/ .......................... Button Component
│   └── atom.html
├── input-select/ .................... Select Input Component
│   └── atom.html
├── input-text/ ...................... Text Input Component
│   └── atom.html
├── text/ ............................ Text Component
│   └── atom.html
└── title/ ........................... Title/Heading Component
    └── atom.html
```

#### Molecules (Component Combinations)
```
3.maquettage/components-lib/molecules/
├── molecules-manifest.md ........... Molecules Directory Index
│
├── admin-sidebar/ ................... Admin Sidebar Component
│   └── molecule.html
├── appointment-slot/ ................ Appointment Slot Component
│   └── molecule.html
├── compare-card/ .................... Property Comparison Card
│   └── molecule.html
├── footer/ .......................... Footer Component
│   └── molecule.html
├── form-field/ ...................... Form Field Component
│   └── molecule.html
├── message-bubble/ .................. Message Bubble Component
│   └── molecule.html
├── navbar/ .......................... Navigation Bar Component
│   └── molecule.html
├── property-card/ ................... Property Listing Card
│   └── molecule.html
├── search-bar/ ...................... Search Bar Component
│   └── molecule.html
└── stat-card/ ....................... Statistics Card Component
    └── molecule.html
```

### 4.4 Mockups (Complete Page Designs)
```
3.maquettage/mockups/
├── mockups-manifest.md ............. Mockups Directory Index
│
├── admin-dashboard.html ............ Admin Dashboard Full Page
├── admin-logs.html ................. Admin Logs Page
├── admin-properties.html ........... Admin Properties Management
├── admin-users.html ................ Admin Users Management
│
├── agent-appointments.html ......... Agent Appointments Page
├── agent-create-property.html ...... Agent Property Creation
├── agent-dashboard.html ............ Agent Dashboard
├── agent-properties.html ........... Agent Properties Listing
│
├── home.html ....................... Public Homepage
├── login.html ....................... Login/Authentication Page
├── messages.html ................... Messages/Chat Page
├── properties.html ................. Public Properties Search
├── property-details.html ........... Single Property Details
└── compare.html .................... Property Comparison Page
```

**Total Components:** 20+ UI components with accessibility and responsiveness

---

## 📊 SECTION 5: UX RESEARCH & ANALYSIS (Analysis/)

### Defining the Problem
```
Analysis/
├── Defining_Problem/
│   └── Define.md ................... Problem Definition & Context
```

### Empathy Research
```
Analysis/Empathy/
├── Empathy_Map/
│   ├── Empathy_Map.md .............. Detailed Empathy Map Documentation
│   └── empathymap.png .............. Visual Empathy Map Diagram
│
└── Empathy_Report/
    ├── Buyer_Client_Report.md ....... Buyer User Research
    ├── Interview_Report.md .......... Interview Findings
    └── Real_Estate_Agent_Staff_Report.md ... Agent User Research
```

### Ideation
```
Analysis/Ideation/
└── Ideation.md ..................... Feature & Solution Ideation
```

**Purpose:** Deep user understanding and research documentation from design thinking methodology.

---

## 📐 SECTION 6: CLASS DIAGRAM (Class-Diagram/)

```
Class-Diagram/
└── Class-Diagram.mmd ............... Mermaid Domain Model Diagram
```

**Contents:** Entity relationships and class structure for:
- User (with roles: buyer, agent, admin)
- Property
- Appointment
- Message
- Gallery
- Calendar
- Report

---

## 💬 SECTION 7: PROJECT PRESENTATION (Presentation/)

```
Presentation/
├── Presentation.md .................. Presentation Slides (Markdown)
├── build.ps1 ....................... PowerShell Build Script
│
└── images/
    ├── admindashboard.png ........... Admin Dashboard Screenshot
    ├── Class-Diagram.png ............ Class Diagram Visual
    ├── design-thinking-process.jpg .. Design Thinking Methodology
    ├── empathymap.png ............... Empathy Map Visualization
    ├── globalUseCase.png ............ Overall Use Cases
    ├── globalUseCaseAdminPart.png ... Admin Use Cases
    ├── globalUseCaseBuyerPart.png ... Buyer Use Cases
    ├── globalUseCaseStaffPart.png ... Agent Use Cases
    ├── homepage.png ................. Homepage Screenshot
    ├── mobile.png ................... Mobile App Screenshot
    ├── ofppt.png .................... Organization Logo
    ├── Realestate.jpg ............... Real Estate Imagery
    ├── scrum.jpg .................... Scrum Methodology Image
    ├── solicode.png ................. Partner Logo
    ├── Sprint1-UseCase.png .......... Sprint 1 Use Cases
    └── Sprint2-UseCase.png .......... Sprint 2 Use Cases
```

---

## 📄 SECTION 8: PROJECT REPORT & DOCUMENTATION (Report/)

```
Report/
├── Report.md ....................... Complete Project Report Document
│
└── images/
    ├── admindashboard.png ........... Admin Analysis Screenshots
    ├── Class-Diagram.png ............ Technical Diagrams
    ├── empathymap.png ............... Research Visualizations
    ├── globalUseCase.png ............ Use Case Diagrams
    ├── homepage.png ................. UI Mockup Screenshots
    ├── mobile.png ................... Mobile Interface Screenshots
    ├── Sprint1-UseCase.png .......... Sprint Deliverables
    └── Sprint2-UseCase.png .......... Sprint Deliverables
```

---

## 📊 SECTION 9: USE CASE DIAGRAMS (UseCase/)

```
UseCase/
├── global_UseCase.puml ............. Complete System Use Cases
├── Sprint1_UseCase.puml ............ Sprint 1 Requirements
├── Sprint2_UseCase.puml ............ Sprint 2 Requirements
│
└── DevidedGlobalUseCase/
    ├── global_UseCse_Admin.puml ...... Admin Role Use Cases
    ├── global_UseCse_Agent(Staff).puml Real Estate Agent Use Cases
    └── global_UseCse_Client(Buyer).puml ... Buyer/Client Use Cases
```

**Format:** PlantUML diagrams for system behavior documentation.

---

## 🔌 SECTION 10: BACKEND API (PropertyHub-PFE/PropertyHub/)

### 10.1 Overview
```
PropertyHub/
├── README.md ....................... Backend Setup & Documentation
├── SERVICES.md ..................... Service Layer Documentation
├── SERVICES_SUMMARY.md ............. Quick Service Reference
├── API_MOBILE_SETUP.md ............. Mobile API Integration Guide
│
├── artisan .........................Laravel CLI Tool
├── composer.json ................... PHP Dependencies
├── composer.lock ................... Locked Dependency Versions
├── package.json .................... Node Dependencies
├── package-lock.json ............... Locked Node Versions
├── vite.config.js .................. Frontend Build Configuration
├── phpunit.xml ..................... Testing Configuration
├── .env.example .................... Environment Template
├── .editorconfig ................... Editor Standards
├── .gitattributes .................. Git Attributes
└── .gitignore ...................... Git Ignore Rules
```

### 10.2 Application Structure (app/)

#### HTTP Controllers
```
app/Http/Controllers/
│
├── Controller.php .................. Base Controller Class
├── AuthController.php .............. Global Auth Controller
├── UserController.php .............. Global User Controller
│
├── Api/ ............................ REST API Controllers
│   ├── AuthController.php ........... API Authentication (register, login, logout)
│   ├── PropertyController.php ....... Property CRUD, search, filtering
│   ├── AppointmentController.php .... Appointment booking & management
│   ├── MessageController.php ........ Messaging system
│   └── UserController.php ........... User profiles, agent listings
│
├── Agent/ .......................... Agent-Specific Controllers
│   ├── PropertyController.php ....... Agent property management (create, edit, delete)
│   ├── AppointmentController.php .... Agent appointment viewing
│   └── MessageController.php ........ Agent messaging
│
└── Frontend/ ....................... Frontend Rendering Controllers
    ├── HomeController.php ........... Homepage rendering
    ├── PropertyController.php ....... Property search/browse frontend
    ├── AppointmentController.php .... Appointment booking frontend
    └── Controller.php ............... Base frontend controller
```

#### HTTP Resources (API Response Formatting)
```
app/Http/Resources/
├── PropertyResource.php ............ Property API Response Format
├── UserResource.php ................ User API Response Format
├── AppointmentResource.php ......... Appointment API Response Format
├── MessageResource.php ............. Message API Response Format
└── GalleryResource.php ............. Gallery Images API Response Format
```

#### Models (Data Layer)
```
app/Models/
├── User.php ........................ USER MODEL
│   │ Fields: id, name, email, password, role (buyer|agent|admin)
│   │            license_number (for agents), created_at, updated_at
│   └── Relationships: Properties (1:M), Messages (as sender/receiver), Calendar, Favorites (M:M)
│
├── Property.php .................... PROPERTY MODEL
│   │ Fields: id, agent_id, price, location, status, description
│   │          created_at, updated_at
│   └── Relationships: Agent (M:1), Gallery (1:M), Calendar (via appointments), Favorites (M:M)
│
├── Gallery.php ..................... GALLERY MODEL
│   │ Fields: id, property_id, image_urls (JSON array)
│   │          created_at, updated_at
│   └── Relationships: Property (M:1)
│
├── Calendar.php .................... CALENDAR MODEL
│   │ Fields: id, agent_id, available_days (JSON), created_at, updated_at
│   └── Relationships: Agent (M:1), Appointments (1:M)
│
├── Appointment.php ................. APPOINTMENT MODEL
│   │ Fields: id, buyer_id, agent_id, property_id, calendar_id
│   │          date_time, status (pending|confirmed|cancelled)
│   │          created_at, updated_at
│   └── Relationships: Buyer (M:1), Agent (M:1), Calendar (M:1)
│
├── Message.php ..................... MESSAGE MODEL
│   │ Fields: id, sender_id, receiver_id, content
│   │          timestamp, read, created_at, updated_at
│   └── Relationships: Sender (M:1), Receiver (M:1)
│
└── Report.php ...................... REPORT MODEL
    │ Fields: id, admin_id, data_summary (JSON), created_at, updated_at
    └── Relationships: Admin (M:1)
```

#### Services (Business Logic)
```
app/Services/
├── PropertyService.php ............. Property Business Logic
│   ├── getAll()
│   ├── search(filters)
│   ├── getById(id)
│   ├── create(data)
│   ├── update(id, data)
│   ├── delete(id)
│   ├── getUserFavorites(userId)
│   ├── addFavorite(userId, propertyId)
│   └── removeFavorite(userId, propertyId)
│
├── AppointmentService.php .......... Appointment Business Logic
│   ├── getAll()
│   ├── getById(id)
│   ├── create(booking)
│   ├── update(id, data)
│   ├── cancel(id)
│   ├── getAvailableSlots(calendarId)
│   └── checkConflicts(calendarId, dateTime)
│
├── MessageService.php .............. Messaging Business Logic
│   ├── getConversation(userId1, userId2)
│   ├── send(senderId, receiverId, content)
│   ├── markAsRead(messageId)
│   ├── getUnread(userId)
│   └── delete(messageId)
│
└── UserService.php ................. User Business Logic
    ├── getAll()
    ├── getById(id)
    ├── create(userData)
    ├── update(id, data)
    ├── delete(id)
    ├── getAgents()
    └── getRoleUsers(role)
```

#### Providers
```
app/Providers/
└── AppServiceProvider.php .......... Service Container & Bindings
```

### 10.3 Routes (API Endpoints)

```
routes/
├── api.php ......................... REST API Routes (40+ endpoints)
│   ├── POST   /api/auth/register ................. User Registration
│   ├── POST   /api/auth/login ................... User Login
│   ├── POST   /api/auth/logout .................. User Logout
│   ├── GET    /api/auth/user .................... Current User Profile
│   │
│   ├── GET    /api/properties ................... List All Properties
│   ├── GET    /api/properties/{id} .............. Get Property Details
│   ├── POST   /api/properties ................... Create Property
│   ├── PUT    /api/properties/{id} .............. Update Property
│   ├── DELETE /api/properties/{id} .............. Delete Property
│   ├── GET    /api/properties/search ............ Search Properties
│   ├── GET    /api/properties/agent/{agentId} .. Agent's Properties
│   │
│   ├── POST   /api/properties/{id}/favorite .... Add to Favorites
│   ├── DELETE /api/properties/{id}/favorite .... Remove from Favorites
│   ├── GET    /api/favorites .................... Get Favorite Properties
│   │
│   ├── GET    /api/appointments ................. List Appointments
│   ├── GET    /api/appointments/{id} ............ Get Appointment Details
│   ├── POST   /api/appointments ................. Book Appointment
│   ├── PUT    /api/appointments/{id} ............ Update Appointment
│   ├── DELETE /api/appointments/{id} ............ Cancel Appointment
│   ├── GET    /api/calendars/{agentId} ......... Agent Availability
│   │
│   ├── GET    /api/messages ..................... Get Conversations
│   ├── GET    /api/messages/{userId} ........... Get Messages with User
│   ├── POST   /api/messages ..................... Send Message
│   ├── PUT    /api/messages/{id} ............... Mark Message as Read
│   │
│   ├── GET    /api/users ....................... List Users
│   ├── GET    /api/users/{id} .................. Get User Profile
│   ├── PUT    /api/users/{id} .................. Update User Profile
│   ├── GET    /api/agents ...................... List Agents
│   │
│   ├── GET    /api/dashboard/stats ............ Dashboard Statistics
│   └── GET    /api/reports ..................... Admin Reports
│
├── web.php ......................... Web Routes (for frontend/admin)
│   ├── GET    / ......................... Homepage
│   ├── GET    /admin ..................... Admin Dashboard
│   ├── GET    /agent ..................... Agent Dashboard
│   ├── GET    /properties ................ Property Browse
│   ├── GET    /property/{id} ............. Property Details
│   └── GET    /messages .................. Messaging Interface
│
└── console.php ..................... Artisan Console Commands
```

### 10.4 Database Structure

#### Migrations (Database Schema)
```
database/migrations/
│
├── 0001_01_01_000000_create_users_table.php
│   └── Fields: id, name, email, password, role, license_number
│
├── 0001_01_01_000001_create_cache_table.php
│   └── Laravel cache storage table
│
├── 0001_01_01_000002_create_jobs_table.php
│   └── Laravel queue table
│
├── 2026_03_10_140752_create_properties_table.php
│   └── Fields: id, agent_id, price, location, status, description, created_at, updated_at
│
├── 2026_03_10_140753_create_galleries_table.php
│   └── Fields: id, property_id, image_urls (JSON), created_at, updated_at
│
├── 2026_03_10_140754_create_calendars_table.php
│   └── Fields: id, agent_id, available_days (JSON), created_at, updated_at
│
├── 2026_03_10_140754_create_messages_table.php
│   └── Fields: id, sender_id, receiver_id, content, timestamp, read, created_at
│
├── 2026_03_10_140755_create_appointments_table.php
│   └── Fields: id, buyer_id, agent_id, property_id, calendar_id, date_time, status
│
├── 2026_03_10_140755_create_reports_table.php
│   └── Fields: id, admin_id, data_summary (JSON), created_at, updated_at
│
├── 2026_03_10_140810_create_property_user_table.php
│   └── Pivot table for Property<->User (favorites) M:M relationship
│
└── 2026_04_21_120000_add_fields_to_properties_table.php
    └── Additional property fields migration
```

#### Factories (Test Data Generators)
```
database/factories/
├── PropertyFactory.php ............. Generate test properties
└── UserFactory.php ................ Generate test users
```

#### Seeders (Bulk Data Insertion)
```
database/seeders/
├── DatabaseSeeder.php .............. Main seeder that calls others
└── CsvSeeder.php ................... Import data from CSV files
```

#### Seed Data Files
```
database/data/
├── users.csv ....................... User seed data
├── properties.csv .................. Property seed data
├── galleries.csv ................... Gallery seed data
└── calendars.csv ................... Calendar seed data
```

### 10.5 Configuration Files

```
config/
├── app.php ......................... Application Configuration
├── auth.php ........................ Authentication & Sanctum Setup
├── cache.php ....................... Caching Configuration
├── database.php .................... SQLite Database Configuration
├── filesystems.php ................. File Storage Configuration
├── logging.php ..................... Logging Configuration
├── mail.php ........................ Mail Service Configuration
├── queue.php ....................... Queue/Job Configuration
├── services.php .................... Third-party Services
└── session.php ..................... Session Configuration
```

### 10.6 Frontend Resources (Blade Templates)

#### Layouts
```
resources/views/layouts/
├── app.blade.php ................... Default Application Layout
├── admin.blade.php ................. Admin Dashboard Layout
├── agent.blade.php ................. Agent Dashboard Layout
├── agent-header.blade.php .......... Agent Header Component
└── frontend.blade.php .............. Public Site Layout
```

#### Public Frontend Views
```
resources/views/frontend/
├── home.blade.php .................. Homepage
├── properties.blade.php ............ Property Browsing
├── property-details.blade.php ...... Single Property Details
├── compare.blade.php ............... Property Comparison
│
└── partials/
    └── footer.blade.php ............ Footer Component
```

#### Authentication Views
```
resources/views/auth/
├── login.blade.php ................. Login Form
└── register.blade.php .............. Registration Form
```

#### Admin Views
```
resources/views/admin/
├── dashboard.blade.php ............. Admin Dashboard
│
└── users/
    └── create.blade.php ............ Create User Form
```

#### Agent Views
```
resources/views/agent/
├── dashboard.blade.php ............. Agent Dashboard
│
├── appointments/
│   └── index.blade.php ............. View Appointments
│
├── properties/
│   ├── index.blade.php ............. List Agent Properties
│   └── create.blade.php ............ Create Property Form
│
└── messages/
    ├── index.blade.php ............. Message List
    └── show.blade.php .............. Conversation View
```

### 10.7 Assets & Public Files

```
public/
├── index.php ....................... Application Entry Point
├── .htaccess ....................... Apache Rewrite Rules
├── favicon.ico ..................... Favicon
└── robots.txt ...................... Search Engine Crawlers

resources/
├── css/
│   └── app.css ..................... Main Stylesheet
│
└── js/
    ├── app.js ...................... Main JavaScript
    └── bootstrap.js ................ Framework Bootstrap
```

### 10.8 Storage & Logs

```
storage/
├── app/ ............................ File uploads
│   ├── private/ .................... Private files
│   └── public/ ..................... Public files
│
├── framework/ ....................... Framework files
│   ├── cache/ ....................... Cache files
│   ├── sessions/ .................... Session data
│   ├── testing/ ..................... Test files
│   └── views/ ....................... Compiled views
│
├── debugbar/ ....................... Debug toolbar data
│
└── logs/ ........................... Application logs
    └── .gitignore
```

### 10.9 Tests

```
tests/
├── Feature/ ........................ Integration Tests
│   └── ExampleTest.php ............. Example Test
│
└── Unit/ ........................... Unit Tests
    ├── ExampleTest.php ............. Example Test
    │
    └── Services/ ................... Service Layer Tests
        ├── PropertyServiceTest.php . Property Service Tests
        ├── AppointmentServiceTest.php Appointment Service Tests
        ├── MessageServiceTest.php .. Message Service Tests
        └── UserServiceTest.php ..... User Service Tests
```

### 10.10 Bootstrap & Core

```
bootstrap/
├── app.php ......................... Application Bootstrap
├── providers.php ................... Service Provider Setup
│
└── cache/ .......................... Cache Storage
    └── .gitignore
```

---

## 📱 SECTION 11: MOBILE APP FRONTEND (mobile-app/app/)

### 11.1 Overview & Configuration

```
mobile-app/app/
├── README.md ....................... Mobile App Setup & Documentation
├── artisan ......................... Laravel CLI for mobile app
├── composer.json ................... PHP Dependencies
├── composer.lock ................... Locked Versions
├── package.json .................... JavaScript/Node Dependencies
├── package-lock.json ............... Node Locked Versions
│
├── nativephp.json .................. NativePHP Configuration (Desktop App)
├── convert_icon.php ................ Icon Processing Script
├── native .......................... NativePHP Application Wrapper
│
├── phpunit.xml ..................... Testing Configuration
├── vite.config.js .................. Frontend Build Tool Config
├── tailwind.config.js .............. Tailwind CSS Configuration
│
├── .env.example .................... Environment Template
├── .editorconfig ................... Editor Configuration
├── .gitattributes .................. Git Attributes
└── .gitignore ...................... Git Ignore Rules
```

**Type:** NativePHP Laravel Application (Desktop/Mobile web wrapper)  
**Purpose:** Insulated frontend consuming the main PropertyHub API

### 11.2 Application Structure (app/)

#### HTTP Controllers
```
app/Http/Controllers/
├── Controller.php .................. Base Controller
├── AuthController.php .............. Authentication (Login/Register)
├── PropertyController.php .......... Property Browsing & Search
├── AppointmentController.php ....... Appointment Management
├── BookController.php .............. Booking Functions
└── ApiController.php ............... API Direct Access
```

#### Models
```
app/Models/
└── User.php ........................ Local User Model (Session/Cache)
```

#### Services
```
app/Services/
├── PropertyHubApiService.php ....... Main API Bridge Service
│   ├── initialize() ............... Setup API connection
│   ├── authenticate(credentials) .. API Authentication
│   ├── getProperties(...) ......... Fetch properties from API
│   ├── getProperty(id) ............ Single property details
│   ├── searchProperties(filters) .. Search with filters
│   ├── bookAppointment(...) ....... Create appointment
│   ├── sendMessage(...) ........... Send message
│   └── getFavorites() ............. Get saved properties
│
└── ApiService.php .................. Low-level HTTP Service
    ├── request(method, endpoint, data) ... Generic API calls
    ├── setToken(token) ............. Authentication token
    └── handleResponse(response) .... Response processing
```

#### Service Provider
```
app/Providers/
└── AppServiceProvider.php .......... Service Container Setup
```

### 11.3 Database (Local SQLite)

```
database/
├── .gitignore ...................... Ignore local database files
│
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php ... Users table for session
│   ├── 0001_01_01_000001_create_cache_table.php .. Cache table
│   └── 0001_01_01_000002_create_jobs_table.php ... Job queue table
│
├── factories/
│   └── UserFactory.php ............. User Factory for testing
│
├── seeders/
│   └── DatabaseSeeder.php ......... Database Seeding
│
└── (no data imports - all from API)
```

### 11.4 Routes

```
routes/
├── web.php ......................... Web Routes (Mobile Frontend)
│   ├── GET    / .................... Welcome/Homepage
│   ├── GET    /properties .......... Properties Listing
│   ├── GET    /properties/{id} .... Property Details
│   ├── GET    /properties/by-agent/{agentId} Agents properties
│   ├── GET    /favorites .......... Favorite Properties
│   │
│   ├── GET    /appointments ....... Appointments List
│   ├── GET    /appointments/book .. Book Appointment Form
│   ├── POST   /appointments/book .. Create Appointment
│   │
│   ├── GET    /auth/login ......... Login Page
│   ├── POST   /auth/login ......... Process Login
│   ├── GET    /auth/register ...... Register Page
│   ├── POST   /auth/register ...... Process Registration
│   └── POST   /auth/logout ........ Logout
│
└── console.php ..................... CLI Commands
```

### 11.5 Frontend Views (Blade Templates)

#### Layouts
```
resources/views/layouts/
└── app.blade.php ................... Main Layout Template
```

#### Authentication
```
resources/views/auth/
├── login.blade.php ................. Mobile Login
└── register.blade.php .............. Mobile Registration
```

#### Properties Views
```
resources/views/properties/
├── index.blade.php ................. Properties List/Search
├── show.blade.php .................. Property Details View
├── favorites.blade.php ............. Favorite Properties List
└── by-agent.blade.php .............. Properties by Specific Agent
```

#### Appointments Views
```
resources/views/appointments/
├── index.blade.php ................. Appointments List
└── book.blade.php .................. Appointment Booking Form
```

#### Root Views
```
resources/views/
├── welcome.blade.php ............... Landing/Welcome Page
└── books.blade.php ................. Book-related Content
```

### 11.6 Assets & Build

#### Stylesheets
```
resources/css/
└── app.css ......................... Main CSS / Tailwind Imports
```

#### JavaScript
```
resources/js/
├── app.js .......................... Main Application JS
└── bootstrap.js .................... Framework Bootstrap
```

### 11.7 Configuration

```
config/
├── app.php ......................... Application Configuration
├── auth.php ........................ Authentication Configuration
├── cache.php ....................... Cache Configuration
├── database.php .................... SQLite Database Config
├── filesystems.php ................. File Storage Config
├── logging.php ..................... Logging Configuration
├── mail.php ........................ Mail Configuration
├── nativephp.php ................... NativePHP-specific Config
├── queue.php ....................... Queue Configuration
├── services.php .................... Services Config
└── session.php ..................... Session Configuration
```

### 11.8 Storage & Bootstrap

```
storage/
├── app/ ............................ App-level storage
│   ├── private/ .................... Private files
│   └── public/ ..................... Public files
│
├── framework/ ....................... Framework storage
│   ├── sessions/ .................... Session data
│   ├── cache/ ....................... Cache
│   ├── testing/ ..................... Test files
│   └── views/ ....................... Compiled views
│
└── logs/ ........................... Application logs

bootstrap/
├── app.php ......................... App initialization
├── providers.php ................... Provider setup
│
└── cache/ .......................... Bootstrap cache
```

### 11.9 Testing

```
tests/
├── Feature/ ........................ Integration Tests
│   └── ExampleTest.php ............. Example test
│
└── Unit/ ........................... Unit Tests
    └── ExampleTest.php ............. Example test
```

---

## 🔑 KEY STATISTICS

**Total Directories:** 50+  
**Total Key Files:** 150+  

### By Type:
- **Database Models:** 7 core entities
- **API Controllers:** 5 main + role-specific variants
- **Service Classes:** 4 business logic layers
- **HTTP Resources:** 5 API response formatters
- **Blade Templates:** 25+ views
- **UI Components:** 20+ (atoms & molecules)
- **Database Migrations:** 11 schema files
- **Configuration Files:** 10+ per application
- **Test Files:** 4 unit test classes

---

## 🔗 RELATIONSHIPS & DEPENDENCIES

### Backend ← → Mobile Frontend
- Mobile app consumes the **REST API** from PropertyHub backend
- Uses **PropertyHubApiService** for all API calls
- Bearer token authentication via Sanctum

### Key Data Flows:
1. **Authentication:** Login → API token → Bearer header on all requests
2. **Properties:** Mobile searches/filters → API search endpoint → Results
3. **Bookings:** Mobile submission → API appointment creation → Confirmation
4. **Messaging:** Mobile message → API storage → Push notification
5. **Favorites:** Mobile add to favorites → API pivot table → Sync across devices

---

## 📚 DOCUMENTATION CROSS-REFERENCES

| Document | Location | Purpose |
|----------|----------|---------|
| Quick Reference | QUICK_REFERENCE.md | One-page lookup |
| Architecture | CODEBASE_STRUCTURE_INVENTORY.md | Executive summary |
| API Setup | PropertyHub-PFE/PropertyHub/API_MOBILE_SETUP.md | Integration guide |
| Services | PropertyHub-PFE/PropertyHub/SERVICES.md | Service layer details |
| Requirements | 1.analyse-besoin/cahier-des-charges.md | Functional specs |
| Content Strategy | 2.organisation-contenu/content-strategy.md | UX/Content plan |
| Design System | 3.maquettage/charte-graphique/charte.md | Visual guidelines |
| Use Cases | UseCase/*.puml | User workflows |

---

## 🚀 QUICK NAVIGATION GUIDE

**Find a file quickly:**
- **Backend controllers?** → `PropertyHub-PFE/PropertyHub/app/Http/Controllers/`
- **Mobile views?** → `mobile-app/app/resources/views/`
- **Database schema?** → `PropertyHub-PFE/PropertyHub/database/migrations/`
- **API endpoints?** → `PropertyHub-PFE/PropertyHub/routes/api.php`
- **UI components?** → `3.maquettage/components-lib/`
- **Design guidelines?** → `3.maquettage/charte-graphique/`
- **Requirements?** → `1.analyse-besoin/cahier-des-charges.md`
- **Research docs?** → `Analysis/`

---

**Last Updated:** April 23, 2026  
**Index Completeness:** 100% of tracked files
