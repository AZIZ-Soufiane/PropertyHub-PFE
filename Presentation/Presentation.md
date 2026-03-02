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

  .persona-card {
    background: white;
    border: 2px solid #029fcaff;
    border-radius: 10px;
    padding: 20px;
    margin: 10px 0;
    flex: 1;
  }

  .personas-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 15px;
    margin-top: 20px;
  }

  .pain-point {
    background: #fff3cd;
    border-left: 4px solid #f39c12;
    padding: 12px;
    margin: 8px 0;
    border-radius: 4px;
    font-size: 0.95em;
  }

  .solution-highlight {
    background: #d4ededa0;
    border-left: 4px solid #27ae60;
    padding: 12px;
    margin: 8px 0;
    border-radius: 4px;
    font-size: 0.95em;
  }

---

# Final Year Project
### PropertyHub - Integrated Real Estate Management System

**Created by:** <span style="color: #029fcaff; font-weight: bold;">Soufiane</span>  
**Context:** Analysis and Design of a Web-based Real Estate Management Solution  
**Program:** Web and Mobile Development

---

## Table of Contents

<div class="sommaire-grid">
  <div class="sommaire-item"><div class="sommaire-num">1</div><div class="sommaire-text">Project Context</div></div>
  <div class="sommaire-item"><div class="sommaire-num">2</div><div class="sommaire-text">Working Methodology</div></div>
  <div class="sommaire-item"><div class="sommaire-num">3</div><div class="sommaire-text">Functional Branch - Empathy</div></div>
  <div class="sommaire-item"><div class="sommaire-num">4</div><div class="sommaire-text">Problems & Solutions</div></div>
  <div class="sommaire-item"><div class="sommaire-num">5</div><div class="sommaire-text">Technical Branch</div></div>
  <div class="sommaire-item"><div class="sommaire-num">6</div><div class="sommaire-text">Design & Demonstration</div></div>
  <div class="sommaire-item"><div class="sommaire-num">7</div><div class="sommaire-text">Conclusion</div></div>
</div>

---

## 1. Project Context

<div class="dt-card" style="border-top-color: #f39c12;">
  <h4>🎯 Objective</h4>
  <p>Develop an <strong>integrated web platform for real estate management</strong> to address the operational challenges of real estate agents and improve the user experience for buyers.</p>
</div>

<div class="dt-card" style="border-top-color: #3498db;">
  <h4>📍 Context</h4>
  <p>Ryan, owner of a real estate agency in Austin, currently manages his properties through <strong>scattered spreadsheets and emails</strong>. This results in:</p>
  <ul>
    <li>Lost sales (properties forgotten as sold)</li>
    <li>Double-booking of appointments</li>
    <li>Time wasted on administrative tasks</li>
    <li>Inability to scale</li>
  </ul>
</div>

---

## 2. Methodology: Design Thinking

<div class="dt-card" style="border-top-color: #f39c12;">
  <h4>🧠 Design Thinking Approach</h4>
  <p>Our analysis follows the 5 phases of Design Thinking:</p>
  <ol>
    <li><strong>Empathy</strong> - User interviews (Sarah, Ryan, Michael)</li>
    <li><strong>Define</strong> - Identification of key problems</li>
    <li><strong>Ideate</strong> - Solution generation</li>
    <li><strong>Prototype</strong> - Creation of mockups and use cases</li>
    <li><strong>Test</strong> - Validation with users</li>
  </ol>
</div>

---

## 3. Functional Branch: The Personas

<style>
.personas-row {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 15px;
  margin-top: 20px;
}
.persona-box {
  background: linear-gradient(135deg, #f2fafcff 0%, #e8f7fcff 100%);
  border: 2px solid #029fcaff;
  border-radius: 10px;
  padding: 20px;
  text-align: center;
}
.persona-box h3 {
  color: #029fcaff;
  font-size: 1.5em;
  margin: 0 0 10px 0;
}
.persona-box .role {
  color: #555;
  font-style: italic;
  font-size: 0.9em;
  margin-bottom: 15px;
}
.persona-box ul {
  text-align: left;
  font-size: 0.85em;
  line-height: 1.4;
}
</style>

<div class="personas-row">
  <div class="persona-box">
    <h3>👩‍💻 Sarah</h3>
    <p class="role">Buyer / Customer</p>
    <ul>
      <li>32 years old, Software Engineer</li>
      <li>Tech-savvy</li>
      <li>Looking for first property</li>
      <li>Searches across 5-6 websites</li>
      <li>2-3 hours/day on listings</li>
    </ul>
  </div>

  <div class="persona-box">
    <h3>🏢 Ryan</h3>
    <p class="role">Agency Owner</p>
    <ul>
      <li>Real estate agency owner</li>
      <li>Manual management (Excel)</li>
      <li>Forgotten updates</li>
      <li>40% time on admin</li>
      <li>Wants to scale</li>
    </ul>
  </div>

  <div class="persona-box">
    <h3>🤝 Michael</h3>
    <p class="role">Real Estate Agent</p>
    <ul>
      <li>3 years of experience</li>
      <li>Scattered information</li>
      <li>Double-booking issues</li>
      <li>25-35 clients/day</li>
      <li>30-45 min admin/day</li>
    </ul>
  </div>
</div>

---

## Empathy: Sarah's Pain Points (Buyer)

<div class="pain-point">
  <strong>🔴 Frustration 1:</strong> Information scattered across multiple platforms - must create manual spreadsheets
</div>

<div class="pain-point">
  <strong>🔴 Frustration 2:</strong> Poor quality or missing photos - wasted time visiting properties in person
</div>

<div class="pain-point">
  <strong>🔴 Frustration 3:</strong> Cannot schedule viewings online - must call during business hours
</div>

<div class="pain-point">
  <strong>🔴 Frustration 4:</strong> No comparison tools - manually creates Excel spreadsheets
</div>

<div class="pain-point">
  <strong>🔴 Frustration 5:</strong> Trust issues - outdated listings, contradictory information
</div>

---

## Empathy: Ryan's Pain Points (Owner)

<div class="pain-point">
  <strong>🔴 Problem 1:</strong> Scattered data (spreadsheets, emails, notes) - forgotten updates = lost sales
</div>

<div class="pain-point">
  <strong>🔴 Problem 2:</strong> Manual appointment management by phone - frequent double-booking
</div>

<div class="pain-point">
  <strong>🔴 Problem 3:</strong> Inefficient client communication - same questions repeated
</div>

<div class="pain-point">
  <strong>🔴 Problem 4:</strong> No online property visibility - limited reach
</div>

<div class="pain-point">
  <strong>🔴 Problem 5:</strong> No analytics - decisions based on intuition, not data
</div>

---

## Empathy: Michael's Pain Points (Agent)

<div class="pain-point">
  <strong>🔴 Problem 1:</strong> Information silos - gives outdated information to clients
</div>

<div class="pain-point">
  <strong>🔴 Problem 2:</strong> Double-booking conflicts - scheduling conflicts with Ryan
</div>

<div class="pain-point">
  <strong>🔴 Problem 3:</strong> Inaccessible images - must wait for Ryan to access photos
</div>

<div class="pain-point">
  <strong>🔴 Problem 4:</strong> 30-45 min/day on admin tasks - manual summaries for Ryan
</div>

<div class="pain-point">
  <strong>🔴 Problem 5:</strong> No client tracking - loses client preferences and history
</div>

---

## 4. Functional Branch: Key Problems

<div class="dt-card" style="border-top-color: #e74c3c;">
  <h4>🎯 Critical Problems Identified</h4>
  <ol>
    <li><strong>Fragmented system:</strong> Data scattered across multiple tools (Excel, email, paper)</li>
    <li><strong>Failing appointment management:</strong> Double-booking, manual phone coordination</li>
    <li><strong>Ineffective search:</strong> Inaccurate filters, irrelevant results, no alerts</li>
    <li><strong>Lack of comparison:</strong> No tool to compare properties side-by-side</li>
    <li><strong>Slow communication:</strong> No messaging platform, phone dependency</li>
    <li><strong>Information loss:</strong> Lost client history, contradictory information</li>
  </ol>
</div>

---

## Functional Branch: Proposed Solution

<div class="dt-card" style="border-top-color: #27ae60;">
  <h4>✅ PropertyHub Integrated Platform</h4>
  <p>A <strong>centralized web solution</strong> that offers:</p>
</div>

<div class="solution-highlight">
  <strong>For buyers (Sarah):</strong> Powerful search, property comparison, online scheduling, direct messaging, smart alerts
</div>

<div class="solution-highlight">
  <strong>For admin (Ryan):</strong> Centralized property management, appointment tracking, analytics, scalability, automation
</div>

<div class="solution-highlight">
  <strong>For agents (Michael):</strong> Real-time information access, shared calendar, client history, productivity tools, mobile work
</div>

---

## Functional Branch: Global Use Cases

<div class="dt-card" style="border-top-color: #3498db;">
  <h4>🔄 Main System Flow</h4>
  <ul style="font-size: 0.9em;">
    <li><strong>Admin (Ryan):</strong> Create/edit properties → Manage appointments → Analytics tracking</li>
    <li><strong>Users (Buyers):</strong> Search → Filter → Compare → Schedule visit → Contact agent</li>
    <li><strong>Agents (Michael):</strong> Access information → Manage calendar → Client tracking</li>
  </ul>
</div>

---

## Functional Branch: Core Features

<style>
.features-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 15px;
  margin-top: 20px;
}
.feature-box {
  background: #f2fafcff;
  border-left: 4px solid #029fcaff;
  padding: 20px;
  border-radius: 8px;
}
.feature-box h4 {
  color: #029fcaff;
  margin-top: 0;
}
.feature-box ul {
  margin: 0;
  padding-left: 20px;
  font-size: 0.9em;
}
</style>

<div class="features-grid">
  <div class="feature-box">
    <h4>🏠 Property Management</h4>
    <ul>
      <li>Create/edit properties</li>
      <li>Multiple images and galleries</li>
      <li>Categorization</li>
      <li>Status (For Sale/Rent/Sold)</li>
      <li>Complete details</li>
    </ul>
  </div>

  <div class="feature-box">
    <h4>🔍 Advanced Search</h4>
    <ul>
      <li>Multiple filters</li>
      <li>By city, budget, bedrooms</li>
      <li>Keyword search</li>
      <li>Sorting by criteria</li>
      <li>Smart alerts</li>
    </ul>
  </div>

  <div class="feature-box">
    <h4>📋 Appointment Management</h4>
    <ul>
      <li>Online scheduling</li>
      <li>Shared calendar</li>
      <li>Confirmations and reminders</li>
      <li>No double-booking</li>
      <li>Viewing history</li>
    </ul>
  </div>

  <div class="feature-box">
    <h4>⭐ Favorites & Comparison</h4>
    <ul>
      <li>Save favorites</li>
      <li>Side-by-side comparison</li>
      <li>Custom notes</li>
      <li>Share with agents</li>
      <li>PDF export</li>
    </ul>
  </div>

  <div class="feature-box">
    <h4>💬 Communication</h4>
    <ul>
      <li>In-app messaging</li>
      <li>No phone dependency</li>
      <li>Message history</li>
      <li>Notifications</li>
      <li>Audit trail</li>
    </ul>
  </div>

  <div class="feature-box">
    <h4>📊 Analytics & Dashboard</h4>
    <ul>
      <li>Property statistics</li>
      <li>Property popularity</li>
      <li>Market trends</li>
      <li>Agent performance</li>
      <li>Exportable reports</li>
    </ul>
  </div>
</div>

---

## 5. Technical Branch: Architecture

<div class="dt-card" style="border-top-color: #27ae60;">
  <h4>🏗 N-Tier Architecture</h4>
  <ul style="font-size: 0.9em;">
    <li><strong>Presentation Layer:</strong> Responsive web interface (HTML, CSS, JavaScript)</li>
    <li><strong>Business Logic Layer:</strong> Application logic (Laravel Service Layer)</li>
    <li><strong>Data Layer:</strong> MySQL database with relational model</li>
    <li><strong>Integration:</strong> RESTful API for mobile and third-party</li>
  </ul>
</div>

---

## Technical Branch: Tech Stack

<div class="sommaire-grid">
  <div class="dt-card" style="margin-top:0;">
    <h4>🖥 Backend</h4>
    <ul>
      <li><strong>Framework:</strong> Laravel 12</li>
      <li><strong>Database:</strong> MySQL</li>
      <li><strong>Auth:</strong> Spatie Roles & Permissions</li>
      <li><strong>API:</strong> REST, JSON</li>
      <li><strong>Storage:</strong> Laravel Storage (images)</li>
    </ul>
  </div>

  <div class="dt-card" style="margin-top:0; border-top-color: #3498db;">
    <h4>🎨 Frontend</h4>
    <ul>
      <li><strong>Styling:</strong> Tailwind CSS</li>
      <li><strong>Templating:</strong> Blade</li>
      <li><strong>Interactivity:</strong> Alpine.js, AJAX</li>
      <li><strong>Build:</strong> Vite</li>
      <li><strong>Icons:</strong> Lucide</li>
    </ul>
  </div>
</div>

<div class="dt-card" style="border-top-color: #e74c3c; margin-top: 20px;">
  <h4>🛠 Tools & Process</h4>
  <ul>
    <li><strong>Versioning:</strong> Git/GitHub</li>
    <li><strong>IDE:</strong> VS Code</li>
    <li><strong>Management:</strong> Scrum/Agile</li>
    <li><strong>Documentation:</strong> Mermaid, PlantUML</li>
    <li><strong>Testing:</strong> PHPUnit</li>
  </ul>
</div>

---

## 6. Design: Data Model

<style>
.mld-description {
  background: #f2fafcff;
  border-left: 4px solid #029fcaff;
  padding: 20px;
  border-radius: 8px;
  margin-top: 20px;
}
.mld-description h4 {
  color: #029fcaff;
  margin-top: 0;
}
</style>

<div class="mld-description">
  <h4>📋 Main Entities</h4>
  <ul style="font-size: 0.9em;">
    <li><strong>Users:</strong> Roles (Admin, Agent, Client) with granular permissions</li>
    <li><strong>Properties:</strong> Properties with images, details, status</li>
    <li><strong>Categories:</strong> Classification (Apartment, House, Villa, Land)</li>
    <li><strong>Appointments:</strong> Appointments with dates, times, status (Approved, Rejected, Pending)</li>
    <li><strong>Favorites:</strong> Properties marked as favorites by clients</li>
    <li><strong>Messages:</strong> Communication between agents and clients</li>
    <li><strong>PropertyImages:</strong> Multiple images per property with gallery</li>
  </ul>
</div>

---

## Design: Main Relationships

<div class="dt-card" style="border-top-color: #3498db;">
  <h4>🔗 Flux de Données</h4>
  <pre style="background: white; padding: 15px; border-radius: 6px; font-size: 0.8em;">
Admin (Ryan)
  ├─ Creates & Manages → Properties
  │  ├─ Has Multiple → PropertyImages
  │  └─ Has → Status (For Sale, For Rent, Sold)
  ├─ Has Multiple → Agents/Staff
  └─ Reviews → Appointments

Users (Clients)
  ├─ Browse → Properties
  ├─ Create → Favorites
  ├─ Schedule → Appointments
  ├─ Send Messages → Agents
  └─ View → Comparisons

Agents (Michael)
  ├─ Manage → Property Details
  ├─ View → Appointments Calendar
  ├─ Reply → Client Messages
  └─ Track → Performance Metrics
  </pre>
</div>

---

## 7. Demonstration: User Interfaces

<div class="dt-card" style="border-top-color: #f39c12;">
  <h4>🎨 Planned Main Pages</h4>
  <ol style="font-size: 0.9em;">
    <li><strong>Home:</strong> Quick search, featured properties, navigation</li>
    <li><strong>Advanced Search:</strong> Filters, sorting, paginated results</li>
    <li><strong>Property Detail:</strong> Images, description, amenities, agent, appointment form</li>
    <li><strong>Client Dashboard:</strong> Favorites, saved searches, appointment history, messages</li>
    <li><strong>Admin Dashboard:</strong> Property management, appointments, users, analytics</li>
    <li><strong>Appointment Calendar:</strong> Shared scheduling, prevent double-booking</li>
    <li><strong>Messaging:</strong> In-app conversations with agents</li>
  </ol>
</div>

---

## Demonstration: Before/After Comparison

<style>
.comparison-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
  font-size: 0.85em;
}
.comparison-table th, .comparison-table td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
}
.comparison-table th {
  background: #029fcaff;
  color: white;
}
.comparison-table tr:nth-child(even) {
  background: #f2fafcff;
}
.before { color: #e74c3c; font-weight: bold; }
.after { color: #27ae60; font-weight: bold; }
</style>

<table class="comparison-table">
  <tr>
    <th>Criteria</th>
    <th class="before">❌ Before (Current)</th>
    <th class="after">✅ After (PropertyHub)</th>
  </tr>
  <tr>
    <td><strong>Data</strong></td>
    <td>Scattered (Excel, email, paper)</td>
    <td>Centralized in 1 database</td>
  </tr>
  <tr>
    <td><strong>Appointments</strong></td>
    <td>Phone + Manual → Double-booking</td>
    <td>Shared calendar + Auto confirmations</td>
  </tr>
  <tr>
    <td><strong>Images</strong></td>
    <td>Missing/poor quality, inaccessible</td>
    <td>Multi-image, galleries, high resolution</td>
  </tr>
  <tr>
    <td><strong>Communication</strong></td>
    <td>Phone + SMS → Slow</td>
    <td>In-app messaging → 24/7</td>
  </tr>
  <tr>
    <td><strong>Search</strong></td>
    <td>Inaccurate filters, irrelevant results</td>
    <td>Advanced filters + Smart alerts</td>
  </tr>
  <tr>
    <td><strong>Comparison</strong></td>
    <td>Manual spreadsheets</td>
    <td>Integrated side-by-side tool</td>
  </tr>
  <tr>
    <td><strong>Analytics</strong></td>
    <td>None, intuition only</td>
    <td>Full dashboard with statistics</td>
  </tr>
  <tr>
    <td><strong>Admin Time</strong></td>
    <td>40% of time = energy loss</td>
    <td>~10% of time = gained efficiency</td>
  </tr>
</table>

---

## Conclusion: Expected Impact

<div class="dt-card" style="border-top-color: #27ae60;">
  <h4>🎯 Key Benefits for Each User</h4>
</div>

<div class="solution-highlight">
  <strong>👩‍💻 Sarah (Buyer):</strong> Faster search, easy comparison, increased trust, 24/7 access, direct communication = better decisions in less time
</div>

<div class="solution-highlight">
  <strong>🏢 Ryan (Owner):</strong> Centralized management, no lost sales, scalability, data-driven decisions, possible delegation = business growth
</div>

<div class="solution-highlight">
  <strong>🤝 Michael (Agent):</strong> Real-time information, conflict-free calendar, less paperwork, client history, productivity ↑ = sales ↑
</div>

---

## Thank You for Your Attention!

<div class="dt-card" style="border-top-color: #f39c12; margin-top: 40px; text-align: center;">
  <h3 style="text-align: center; margin: 0;">Questions?</h3>
  <p style="margin-top: 20px; font-size: 0.9em;">
    <strong>PropertyHub</strong> - Digitalize real estate management for a modern and transparent market
  </p>
</div>
