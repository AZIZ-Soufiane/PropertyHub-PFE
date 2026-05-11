# Final Year Project Report

**Subject :** Design and Implementation of an Integrated Real Estate Management Platform  
**Program :** Mobile Development Training – Bootcamp Mode

**Presented by :** AZIZ Soufiane  
**Advisor :** Mr. Essarraj Fouad  
**Academic Year :** 2025/2026

---

## Table of Contents

1. [General Introduction](#1-general-introduction)
2. [Project Context](#2-project-context)
    * 2.1 [Operational Challenges](#21-operational-challenges)
    * 2.2 [Solution Objectives](#22-solution-objectives)
3. [Problem Definition](#3-problem-definition)
4. [Empathy Analysis (PropertyHub System)](#4-empathy-analysis-propertyhub-system)
    * 4.1 [Profile: Ryan – Agency Owner](#41-profile--ryan--agency-owner)
    * 4.2 [Profile: Sarah – Buyer / Client](#42-profile--sarah--buyer--client)
    * 4.3 [Profile: Michael – Real Estate Agent](#43-profile--michael--real-estate-agent)
    * 4.4 [Vision Summary (Scalability)](#44-vision-summary-scalability)
5. [Ideation — System Design](#5-ideation--system-design)
    * 5.1 [The Integrated PropertyHub Platform](#51-the-integrated-propertyhub-platform)
    * 5.2 [User-Centered Workflow](#52-user-centered-workflow)
6. [Use Case Architecture (UML)](#6-use-case-architecture-uml)
    * 6.1 [System Actors](#61-system-actors)
    * 6.2 [Use Case Details](#62-use-case-details)
7. [Agile Planning: Sprints and Use Cases](#7-agile-planning-sprints-and-use-cases)
    * 7.1 [Development Strategy](#71-development-strategy)
    * 7.2 [Sprint 1: Foundations and Property Management](#72-sprint-1-foundations-and-property-management)
    * 7.3 [Sprint 2: Search, Scheduling and Communication](#73-sprint-2-search-scheduling-and-communication)
8. [Functional Mockups (UI/UX)](#8-functional-mockups-uiux)
9. [Architecture Design: Class Diagram](#9-architecture-design-class-diagram)

---

## 1. General Introduction

In the context of current **digital transformation** and the evolution of the real estate sector, real estate agencies are required to offer quality services while ensuring efficient management of their operations.

**Ryan**, owner of a small real estate agency in Austin, Texas, currently manages his property portfolio in a fragmented manner through disparate tools (spreadsheets, emails, phone calls). Despite his business expertise, he faces major difficulties:

* **Dispersed Management:** Data scattered across Excel, emails and handwritten notes, creating critical fragmentation.
* **Loss of Opportunities:** Missed availability updates, double-booked appointments, lost sales.
* **Administrative Burden:** 40% of daily time spent on repetitive administrative tasks.
* **Lack of Scalability:** Inability to grow without significantly increasing the team.

> [!CAUTION]
> **Core Problem:** Since the majority of these tasks are performed manually, this leads to loss of time, loss of business opportunities, decreased customer satisfaction, and inability to scale.

This report aims to analyze Ryan's current situation and his agency, identify the main constraints encountered by the three key actors in the system (Ryan, his real estate agents, and his buyer clients), and propose an appropriate digital solution aimed at improving organization, productivity, customer satisfaction, and overall business performance.

---

## 2. Project Context

The PropertyHub project is part of a commitment to **digital modernization** of a small real estate agency's operations. Ryan currently has to juggle multiple critical responsibilities that hinder his business development.

### 2.1 Operational Challenges

Current manual management relies on three time-consuming pillars:

1. **Property Management:** Manual creation and updating of listings, photo organization, status tracking (For Sale/Rental/Sold).
2. **Appointment Management:** Phone coordination of viewings, risk of double-booking, lack of automatic confirmations.
3. **Fragmented Communication:** Use of multiple channels (phone, WhatsApp, email) without centralization or history.
4. **Client Follow-up:** Loss of client preferences, no history, lack of intelligent recommendations.
5. **No Analytics:** No visibility on which properties attract clients, decisions based on intuition.

### 2.2 Solution Objectives

To address these critical gaps, the PropertyHub solution must imperatively enable:

* **Better organization** of inventory and daily operations.
* **Optimization** of repetitive processes through automation (calendars, notifications, filters).
* **Better communication** between the agency and clients via a centralized platform.
* **Clear and effective monitoring** of sales and appointment progress.
* **Improvement** of commercial performance and professional brand image.
* **Scalability** enabling growth without proportional increase in resources.

---

## 3. Problem Definition

Despite advanced expertise in real estate and good knowledge of the local market, **Ryan and his team** face structural barriers that hinder business growth. The diagnosis reveals the following critical points:

**For Ryan (Owner):**
* **Tool Dispersion:** Fragmented use of spreadsheets (Excel), emails, phone calls and handwritten notes, preventing 360° business visibility
* **Manual Processes:** Manual update of listings, appointment follow-up, client communication → consumes 40% of time
* **Operational Risks:** Oversights (properties already sold still listed as active), double-booking, missed communication
* **Image Deficit:** "Artisanal" management that doesn't reflect the professional positioning expected in the modern market
* **No Business Intelligence:** No analytics, decisions based on intuition, no data to optimize strategy

**For Michael and Agents:**
* **Obsolete Info:** Mismatch between what Ryan has and what Michael knows = gives wrong info to client
* **Scheduling Chaos:** Complex phone coordination, high risk of double-booking
* **Lack of Resources:** Photo collections, descriptions not always accessible quickly
* **Admin Burden:** Too much time on reports, manual tracking instead of customer service

**For Sarah and Clients:**
* **Information Fragmentation:** Need to search across multiple platforms
* **Usability Frustration:** Missing photos, low-quality content
* **Time Barrier:** Impossible to schedule appointments online
* **Lack of Decision Tools:** No easy comparison, no favorites/alerts
* **Difficult Communication:** Must rely on phone calls

**Root Causes of Problems:**
1. Absence of centralized system (single source of truth)
2. Entirely manual processes without automation
3. Lack of tool and actor integration
4. Absence of real-time visibility and synchronization
5. Poor user experience (for both buyers and agents)

---

## 4. Empathy Analysis (PropertyHub System)

**Date:** February 26-28, 2026  
**Objective:** Identify critical user needs to transform artisanal management into a **Professional "Scalable" Platform**.

---

### 4.1 Profile: Ryan – Agency Owner

*The entrepreneur wanting to transition from manual management to a professional and scalable system.*

**Context:**
* Owner of a small real estate agency in Austin, Texas
* Employs 1-2 real estate agents
* Currently manages 20-30 properties in portfolio
* 40% of time spent on administrative tasks

**Vision:** Digitalize management to optimize time, delegate seamlessly, and professionalize agency image.

**Pain Points:**
* **Data Fragmentation:** Information scattered across Excel, emails, phone calls = information loss = lost sales
* **Critical Oversights:** Property forgotten as sold, clients asking about already-sold properties = loss of credibility
* **Double-Booking:** Two viewings scheduled simultaneously for same property = chaos and lost clients
* **Bottleneck:** Unable to delegate without shared tool = total dependence for every decision
* **No Visibility:** No analytics on which properties attract clients, no business intelligence

**Expected Gains:**
* **Management Cockpit:** Single interface to run entire agency (properties, appointments, team, analytics)
* **Automation:** Appointment management without phone calls
* **Delegation:** Autonomous agents managing properties without direct supervision
* **Business Intelligence:** Statistics on popular properties, market trends, agent performance
* **Scalable Growth:** Ability to add agents/properties without explosion of admin burden

---

### 4.2 Profile: Sarah – Buyer / Client

*The end user seeking a fluid experience to find and buy her first property.*

**Context:**
* 32 years old, software engineer (tech-savvy)
* First real estate acquisition
* Actively searching for 6 months
* Spends significant time searching (2-3 hours/day)

**Vision:** A centralized platform consolidating listings from multiple sites with intuitive and complete experience.

**Pain Points:**
* **Information Fragmentation:** Must search across 5-6 different websites, different prices for same property
* **Contradictory Metadata:** Missing or incorrect information on one platform vs. another
* **Poor Quality Photos:** Listings with only 3 photos = wasted time visiting in person = disappointment
* **Impossible to Compare:** No side-by-side tool = manual Excel spreadsheet creation
* **Scheduling Impossible:** Must call during business hours to schedule viewings
* **Lack of Trust:** Outdated listings, already-sold properties still active = loss of trust

**Expected Gains:**
* **Powerful Search:** Advanced filters (price, location, bedrooms, amenities, commute time)
* **Rich Content:** Minimum 15 high-resolution photos, videos, 3D tours, floor plans
* **Intuitive Comparison:** Side-by-side tool to compare 3-5 properties with all details
* **Online Scheduling:** Booking viewings without phone call, automatic confirmations
* **Direct Messaging:** Contact agent without phone, complete history
* **Smart Alerts:** Notifications when new properties match criteria
* **Verified Listings:** Assurance properties are current (last update timestamp)

---

### 4.3 Profile: Michael – Real Estate Agent

*The key actor enabling business growth by managing operations and client relationships.*

**Context:**
* 28 years old, 3 years real estate experience
* Texas Real Estate License
* 25-35 client interactions/day (calls, SMS, emails)
* 30-45 minutes/day on administrative tasks
* Direct support to Ryan in daily management

**Role:** Intermediary between Ryan and clients. Manages viewings, answers questions, tracks progress.

**Pain Points:**
* **Information Silos:** Uncertain property update dates = give outdated info to client = loss of credibility
* **Scheduling Overflow:** Complex phone coordination = scheduling conflicts = lost sales
* **Inaccessible Images:** Photos stored on Ryan's computer = must call/wait to access
* **Manual Tasks:** 30-45 min/day creating summaries for Ryan, data cleanup
* **No Client Follow-up:** Loses client preferences, must re-ask = seems unprofessional
* **No Performance Visibility:** Can't track own metrics, feedback, or progression

**Expected Gains:**
* **Centralized Data Access:** All properties, info and photos instantly accessible
* **Shared Calendar without Conflicts:** See availability, zero double-booking possible
* **Complete Client History:** Track preferences, budgets, past viewings
* **Less Admin:** Systems auto-generate reports, consolidated info without manual work
* **Operational Autonomy:** Can manage clients/properties without constantly asking Ryan
* **Mobile Work:** Access info from field (car, property) without office dependence
* **Performance Tracking:** See own metrics (sales, client satisfaction, conversion rate)

---

### 4.4 Vision Summary (Scalability Model)

The PropertyHub system should not be a simple database or listing site, but a **multi-actor collaborative ecosystem**. The key to scalability rests on three pillars:

1. **Delegation:** Ryan → Michael and other agents can operate autonomously
2. **Premium Client Experience:** Sarah and other buyers have fluid and complete experience
3. **Business Intelligence:** Data-driven decisions (not intuition), growth informed by metrics

**Long-Term Vision:** PropertyHub must transform a small artisanal agency (dependent on one person) into a scalable professional brand capable of serving multiple agents and hundreds of clients simultaneously.

---

## Empathy Map (PropertyHub)

![Empathy Map PropertyHub](Images/empathymap.png)

---

## 5. Ideation — System Design

### 5.1 The Integrated PropertyHub System

The core logic is: **"One single source of truth for all actors."** It's no longer isolated documents, but an ecosystem where every property, appointment, and client interaction is centralized in a **Unified System**.

> **Business Benefit:** Complete data security and efficiency allowing focus on **95% strategy and client development**.

**Response to three personas:**

**For Ryan:**
* Centralized dashboard with complete vision: properties, appointments, team performance, analytics
* Recovery of 30% of time thanks to process automation
* Business intelligence: which properties sell fast, which agents perform

**For Michael:**
* Immediate access to all info (properties, clients, calendar)
* Operational autonomy: can manage clients and properties without constant supervision
* Unified communication: all client exchanges in one place
* Mobile work: can serve clients from field

**For Sarah:**
* Single platform consolidating everything (no need for 6 sites)
* Powerful search and comparison
* Online scheduling without calls
* Direct messaging with agent
* Verified and current listings

### 5.2 User-Centered Workflow

The PropertyHub system operates through four main workflows that interconnect all actors:

1. **Property Management (Admin):** Ryan or Michael creates listings with images and details, published instantly.
2. **Search and Discovery (Client):** Sarah searches in under 2 seconds, compares properties and sees all details.
3. **Appointment Scheduling (Automated):** Online booking without calls, automatic confirmations, zero conflicts possible.
4. **Agent ↔ Client Communication (Centralized):** Historized messages without WhatsApp/email dispersion.

---

## 6. Architecture des Cas d'Utilisation (UML)

Le système repose sur une interaction dynamique entre trois acteurs majeurs, structurés par une hiérarchie de permissions stricte.

### 6.1 Les Acteurs et leurs Rôles

* **Ryan (Admin/Propriétaire) :** Administrateur principal. Contrôle total sur les properties, l'équipe (agents) et le business (analytics, finances).
* **Michael & Agents :** Managers opérationnels. Gèrent les clients, les propriétés assignées, création de visites, communication.
* **Sarah & Clients (Acheteurs) :** Utilisateurs finaux. Consomment les annonces, searchent, comparent propriétés, réservent visites, messagent agents.

### 6.2 Détail des Cas d'Utilisation

#### A. Équipe d'Encadrement (Héritage : Ryan & Michael/Agents)

Les fonctionnalités partagées pour la gestion quotidienne :

* **UC1: Authenticate** → Secure interface access (role-based)
* **UC2: Manage Properties** → Complete CRUD (create, read, update, delete)
* **UC3: Upload Images** → Multi-image support, galleries, high resolution
* **UC4: Categorize Properties** → Classification (Apartment, House, Villa, Land)
* **UC5: Assign Status** → For Sale, For Rent, Sold, Pending
* **UC6: View Client List** → Filterable overview of all clients/leads
* **UC7: Schedule Appointments** → Creation, confirmation, viewing management
* **UC8: View Calendar** → Shared view of available and booked slots
* **UC9: Validate Follow-up** → Viewings history, notes, client feedback
* **UC10: Communication** → In-app messaging, history, notifications

#### B. Exclusive Privileges for Ryan (Admin)

* **UC11: Manage Team** → Agent account administration (add, edit, remove, permissions)
* **UC12: Financial Management** → Leads tracking, conversions, revenue
* **UC13: Strategic Dashboard** → Global analytics (popular properties, agent performance, market trends)
* **UC14: Generate Reports** → Data export, statistics, business intelligence

#### C. For Clients (Sarah - Buyer)

* **UC15: Authenticate** → Secure personal space access
* **UC16: Search Properties** → Search and advanced filters (price, location, type, etc.)
* **UC17: View Details** → Photo gallery, description, amenities, map, agent contact
* **UC18: Add Favorites** → Create wishlist of interesting properties
* **UC19: Compare Properties** → Side-by-side tool to compare 3-6 properties
* **UC20: Schedule Viewing** → Online appointment booking (calendar picker)
* **UC21: Receive Alerts** → Notifications when new properties match criteria
* **UC22: Messaging** → In-app contact with agent for questions
* **UC23: Export** → Download comparison as PDF

---

## 6.3 Global Use Cases

![Use Cases PropertyHub](Images/globalUseCase.png)

---

## 7. Agile Planning: Sprints and Use Cases

### 7.1 Development Strategy

The objective is to structure development around business value:
1. **MVP (Minimum Viable Product):** Foundations and property management implementation.
2. **Phase 2:** Addition of search intelligence, scheduling and communication.
3. **Phase 3:** Advanced analytics, third-party integrations and optimizations.

---

The project is developed using an **iterative and incremental approach** based on 2-week Sprints. Each iteration aims to deliver a set of testable and validatable features, ensuring smooth system evolution.

### 7.2 Sprint 1: Foundations and Property Management

**Objective:** Establish centralized work environment and enable Ryan/Michael to structure their property portfolio. This is the foundation on which all other modules rely.

#### A. Sprint 1 Use Cases (Backlog)

| Category | ID | Use Case | Description |
| :--- | :--- | :--- | :--- |
| **Authentication & Security** | UC1 | Authenticate (Admin/Agent) | Secure login with email/password, role-based access |
| | UC2 | Manage Permissions | Admin can assign roles (Admin, Agent, Client) |
| **Property Management - Base** | UC3 | Add Property | Enter title, description, price, full address |
| | UC4 | Modify Property | Update essential data |
| | UC5 | Delete Property | Archive or logical deletion |
| | UC6 | View Property List | Overview with filters (status, city, price range) |
| | UC7 | View Detail | Property page with all info |
| **Image Management** | UC8 | Upload Images | Multi-file upload with preview |
| | UC9 | Photo Gallery | Organize images by property |
| | UC10 | Delete Images | File management |
| **Categorization** | UC11 | Create Categories | Admin creates types (Apartment, House, Villa, Land) |
| | UC12 | Assign Category | Property ↔ Category link |
| **Status & Availability** | UC13 | Assign Status | For Sale, For Rent, Sold, Pending |
| | UC14 | Status Timeline | History of status changes |

#### B. Expected Sprint 1 Results

At the end of this first iteration, the system enables Ryan and Michael to have a **complete and centralized property inventory** with:
- All info organized and up-to-date
- High-quality images accessible to all
- Clean database ready for searches and appointments
- Zero fragmentation: single source of truth

**Business Value:** Properties now presented professionally, info not scattered, Ryan has complete portfolio visibility.

---

## 6.4 Sprint 1 Use Cases

![Sprint 1 Use Cases](Images/Sprint1-UseCase.png)

---

### 7.3 Sprint 2: Search, Scheduling and Communication

**Objective:** Add search intelligence for clients, appointment automation and activate centralized communication. This is when the platform becomes truly useful for clients (Sarah) and when Ryan/Michael significantly gain time.

#### A. Sprint 2 Use Cases (Backlog)

| Strategic Area | ID | Use Case | Description |
| :--- | :--- | :--- | :--- |
| **Client Search (Sarah)** | UC15 | Client Login | Secure client space access |
| | UC16 | Simple Search | Search by keyword, city, price range |
| | UC17 | Advanced Filters | By bedrooms, bathrooms, property type, amenities |
| | UC18 | Sort Results | By price, date, popularity, commute distance |
| | UC19 | View Listing Detail | Complete page with photos, description, map, agent contact |
| | UC20 | Add Favorites | Create wishlist, save for later |
| **Property Comparison** | UC21 | Select for Comparison | Choose 3-6 properties |
| | UC22 | Side-by-Side View | Compare all parameters side by side |
| | UC23 | Export PDF | Download comparison as PDF |
| **Appointment Scheduling** | UC24 | Schedule Viewing | Client selects available date/time |
| | UC25 | Auto Confirmation | Email/SMS automatic confirmation |
| | UC26 | Shared Calendar | Agents see scheduled viewings |
| | UC27 | 24h Reminder | Automatic notification to both parties |
| | UC28 | Viewing History | Track past appointments and feedback |
| **Centralized Communication** | UC29 | In-App Messaging | Client ↔ Agent chat |
| | UC30 | Message History | Complete conversation preservation |
| | UC31 | Notifications | Alerts for new messages |
| | UC32 | Property Notifications | Alert client when new matching properties |
| **Agent Support** | UC33 | Client History View | Michael sees all client interactions |
| | UC34 | Private Notes | Agent can annotate interactions (feedback) |
| **Basic Analytics** | UC35 | Ryan Dashboard | Popular properties (views, inquiries) |
| | UC36 | Agent Performance | Number of scheduled viewings, conversion rate |
| | UC37 | Simple Reports | Basic metrics export |

#### B. Sprint 2 Final Results

The system becomes a true **collaborative ecosystem** with **Premium** client experience and amplified operational efficiency:

**For Ryan:**
- Recovery of minimum 20-30% of time (no more scheduling calls)
- First visibility on which properties sell fast
- Agent performance tracking

**For Michael:**
- Zero double-booking risk
- Immediate client history access
- Centralized messaging = less admin
- Frictionless mobile work

**For Sarah:**
- **Single platform** instead of 5-6 websites
- Powerful search and comparison
- Scheduling without phone calls
- Direct communication with agent
- Alerts on new properties

**Commercial Impact:**
- Reduced client friction = better conversion
- Reduced admin tasks = agents focus on value-add
- First analytics = data-driven optimization

---

## 6.5 Sprint 2 Use Cases

![Sprint 2 Use Cases](Images/Sprint2-UseCase.png)

---

## 8. Functional Mockups (UI/UX)

### Web Mockup - Homepage

![Homepage Mockup](Images/homepage.png)

---

### Web Mockup - Admin Dashboard

![Admin Dashboard Mockup](Images/admindashboard.png)

---

### Mobile Mockup

![Mobile Mockup](Images/mobile.png)

---

## 9. Architecture Design: Class Diagram

The following class diagram represents the data model and relationships between all entities in the PropertyHub system:

![Class Diagram](Images/Class-Diagram.png)

---

## Conclusion

The PropertyHub system represents a comprehensive solution to transform manual real estate operations into an efficient, scalable platform. By addressing the pain points of all three user personas (Ryan, Michael, and Sarah), the system enables:

- **Operational Efficiency:** Centralized management reducing administrative burden by 30-40%
- **Scalability:** Support for team growth without proportional increase in complexity
- **Enhanced User Experience:** Professional, intuitive interface for all user types
- **Data-Driven Operations:** Business intelligence and analytics for informed decision-making

Through iterative agile development delivered in two sprints, PropertyHub evolves from foundational property management to a full-featured collaborative ecosystem.

---

**Presented by:** AZIZ Soufiane  
**Advisor:** Mr. Essarraj Fouad  
**Date:** March 9, 2026  
**Program:** Mobile Development – Academic Year 2025/2026

---

*End of Report*
