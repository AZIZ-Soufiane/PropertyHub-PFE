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
  footer { width: 100%; text-align: right; font-size: 14px; color: #888; }
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
    font-weight: 600;
    background-color: #545353ff;
    color: #ffffff !important;
    font-size: 0.85em;
    border: 1px solid #222;
  }
  .maquette-grid {
    display: flex;
    gap: 15px;
    justify-content: center;
    align-items: center;
    height: 400px;
  }

---

<div class="logo-header">
  <img src="images/ofppt.png" alt="Logo Left">
  <img src="images/solicode.png" alt="Logo Right">
</div>

# Final Year Project
### PropertyHub - Integrated Real Estate Management System

**Created by :** <span class="highlight">AZIZ Soufiane</span>  
**Supervised by :** <span class="highlight">M. ESSARRAJ Fouad</span>  
**Program :** Web and Mobile Development

---

## Table of Contents

<div class="sommaire-grid">
  <div class="sommaire-item"><div class="sommaire-num">1</div><div class="sommaire-text">Project Context</div></div>
  <div class="sommaire-item"><div class="sommaire-num">2</div><div class="sommaire-text">Working Methodology</div></div>
  <div class="sommaire-item"><div class="sommaire-num">3</div><div class="sommaire-text">Functional Branch</div></div>
  <div class="sommaire-item"><div class="sommaire-num">4</div><div class="sommaire-text">Technical Branch</div></div>
  <div class="sommaire-item"><div class="sommaire-num">5</div><div class="sommaire-text">Design</div></div>
  <div class="sommaire-item"><div class="sommaire-num">6</div><div class="sommaire-text">Demonstration</div></div>
  <div class="sommaire-item"><div class="sommaire-num">7</div><div class="sommaire-text">Conclusion</div></div>
</div>

---

## 1 - Project Context

> **Challenge:** Ryan, a real estate agency owner, manages properties through scattered spreadsheets and emails, resulting in lost sales, double-booking, and lost productivity.

<div class="img-container">
  <img src="images/design-thinking-process.jpg" class="img-methodo" alt="Design Thinking">
</div>

---

## 2a - Design Thinking Methodology

The project applies **Design Thinking** across five stages:

<div class="dt-card">
  <strong>🔍 Empathy</strong> - Conducted interviews with 3 personas (property buyers, agency owners, real estate agents) to understand pain points and motivations.
</div>

<div class="dt-card">
  <strong>📋 Definition</strong> - Synthesized findings to identify core problems: data fragmentation, inefficient property search, poor client-agent communication.
</div>

<div class="dt-card">
  <strong>💡 Ideation</strong> - Brainstormed solutions resulting in an integrated platform with centralized property database, advanced search, and messaging system.
</div>

---

## 2b - Agile/Scrum Methodology

**PropertyHub** development follows **Scrum framework** with 2-week sprints:

<div class="img-container">
  <img src="images/scrum.webp"class="img-methodo" alt="Scrum Methodology">
</div>

---

## 3a - User Research: Personas & Empathy

### Ryan - Digital Opportunity

> Agency owner seeking streamlined operations and better client engagement

<div class="dt-card">
  <strong>😟 What Ryan feels:</strong> Overwhelmed by manual processes, scattered client information, and difficulty scaling the business.
</div>

<div class="dt-card">
  <strong>💡 Opportunity:</strong> Centralized platform to manage all properties, clients, and agents with built-in messaging and analytics.
</div>

---

## 3b - Empathy Map Analysis

<div class="img-container">
  <img src="images/empathymap.png" class="img-usecase" alt="Empathy Map">
</div>

---

## 4a - Problems Identified

> **3 Core User Groups, 15+ Pain Points Resolved**

<div class="dt-card">
  <strong>🧑‍💼 Ryan (Agency Owner):</strong> Scattered client data, manual reporting, scaling challenges
</div>

<div class="dt-card">
  <strong>👩‍💼 Sarah (Property Buyer):</strong> Multiple platform searches, slow agent response, incomplete property info
</div>

<div class="dt-card">
  <strong>👨‍💻 Michael (Real Estate Agent):</strong> Inefficient lead management, outdated tools, limited client insights
</div>

---

## 4b - Solutions Designed

<div class="dt-card">
  <strong>✅ Centralized Property Database</strong> - All listings in one system with real-time updates
</div>

<div class="dt-card">
  <strong>✅ Advanced Search & Filters</strong> - Quick property discovery by location, price, amenities
</div>

<div class="dt-card">
  <strong>✅ Integrated Messaging System</strong> - Direct communication between buyers, agents, and staff
</div>

<div class="dt-card">
  <strong>✅ Role-Based Dashboard</strong> - Customized views for owners, agents, and buyers
</div>

---

## 5a - Use Cases: Global Overview

<div class="img-container">
  <img src="images/globalUseCase.png" class="img-usecase" alt="Global Use Cases">
</div>

---

## 5b - Use Cases: Sprint 1 (Foundations)

<div class="img-container">
  <img src="images/sprint1-usecase.png" class="img-usecase" alt="Sprint 1 Use Cases">
</div>

---

## 5c - Use Cases: Sprint 2 (Advanced Features)

<div class="img-container">
  <img src="images/sprint2-usecase.png" class="img-usecase" alt="Sprint 2 Use Cases">
</div>

---

## 6a - Application Design: Wireframes

<div class="img-container">
  <img src="" class="img-usecase" alt="Application Wireframes">
</div>

---

## 6b - Data Model (Entity-Relationship Diagram)

<div class="img-container">
  <img src="" class="img-usecase" alt="Data Model Diagram">
</div>

---

## Technical Stack

<div class="dt-card">
  <strong>💾 Backend & Database</strong><br/>
  <div class="tech-container">
    <span class="badge-simple">Laravel 12</span>
    <span class="badge-simple">PHP 8.2+</span>
    <span class="badge-simple">MySQL 8.0</span>
    <span class="badge-simple">REST API</span>
  </div>
</div>

<div class="dt-card">
  <strong>🎨 Frontend & UI</strong><br/>
  <div class="tech-container">
    <span class="badge-simple">Tailwind CSS</span>
    <span class="badge-simple">Blade Templates</span>
    <span class="badge-simple">Alpine.js</span>
    <span class="badge-simple">AJAX</span>
  </div>
</div>

<div class="dt-card">
  <strong>🛠 Tools & DevOps</strong><br/>
  <div class="tech-container">
    <span class="badge-simple">Vite (Build Tool)</span>
    <span class="badge-simple">Git/GitHub</span>
    <span class="badge-simple">VS Code</span>
    <span class="badge-simple">PHPUnit Testing</span>
  </div>
</div>

---

## Key Features Summary

<div class="dt-card">
  ✅ **User Management** - Create accounts with roles (buyer, agent, owner)  
  ✅ **Property Management** - Add, edit, delete properties with full descriptions  
  ✅ **Advanced Search** - Filter by location, price, amenities, and property type  
  ✅ **Direct Messaging** - Real-time communication between platform users  
  ✅ **Property Favorites** - Save and organize favorite listings  
  ✅ **Admin Analytics** - Dashboard with insights on listings, users, and activity  
  ✅ **Responsive Design** - Works seamlessly on desktop, tablet, and mobile
</div>

---

## Conclusion

**PropertyHub** addresses critical pain points in the real estate industry by creating a **unified, user-centric platform** that empowers all stakeholders:

- 🎯 **For Ryan:** Operational efficiency and business scalability
- 👩 **For Sarah:** Faster property discovery and better communication
- 👨 **For Michael:** Modern tools for effective client management

**Technical Excellence:** Built with modern frameworks and best practices ensures maintainability, scalability, and security.

**Impact:** A comprehensive solution that transforms how real estate professionals and buyers interact with property information.

---
footer: PropertyHub | Final Year Project | OFPPT Sidi Slimane

