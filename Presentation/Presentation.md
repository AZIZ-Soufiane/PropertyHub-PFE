---
marp: true
theme: default
_class: lead
_paginate: false
paginate: true
backgroundColor: #ffffff
style: |
  section {
    font-size: 22px;
    color: #333;
    line-height: 1.6;
    padding: 60px 80px;
  }
  footer { width: 100%; text-align: right; font-size: 14px; color: #888; padding-right: 20px; }
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
  h1 { color: #029fcaff; font-size: 2.8em; margin-top: 100px; text-align: left; }
  h2 { color: #029fcaff; font-size: 2em; border-bottom: 2px solid #029fcaff; margin-bottom: 40px;}
  h3 { text-align: left; color: #029fcaff; margin-top: 0; }

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
    font-size: 0.85em;
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
  <div class="sommaire-item"><div class="sommaire-num">6</div><div class="sommaire-text">Conclusion</div></div>
</div>

---

## 1. Project Context

<div class="img-container">
  <img src="images/Realestate.jpg" class="img-methodo" alt="Project Context">
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

## Functional Branch: Mockups (UI/UX) Web

### Homepage
<div class="img-container">
  <img src="images/homepage.png" class="img-methodo" alt="Homepage Mockup">
</div>

---

### Admin Dashboard
<div class="img-container">
  <img src="images/admindashboard.png" class="img-methodo" alt="Admin Dashboard Mockup">
</div>

---

## Functional Branch: Mockups (UI/UX) Mobile

<div class="img-container">
  <img src="images/mobile.png" class="img-methodo" alt="Mobile Mockup">
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

## 6. Conclusion

### Thank you for your attention!
**Questions?**

---
footer: PropertyHub | Final Year Project | Solicode