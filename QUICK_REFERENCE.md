# PropertyHub Quick Reference Guide

## 🎯 ONE-PAGE OVERVIEW

### Backend (PropertyHub-PFE/PropertyHub/)
- **Type:** Laravel REST API
- **Auth:** Sanctum Bearer tokens
- **Database:** SQLite
- **Models:** User, Property, Appointment, Message, Gallery, Calendar, Report
- **Controllers:** 5 (Auth, Property, Appointment, Message, User)
- **Services:** 4 (Property, Appointment, Message, User)
- **Routes:** 40+ endpoints
- **Status:** 85% complete

### Mobile (mobile-app/app/)
- **Type:** NativePHP Laravel web app
- **Framework:** Laravel (same as backend)
- **Consumer:** Calls backend API via HTTP
- **Controllers:** 5 (Auth, Property, Appointment, Api, Book)
- **Services:** 1 main (PropertyHubApiService)
- **Routes:** 10+ web routes
- **Status:** 60% complete

---

## 📁 DIRECTORY QUICK LOOKUP

### Backend Code Locations
```
Controllers      → app/Http/Controllers/Api/
Services         → app/Services/
Models           → app/Models/
Database         → database/ (migrations, factories, seeders)
Routes           → routes/api.php
Resources        → app/Http/Resources/
Config           → config/
```

### Mobile Code Locations
```
Controllers      → app/Http/Controllers/
API Bridge       → app/Services/PropertyHubApiService.php
Models           → app/Models/
Routes           → routes/web.php
Views            → resources/views/
```

---

## 🗄️ DATABASE SNAPSHOT

### Tables (10 total)
1. **users** - id, name, email, password, role (buyer|agent|admin), license_number
2. **properties** - id, price, location, status, agent_id
3. **galleries** - id, property_id, image_urls (JSON)
4. **calendars** - id, agent_id, available_days (JSON)
5. **messages** - id, content, timestamp, sender_id, receiver_id
6. **appointments** - id, date_time, status, buyer_id, agent_id, calendar_id
7. **reports** - id, data_summary, admin_id
8. **property_user** - id, user_id, property_id (favorites pivot)
9. **cache** - Laravel cache table
10. **jobs** - Laravel queue table

### Key Relationships
- User 1:M Property (agent listing)
- User M:M Property (buyer favorites)
- User 1:1 Calendar (agent only)
- Property 1:M Gallery
- User 1:M Message (sender + receiver)
- Calendar 1:M Appointment

---

## 🛣️ MAIN API ENDPOINTS

### Public
```
POST   /api/auth/register
POST   /api/auth/login
GET    /api/properties
GET    /api/properties/{id}
GET    /api/properties/search?location=...&min_price=...&max_price=...
GET    /api/agents
```

### Protected (add Authorization: Bearer TOKEN header)
```
Auth
  GET    /api/auth/user
  POST   /api/auth/logout

Properties
  POST   /api/properties (create)
  GET    /api/properties/{id}/details
  POST   /api/properties/{id}/favorite
  DELETE /api/properties/{id}/favorite
  GET    /api/favorites
  GET    /api/properties/agent/{agentId}
  GET    /api/dashboard/stats

Appointments
  GET    /api/appointments
  POST   /api/appointments
  GET    /api/appointments/{id}
  GET    /api/appointments/agent/{agentId}/slots
  POST   /api/appointments/{id}/reschedule
  POST   /api/appointments/{id}/cancel
  POST   /api/appointments/{id}/complete

Messages
  GET    /api/messages
  POST   /api/messages
  DELETE /api/messages/{id}
  GET    /api/messages/conversations
  GET    /api/messages/conversation/{userId}
  GET    /api/messages/inbox
  GET    /api/messages/sent

Users
  GET    /api/users/{userId}
  POST   /api/users/profile (update)
  GET    /api/users/agents
```

---

## 🔧 KEY SERVICES

### PropertyService
```php
getProperties(status, perPage)
getPropertyDetails(id)
searchProperties(location, minPrice, maxPrice)
createProperty(data)
```

### AppointmentService
```php
getAvailableSlots(agentId, date)          // Returns 9-18 business hours
bookAppointment(buyerId, agentId, dateTime)
cancelAppointment(appointmentId, userId)
rescheduleAppointment()
completeAppointment()
```

### MessageService
```php
sendMessage(senderId, receiverId, content)
getConversation(userId1, userId2)
getInbox(userId)
getSentMessages(userId)
deleteMessage(messageId, userId)
```

### UserService
```php
getUsers(role, perPage)
createUser(data)
updateUser(userId, data)
assignRole(userId, role)
deleteUser(userId)
```

---

## 📱 MOBILE ROUTES

```
GET    /                           (redirect to properties)
GET    /properties                 (list with search)
GET    /properties/{id}            (details)
GET    /properties/agent/{agentId} (by agent)
GET    /login
POST   /login
GET    /register
POST   /register
POST   /logout
GET    /appointments               (my appointments)
GET    /appointments/book/{id}     (booking form)
POST   /appointments/slots         (AJAX - get available times)
POST   /appointments               (create)
POST   /appointments/{id}/cancel   (cancel)
```

---

## 🚀 STARTING THE PROJECT

### Backend Setup
```bash
cd PropertyHub-PFE/PropertyHub
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

### Mobile Setup
```bash
cd mobile-app/app
composer install
npm install
npm run dev
# For NativePHP desktop app:
php artisan native:build
```

---

## ✅ IMPLEMENTATION CHECKLIST

### Fully Implemented ✅
- [x] User authentication (register, login, logout)
- [x] Property CRUD & search
- [x] Property galleries (image arrays)
- [x] Appointment booking system
- [x] Message/chat system
- [x] User profiles
- [x] Favorites/wishlist
- [x] Agent listings
- [x] Role-based users (buyer, agent, admin)
- [x] Calendar/availability system

### Partially Done ⚠️
- [ ] Admin dashboard (reports exist but incomplete)
- [ ] Mobile UI (controllers exist, views minimal)
- [ ] Notifications (designed but not wired)
- [ ] File uploads (using image URLs only)
- [ ] Real-time features (no WebSocket)

### Not Started ❌
- [ ] Payment integration
- [ ] Reviews/ratings
- [ ] Virtual tours
- [ ] Two-factor authentication
- [ ] Document management
- [ ] Inspection reports
- [ ] Commission tracking
- [ ] Mortgage calculator

---

## 🐛 COMMON FILES TO CHECK

When debugging, check these first:

| Issue | File |
|-------|------|
| API routes not working | `routes/api.php` |
| Property not showing | `app/Services/PropertyService.php` |
| Login failing | `app/Http/Controllers/Api/AuthController.php` |
| Appointments not booking | `app/Services/AppointmentService.php` |
| Messages not sending | `app/Services/MessageService.php` |
| Mobile page not rendering | `routes/web.php` |
| API connection failing | `mobile-app/app/app/Services/PropertyHubApiService.php` |

---

## 🔐 AUTHENTICATION FLOW

```
User enters credentials
     ↓
POST /api/auth/login (email, password)
     ↓
AuthController validates with Hash::check()
     ↓
Creates Sanctum token: $user->createToken('api-token')->plainTextToken
     ↓
Returns token to mobile app
     ↓
Mobile stores in session: session(['api_token' => $token])
     ↓
All future requests include: Authorization: Bearer {token}
     ↓
Laravel Sanctum middleware validates token
```

---

## 📊 DATA MODELS OVERVIEW

```
User
├── buyer (browse, favorite, book appointments, message agents)
├── agent (list properties, manage availability, accept appointments)
└── admin (manage users, view reports, moderate content)

Property
├── Listed by agent
├── Contains galleries (image URLs)
├── Has availability calendar
├── Can be favorited by multiple buyers
└── Has appointment history

Appointment
├── Links buyer → agent
├── Uses calendar slot
├── Has status: scheduled|cancelled|completed
└── Can be rescheduled

Message
├── From sender → receiver
├── Bidirectional queries form conversations
└── Can be deleted by participants

Calendar
├── One per agent
└── Contains available_days (JSON: ["Mon", "Tue"...])
```

---

## 🎯 MAJOR GAPS TO ADDRESS

1. **Payment System** - No transaction/payment models
2. **File Upload** - Images hardcoded as URLs
3. **Notifications** - No email/SMS/push notifications
4. **Real-time Chat** - Messages are polling-based, not real-time
5. **Mobile UI** - Views are minimal/incomplete
6. **Security** - No role middleware, no 2FA
7. **Performance** - No caching, basic search only
8. **Admin Panel** - Reports exist but UI missing

---

## 📈 QUERY OPTIMIZATION TIPS

```php
// Eager load relationships to avoid N+1
Property::with('agent', 'galleries', 'buyer')->get();

// Use pagination instead of all()
Property::paginate(15);

// Filter early
Property::where('status', 'active')->paginate();

// Index these columns
properties(status, agent_id)
messages(sender_id, receiver_id, timestamp)
appointments(calendar_id, date_time)
property_user(user_id, property_id)
```

---

## 🔗 QUICK TEST CURL COMMANDS

```bash
# Register
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John","email":"john@test.com","password":"password123","password_confirmation":"password123","role":"buyer"}'

# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@test.com","password":"password123"}'

# Get properties (public)
curl http://localhost:8000/api/properties?page=1&per_page=15

# Get properties (authenticated)
curl -H "Authorization: Bearer TOKEN" http://localhost:8000/api/auth/user
```

---

**Last Updated:** April 3, 2026  
**Quick Ref Version:** 1.0
