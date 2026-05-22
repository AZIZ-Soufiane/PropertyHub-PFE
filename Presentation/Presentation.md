---
marp: true
theme: default
_class: lead
_paginate: false
paginate: true
backgroundColor: #ffffff
style: |
  section {
    font-size: 25px;
    color: #1a1a1a;
    line-height: 1.6;
    padding: 60px 80px;
  }
  footer { width: 100%; text-align: right; font-size: 18px; color: #666; padding-right: 20px; }
  .logo-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: absolute;
    top: 40px;   
    left: 60px;
    right: 60px;
  }
  .logo-header img { height: 140px; margin: 0; margin-left:10px; margin-right:10px }
  h1 { color: #029fcaff; font-size: 2.6em; margin-top: 100px; text-align: left; }
  h2 { color: #029fcaff; font-size: 1.8em; border-bottom: 2px solid #029fcaff; margin-bottom: 40px;}
  h3 { text-align: left; color: #029fcaff; margin-top: 0; font-size: 1.3em; }

  .sommaire-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 20px;
  }
  .sommaire-item {
    display: flex;
    align-items: center;
    background: #f2fafcff;
    border-radius: 12px;
    padding: 15px 20px;
    border-left: 5px solid #029fcaff;
    font-size: 22px;
  }
  .sommaire-num {
    background: #029fcaff;; color: white; width: 35px; height: 35px;
    display: flex; justify-content: center; align-items: center;
    border-radius: 50%; font-weight: bold; margin-right: 15px; flex-shrink: 0;
  }
  
  .img-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 420px;
    margin-top: 10px;
    overflow: hidden;
  }

  .img-methodo {
    max-width: 85%;
    max-height: 100%;
    object-fit: contain;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  }

  .img-usecase {
    width: auto;
    height: 100%;
    max-width: 100%;
    object-fit: contain;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
  }

  .dt-card {
    background: #f2fafcff;
    padding: 30px;
    border-radius: 10px;
    border-top: 6px solid #029fcaff;
    text-align: left;
    margin-top: 20px;
    width: 100%;
    font-size: 22px;
  }

  .tech-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 20px;
  }
  .badge-simple {
    padding: 8px 18px;
    border-radius: 6px;
    font-weight: bold;
    background-color: #545353ff;
    color: #ffffff !important;
    font-size: 0.95em;
    border: 1px solid #222;
  }

---

<div class="logo-header">
  <img src="images/ofppt.png" alt="Logo Left">
  <img src="images/solicode.png" alt="Logo Right">
</div>

# Final Year Project
### PropertyHub - Integrated Real Estate Management System

**Created by:** <span class="highlight">AZIZ Soufiane</span>  
**Supervised by:** <span class="highlight">M. ESSARRAJ Fouad</span>  
**Program:** Web and Mobile Development

---

## Table of Contents

<div class="sommaire-grid">
  <div class="sommaire-item"><div class="sommaire-num">1</div><div class="sommaire-text">Project Context</div></div>
  <div class="sommaire-item"><div class="sommaire-num">2</div><div class="sommaire-text">Methodology</div></div>
  <div class="sommaire-item"><div class="sommaire-num">3</div><div class="sommaire-text">Functional Branch</div></div>
  <div class="sommaire-item"><div class="sommaire-num">4</div><div class="sommaire-text">Technical Branch</div></div>
  <div class="sommaire-item"><div class="sommaire-num">5</div><div class="sommaire-text">Design</div></div>
  <div class="sommaire-item"><div class="sommaire-num">6</div><div class="sommaire-text">Realization</div></div>
  <div class="sommaire-item"><div class="sommaire-num">7</div><div class="sommaire-text">Conclusion</div></div>
</div>

---


## 1. Project Context

<div class="img-container">
  <img src="images/Realestate.jpg" class="img-methodo" alt="Project Context">
</div>

---

## 1.1. Define Problem

<div class="dt-card">
  <h3 style="margin-top:0;">Problem Definition</h3>
  <p>
    The real estate sector faces challenges in efficiently connecting agencies, agents, and buyers, often resulting in fragmented communication, manual processes, and lack of real-time data. PropertyHub aims to solve these issues by providing an integrated, digital platform for seamless property management, transparent transactions, and enhanced user experience for all stakeholders.
  </p>
</div>

---

## 2. Methodology: Design Thinking

<div class="img-container">
  <img src="images/design-thinking-process.jpg" class="img-methodo" alt="Design Thinking">
</div>

---

## 2. Methodology: Scrum (Agile)

<div class="img-container">
  <img src="images/scrum.jpg" class="img-methodo" alt="Scrum">
</div>

---

## 3. Functional Branch: Empathy

<div class="img-container">
  <img src="images/empathymap.png" class="img-usecase" alt="Empathy Map">
</div>

---

## Functional Branch: Use Cases

### Global Use Case - Client Part
<div class="img-container">
  <img src="images/globalUseCaseBuyerPart.png" class="img-usecase" alt="Global Use Case Client">
</div>

---

### Global Use Case - Agent (Staff) Part
<div class="img-container">
  <img src="images/globalUseCaseStaffPart.png" class="img-usecase" alt="Global Use Case Agent">
</div>

---

### Global Use Case - Admin Part
<div class="img-container">
  <img src="images/globalUseCaseAdminPart.png" class="img-usecase" alt="Global Use Case Admin">
</div>

---

## Functional Branch: Use Cases

### Sprint 1: Foundations
<div class="img-container">
  <img src="images/Sprint1-UseCase.png" class="img-usecase" alt="Sprint 1 Use Case">
</div>

---

### Sprint 2: Advanced Features
<div class="img-container">
  <img src="images/Sprint2-UseCase.png" class="img-usecase" alt="Sprint 2 Use Case">
</div>



---

## 4. Technical Branch: Tech Stack

<div class="sommaire-grid">
  
  <div class="dt-card" style="margin-top:0; border-top-color: #029fcaff;">
    <h4 style="text-align: center; border-bottom: 2px solid #029fcaff; padding-bottom: 8px;">Back-end & Architecture</h4>
    <div style="text-align: center; margin: 30px 0;">
        <p style="font-size: 1.1em; font-weight: bold; color: #444;">
            PHP 8.2+ <span style="color: #029fcaff;">•</span> Laravel 12 <span style="color: #029fcaff;">•</span> MySQL 8.0
        </p>
    </div>
    <ul style="list-style: none; padding: 15px 0 0 0; font-size: 0.9em; border-top: 1px solid #eee;">
      <li><strong>Architecture:</strong> MVC</li>
      <li><strong>Auth:</strong> Spatie Roles & Permissions</li>
      <li><strong>ORM:</strong> Eloquent</li>
    </ul>
  </div>

  <div class="dt-card" style="margin-top:0; border-top-color: #029fcaff;">
    <h4 style="text-align: center; border-bottom: 2px solid #029fcaff; padding-bottom: 8px;">Front-end & Tools</h4> 
    <div style="text-align: center; margin: 30px 0;">
        <p style="font-size: 1.1em; font-weight: bold; color: #444;">
            Tailwind CSS <span style="color: #029fcaff;">•</span> Alpine.js <span style="color: #029fcaff;">•</span> Vite
        </p>
    </div>
    <ul style="list-style: none; padding: 15px 0 0 0; font-size: 0.9em; border-top: 1px solid #eee;">
      <li><strong>UI:</strong> Preline UI</li>
      <li><strong>Responsive:</strong> Mobile-First</li>
      <li><strong>Bundler:</strong> Vite</li>
    </ul>
  </div>

</div>

---

## 5. Design: Class Diagram

<div class="img-container">
  <img src="images/Class-Diagram.png" class="img-usecase" alt="Class Diagram">
</div>

---

## 6. Realization: Core Backend Implementation

<div class="sommaire-grid">
  <div class="dt-card" style="margin-top:0; border-top-color: #029fcaff; font-size: 21px;">
    <h3 style="margin-top:0; font-size: 1.3em;">Public Service Layer</h3>
    <ul style="padding-left: 20px; margin-bottom: 0;">
      <li><strong>PropertyService:</strong> Browsing, search & favorites management</li>
      <li><strong>AppointmentService:</strong> Real-time booking & double-booking prevention</li>
      <li><strong>MessageService:</strong> In-app user-to-user messaging</li>
      <li><strong>GalleryService:</strong> Dynamic property image attachments</li>
    </ul>
  </div>
  <div class="dt-card" style="margin-top:0; border-top-color: #029fcaff; font-size: 21px;">
    <h3 style="margin-top:0; font-size: 1.3em;">Admin & Staff Service Layer</h3>
    <ul style="padding-left: 20px; margin-bottom: 0;">
      <li><strong>AdminDashboardService:</strong> Key metrics & live analytics</li>
      <li><strong>AdminPropertyService:</strong> Full lifecycle property auditing</li>
      <li><strong>AdminUserService:</strong> Role & permission synchronization</li>
      <li><strong>AdminCalendarService:</strong> Interactive agent schedule mapping</li>
    </ul>
  </div>
</div>

---

## 6. Realization: Database & Security

<div class="sommaire-grid">
  <div class="dt-card" style="margin-top:0; border-top-color: #2e7d32; font-size: 21px;">
    <h3 style="color: #2e7d32; margin-top:0; font-size: 1.3em;">Robust Security & Auth</h3>
    <ul style="padding-left: 20px; margin-bottom: 0;">
      <li><strong>Spatie RBAC:</strong> Secure boundaries for Admin, Agent, and Buyer</li>
      <li><strong>Form Requests:</strong> Strict validation of inputs at controller gates</li>
      <li><strong>Password Hashing:</strong> Safe credential handling with bcrypt</li>
      <li><strong>Database Transactions:</strong> Safe multi-table writes preventing orphan records</li>
    </ul>
  </div>
  <div class="dt-card" style="margin-top:0; border-top-color: #2e7d32; font-size: 21px;">
    <h3 style="color: #2e7d32; margin-top:0; font-size: 1.3em;">Advanced Business Logic</h3>
    <ul style="padding-left: 20px; margin-bottom: 0;">
      <li><strong>Atomic Booking:</strong> Checking agent schedules under transactional locks</li>
      <li><strong>Data Integrity:</strong> Foreign keys and cascade deletes protection</li>
      <li><strong>Paginated Queries:</strong> Optimized eager loading to solve N+1 query issue</li>
    </ul>
  </div>
</div>

---

## 6. Realization: Quality Assurance & Testing

<div class="dt-card" style="margin-top: 5px; padding: 20px; border-top-color: #e65100; font-size: 22px;">
  <h3 style="color: #e65100; margin-top:0; font-size: 1.2em; margin-bottom: 8px;">Comprehensive Service Testing (Laravel Artisan Test Suite)</h3>
  <p style="margin-bottom: 8px; font-size: 1em;">
    An extensive, regression-proof test suite has been built to validate every aspect of the backend business logic.
  </p>
  
  <div style="display: flex; justify-content: space-around; margin: 8px 0; border-top: 1px solid #eee; border-bottom: 1px solid #eee; padding: 8px 0;">
    <div style="text-align: center;">
      <span style="font-size: 1.6em; font-weight: bold; color: #e65100;">10</span><br>
      <strong style="font-size: 0.9em;">Test Suites</strong>
    </div>
    <div style="text-align: center;">
      <span style="font-size: 1.6em; font-weight: bold; color: #2e7d32;">110+</span><br>
      <strong style="font-size: 0.9em;">Test Cases</strong>
    </div>
    <div style="text-align: center;">
      <span style="font-size: 1.6em; font-weight: bold; color: #0288d1;">100%</span><br>
      <strong style="font-size: 0.9em;">Success Rate</strong>
    </div>
  </div>

  <ul style="padding-left: 20px; margin-top: 8px; margin-bottom: 0; font-size: 0.95em; line-height: 1.4;">
    <li>Coverage: Happy paths, validation gates, permission boundaries, and database locks.</li>
    <li>Command: <code>php artisan test --coverage</code></li>
  </ul>
</div>

---

## 7. Conclusion

### Thank you for your attention!
**Questions?**

---
footer: PropertyHub | Final Year Project | Solicode