# PropertyHub Codebase Structure Inventory
**Generated:** April 3, 2026 | **Project Phase:** Development

---

## 📋 Executive Summary

PropertyHub consists of **two interconnected Laravel applications**:

1. **Main Backend API** (`PropertyHub-PFE/PropertyHub/`) - REST API serving the entire platform
2. **Mobile App Frontend** (`mobile-app/app/`) - NativePHP Laravel app consuming the API

Both use **Laravel Sanctum** for authentication and **SQLite** for persistent data storage.

---

## 🏗️ SECTION 1: Main Backend Architecture

### Directory Tree Structure

```
PropertyHub/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── AuthController.php ...................... Authentication (register, login, logout)
│   │   │   │   ├── PropertyController.php .................. Property CRUD & search
│   │   │   │   ├── AppointmentController.php ............... Appointment booking & management
│   │   │   │   ├── MessageController.php ................... Messaging system
│   │   │   │   └── UserController.php ...................... User profiles & agent listings
│   │   │   └── Controller.php (base class)
│   │   │
│   │   └── Resources/
│   │       ├── PropertyResource.php
│   │       ├── UserResource.php
│   │       ├── AppointmentResource.php
│   │       ├── MessageResource.php
│   │       └── GalleryResource.php
│   │
│   ├── Models/
│   │   ├── User.php ..................................... Fields: name, email, password, role (buyer|agent|admin), license_number
│   │   ├── Property.php .................................. Fields: price, location, status, agent_id
│   │   ├── Appointment.php ............................... Fields: date_time, status, buyer_id, agent_id, calendar_id
│   │   ├── Message.php ................................... Fields: content, timestamp, sender_id, receiver_id
│   │   ├── Gallery.php ................................... Fields: property_id, image_urls (JSON)
│   │   ├── Calendar.php .................................. Fields: agent_id, available_days (JSON)
│   │   └── Report.php .................................... Fields: data_summary, admin_id
│   │
│   ├── Services/
│   │   ├── PropertyService.php ........................... Property retrieval, search, favorites
│   │   ├── AppointmentService.php ........................ Slot management, booking logic
│   │   ├── MessageService.php ............................ Message operations, conversations
│   │   └── UserService.php ............................... User CRUD, role management
│   │
│   └── Providers/
│       └── AppServiceProvider.php
│
├── routes/
│   ├── api.php ............................................ All REST endpoints
│   ├── web.php
│   └── console.php
│
├── database/
│   ├── migrations/ (10 total)
│   │   ├── 0001_01_01_000000 - Users table with roles & license_number
│   │   ├── 0001_01_01_000001 - Cache table
│   │   ├── 0001_01_01_000002 - Jobs queue table
│   │   ├── 2026_03_10_140752 - Properties (price, location, status, agent_id)
│   │   ├── 2026_03_10_140753 - Galleries (property_id, image_urls JSON)
│   │   ├── 2026_03_10_140754 - Calendars (agent_id, available_days JSON)
│   │   ├── 2026_03_10_140754 - Messages (sender_id, receiver_id, timestamp)
│   │   ├── 2026_03_10_140755 - Appointments (date_time, status, buyer/agent/calendar_id)
│   │   ├── 2026_03_10_140755 - Reports (admin_id, data_summary)
│   │   └── 2026_03_10_140810 - property_user pivot (buyer favorites)
│   │
│   ├── factories/
│   │   ├── PropertyFactory.php
│   │   └── UserFactory.php
│   │
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── CsvSeeder.php
│
├── resources/
│   └── views/
│       └── welcome.blade.php
│
├── config/
│   ├── app.php
│   ├── auth.php ......................................... Sanctum API guard
│   ├── database.php ...................................... SQLite configuration
│   ├── cache.php, filesystems.php, logging.php, mail.php, queue.php, session.php, services.php
│
├── storage/ ............................................. Logs, file uploads, cache
├── tests/ ............................................... PHPUnit tests
├── vendor/ .............................................. Composer dependencies
├── .env .................................................. Environment variables
├── composer.json ......................................... PHP dependencies
├── package.json .......................................... Node dependencies (Vite for frontend)
└── artisan ............................................. Laravel CLI
```

---

## 🏢 Database Schema (Backend)

### Entity Relationship Diagram

```
┌─────────────────┐
│     USERS       │ (email unique, role: buyer|agent|admin)
├─────────────────┤
│ id (PK)         │
│ name            │
│ email           │
│ password        │
│ role            │
│ license_number  │◄────────────┐
│ remember_token  │             │
│ timestamps      │             │
└────┬──────────┬─┘             │
     │          │               │
     │1         │1              │ (Agent only)
     │:M        │:1             │
     │          │               │
   ┌─▼──────────▼──────────┐    │
   │   PROPERTIES          │    │
   ├──────────────────────┤    │
   │ id (PK)              │    │
   │ price                │    │
   │ location             │    │
   │ status               │    │
   │ agent_id (FK)────────┼────┘
   │ timestamps           │
   └────┬──────────┬──────┘
        │          │
        │1         │1
        │:M        │:1
        │          │
        │    ┌─────▼──────────┐
        │    │  GALLERIES     │
        │    ├────────────────┤
        │    │ id (PK)        │
        │    │ property_id (FK)
        │    │ image_urls(JSON│
        │    │ timestamps     │
        │    └────────────────┘
        │
        │M:M (property_user pivot for favorites)
        │
   ┌────▼──────────────┐
   │  MESSAGES         │
   ├───────────────────┤
   │ id (PK)           │
   │ content           │
   │ timestamp         │
   │ sender_id (FK)────┼─┐
   │ receiver_id (FK)──┼─┤
   │ timestamps        │ │
   └───────────────────┘ │
                        User referenced twice (sender & receiver)

┌─────────────────┐
│   CALENDARS     │ (For agent availability)
├─────────────────┤
│ id (PK)         │
│ agent_id (FK)───┼──→ User (1:1 relationship)
│ available_days  │    {JSON: ["Monday", "Tuesday"...]}
│ timestamps      │
└────┬────────────┘
     │1
     │:M
     │
   ┌─▼──────────────────┐
   │  APPOINTMENTS      │
   ├────────────────────┤
   │ id (PK)            │
   │ date_time          │
   │ status (string)    │ scheduled|cancelled|completed
   │ buyer_id (FK)──────┼──→ User
   │ agent_id (FK)──────┼──→ User
   │ calendar_id (FK)───┼──→ Calendar
   │ timestamps         │
   └────────────────────┘

┌─────────────────┐
│    REPORTS      │
├─────────────────┤
│ id (PK)         │
│ data_summary    │
│ admin_id (FK)───┼──→ User (admin)
│ timestamps      │
└─────────────────┘
```

### 10 Database Migrations

| File | Purpose |
|------|---------|
| `0001_01_01_000000` | **Users table** - name, email, password, role, license_number |
| `0001_01_01_000001` | Cache table for Laravel caching |
| `0001_01_01_000002` | Jobs queue table |
| `2026_03_10_140752` | **Properties** - price, location, status, agent_id |
| `2026_03_10_140753` | **Galleries** - JSON image URLs per property |
| `2026_03_10_140754` | **Calendars** - Agent availability (available_days JSON) |
| `2026_03_10_140754` | **Messages** - sender_id, receiver_id, content, timestamp |
| `2026_03_10_140755` | **Appointments** - date_time, status, buyer/agent/calendar IDs |
| `2026_03_10_140755` | **Reports** - admin_id, data_summary |
| `2026_03_10_140810` | **property_user** - Pivot table for buyer favorites |

---

## 🛣️ API Routes & Endpoints

### Public Routes (No Authentication)

```
POST   /api/auth/register                 → AuthController@register
POST   /api/auth/login                    → AuthController@login
GET    /api/properties                    → PropertyController@index (paginated)
GET    /api/properties/{id}               → PropertyController@show
GET    /api/properties/search             → PropertyController@search (location, min_price, max_price)
GET    /api/agents                        → UserController@getAgents
```

### Protected Routes (Bearer Token Required)

#### Authentication
```
GET    /api/auth/user                     → Get current authenticated user
POST   /api/auth/logout                   → Invalidate token
```

#### Properties (Full CRUD + Features)
```
POST   /api/properties                    → PropertyController@store (create)
PUT    /api/properties/{id}               → PropertyController@update
DELETE /api/properties/{id}               → PropertyController@destroy
GET    /api/properties/{id}/details       → PropertyController@getDetails
POST   /api/properties/{id}/favorite      → PropertyController@addFavorite
DELETE /api/properties/{id}/favorite      → PropertyController@removeFavorite
GET    /api/favorites                     → PropertyController@getFavorites
GET    /api/properties/agent/{agentId}    → PropertyController@getByAgent
GET    /api/dashboard/stats               → PropertyController@getStatistics
```

#### Appointments (Booking System)
```
GET    /api/appointments                  → AppointmentController@index (user's appointments)
POST   /api/appointments                  → AppointmentController@store
GET    /api/appointments/{id}             → AppointmentController@show
GET    /api/appointments/agent/{agentId}/slots → AppointmentController@getAvailableSlots
POST   /api/appointments/{id}/reschedule  → AppointmentController@reschedule
POST   /api/appointments/{id}/cancel      → AppointmentController@cancel
POST   /api/appointments/{id}/complete    → AppointmentController@complete
```

#### Messages (Messaging System)
```
GET    /api/messages                      → MessageController@index (all)
POST   /api/messages                      → MessageController@store
DELETE /api/messages/{id}                 → MessageController@destroy
GET    /api/messages/conversations        → MessageController@getConversations
GET    /api/messages/conversation/{userId} → MessageController@getConversation
GET    /api/messages/inbox                → MessageController@getInbox
GET    /api/messages/sent                 → MessageController@getSentMessages
```

#### Users (Profile Management)
```
GET    /api/users/{userId}                → UserController@show
POST   /api/users/profile                 → UserController@updateProfile (name, phone, avatar_url)
GET    /api/users/agents                  → UserController@getAgents
```

---

## 🛠️ Core Services (Business Logic Layer)

### 1. PropertyService

**Key Methods:**
- `getProperties(status, perPage)` - Paginated list with agent & gallery relationships
- `getPropertyDetails(id)` - Complete property info
- `searchProperties(location, minPrice, maxPrice, status, perPage)` - Advanced search with price range
- `createProperty(data)` - Validate agent, create property
- *(Additional methods for admin)*

**Features:**
- Status filtering (active, sold, etc.)
- Location-based search with LIKE queries
- Price range filtering
- Relationship eager loading (agent, galleries, buyers)

---

### 2. AppointmentService

**Key Methods:**
- `getAvailableSlots(agentId, date)` - Returns available hours (9 AM - 6 PM)
- `bookAppointment(buyerId, agentId, dateTime)` - Database transaction for booking
- `cancelAppointment(appointmentId, userId)` - With authorization check
- `rescheduleAppointment()` - Change appointment time
- `completeAppointment()` - Mark as completed
- `getAllAppointments(status, perPage)` - Admin view

**Special Logic:**
- **Double-booking prevention** - Checks calendar availability
- **Time slot validation** - 9 AM to 6 PM business hours
- **Authorization checks** - Only buyer/agent can cancel their own
- **Transactional integrity** - Database transactions prevent race conditions

---

### 3. MessageService

**Key Methods:**
- `sendMessage(senderId, receiverId, content)` - Create message record
- `getConversation(userId1, userId2, perPage)` - Bidirectional message history
- `getInbox(userId, perPage)` - Received messages
- `getSentMessages(userId, perPage)` - Sent messages
- `deleteMessage(messageId, userId)` - Security check for ownership
- `getMessageDetails(id)` - Single message info

**Special Logic:**
- **Self-messaging prevention** - Validates senderId ≠ receiverId
- **Content sanitization** - Trims whitespace
- **Ownership verification** - Only sender/receiver can delete
- **Conversation grouping** - Bidirectional queries across sender/receiver fields

---

### 4. UserService

**Key Methods:**
- `getUsers(role, perPage)` - Filter by role (buyer, agent, admin)
- `createUser(data)` - Validate email uniqueness, hash password
- `updateUser(userId, data)` - Selective field updates
- `assignRole(userId, role)` - Change user role
- `deleteUser(userId)` - Cascading deletion

**Features:**
- Email uniqueness validation
- Password hashing with automatic updates
- Transaction-wrapped operations
- Role-based filtering

---

## 📱 SECTION 2: Mobile App Architecture

### Directory Tree Structure

```
mobile-app/app/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php ...................... Login/Register/Logout views & handlers
│   │   │   ├── PropertyController.php .................. Browse, search, details, favorites
│   │   │   ├── AppointmentController.php ............... Book appointments, manage slots
│   │   │   ├── ApiController.php ....................... API endpoint wrapper (minimal)
│   │   │   ├── BookController.php ....................... (Minimal function - unclear)
│   │   │   └── Controller.php (base)
│   │
│   ├── Models/
│   │   └── User.php ................................... Local user cache model
│   │
│   ├── Services/
│   │   ├── ApiService.php .............................. Generic HTTP client
│   │   └── PropertyHubApiService.php ................... Main PropertyHub API consumer
│   │       ├── set_token(token) - Store API token in session
│   │       ├── login(email, password) - API call to backend
│   │       ├── register(...) - API call to backend
│   │       ├── getProperties() - List with pagination
│   │       ├── searchProperties() - Filter & search
│   │       ├── getPropertyDetails() - Full details
│   │       ├── getPropertiesByAgent() - Agent listings
│   │       ├── addToFavorites() - Add to wishlist
│   │       ├── removeFromFavorites() - Remove from wishlist
│   │       ├── getAvailableSlots() - Agent availability
│   │       ├── bookAppointment() - Create appointment
│   │       ├── getAppointments() - User's appointments
│   │       └── [More methods...]
│   │
│   └── Providers/
│
├── routes/
│   ├── web.php ............................................ Web routes for mobile views
│   └── console.php
│
├── database/
│   ├── migrations/ (3 base)
│   │   ├── 0001_01_01_000000 - Users table
│   │   ├── 0001_01_01_000001 - Cache table
│   │   └── 0001_01_01_000002 - Jobs table
│   │
│   ├── factories/
│   │   └── UserFactory.php
│   │
│   └── seeders/
│       └── DatabaseSeeder.php
│
├── resources/
│   └── views/ ............................................. Blade templates (not fully explored)
│
├── nativephp.json .......................................... NativePHP configuration
├── package.json ............................................ Node dependencies
├── vite.config.js .......................................... Vite build config
├── composer.json .......................................... PHP dependencies
└── .env .................................................... Environment (API_URL, etc.)
```

### Mobile Web Routes (Laravel Blade)

```
GET    /                           → Redirect to properties.index
GET    /properties                 → PropertyController@index (list with search/filter)
GET    /properties/{id}            → PropertyController@show (details page)
GET    /properties/agent/{agentId} → PropertyController@byAgent (browse agent listings)
GET    /login                      → AuthController@showLogin
POST   /login                      → AuthController@login
GET    /register                   → AuthController@showRegister
POST   /register                   → AuthController@register
POST   /logout                     → AuthController@logout
GET    /appointments               → AppointmentController@index
GET    /appointments/book/{id}     → AppointmentController@book (booking form)
POST   /appointments/slots         → AppointmentController@getSlots (AJAX)
POST   /appointments               → AppointmentController@store
POST   /appointments/{id}/cancel   → AppointmentController@cancel
```

### PropertyHubApiService (Main API Bridge)

**Configuration:**
```php
$baseUrl = env('PROPERTY_HUB_API_URL', 'http://localhost:8000/api');
$token = session('api_token');  // Stored in PHP session
```

**Authentication Methods:**
- `login(email, password)` - Returns token for session
- `register(name, email, password, confirm, role)` - Create user & get token
- `logout()` - Invalidate on backend

**Property Methods:**
- `getProperties(page, perPage, status)` - Index with pagination
- `getPropertyDetails(propertyId)` - Full property data
- `searchProperties(location, minPrice, maxPrice, status, page, perPage)`
- `getPropertiesByAgent(agentId, page, perPage)`
- `addToFavorites(propertyId)`
- `removeFromFavorites(propertyId)`
- `getFavorites()`
- `getPropertyStatistics()` - Dashboard stats

**Appointment Methods:**
- `getAvailableSlots(agentId, date)` - Available times
- `bookAppointment(agentId, dateTime)`
- `getAppointments()`
- `cancelAppointment(appointmentId)`

**User Methods:**
- `getUserProfile(userId)`
- `getCurrentUser()`

**Message Methods:** (Partially implemented)
- `sendMessage()`
- `getConversations()`

---

## 📊 Implementation Status Matrix

### ✅ FULLY IMPLEMENTED (11 Features)

| Feature | Backend | Mobile | Notes |
|---------|---------|--------|-------|
| **Authentication** | ✅ | ✅ | Sanctum tokens, register/login/logout |
| **Property CRUD** | ✅ | ✅ | Full REST API + mobile views |
| **Property Search** | ✅ | ✅ | Location, price range filtering |
| **Property Gallery** | ✅ | ✅ | JSON image_urls array |
| **Favorites/Wishlist** | ✅ | ✅ | Many-to-many with property_user pivot |
| **Appointment Booking** | ✅ | ✅ | Time slot management, double-booking prevention |
| **Agent Availability** | ✅ | ✅ | Calendar with available_days JSON |
| **Messaging System** | ✅ | ✅ | Send, inbox, outbox, conversations |
| **User Profiles** | ✅ | ✅ | Update name, phone, avatar |
| **User Roles** | ✅ | ⚠️ | buyer, agent, admin - limited in mobile |
| **Agent Listings** | ✅ | ✅ | Browse properties by agent |

### ⚠️ PARTIALLY IMPLEMENTED (8 Features)

| Feature | Status | Notes |
|---------|--------|-------|
| **Admin Dashboard** | 20% | Report model exists, getStatistics() not fully detailed |
| **Mobile Views** | 30% | Controllers exist but Blade templates minimal |
| **Notifications** | 10% | System designed but not wired |
| **Email Notifications** | 0% | Not implemented |
| **File Upload System** | 20% | Using image_urls JSON, no upload endpoints |
| **Real-time Features** | 0% | No WebSocket/Pusher integration |
| **Role-Based Access** | 30% | Basic roles exist, limited middleware enforcement |
| **Pagination** | 80% | Standard Laravel, could optimize with cursor pagination |

### ❌ MISSING / NOT IMPLEMENTED (12+ Features)

| Feature | Reason |
|---------|--------|
| **Payment Integration** | Properties, transactions not modeled |
| **Review & Ratings** | No Review/Rating model |
| **Virtual Tours** | No video/3D tour infrastructure |
| **Two-Factor Auth** | No 2FA model/service |
| **Document Management** | No Document model for legal docs |
| **Inspection Reports** | Not in system |
| **Commission Tracking** | Agent commission system absent |
| **Mortgage Calculator** | Not implemented |
| **Price Negotiations** | No offer/counter-offer system |
| **Caching Layer** | No Redis or query result caching |
| **API Versioning** | Only /api (no /api/v2) |
| **Rate Limiting** | No throttle/rate limit middleware |
| **Search Indexing** | Using basic SQL LIKE (not Elasticsearch) |

---

## 🔑 Key Files Reference

### Backend Critical Files

| File | Purpose | Key Classes/Methods |
|------|---------|-------------------|
| `routes/api.php` | Route definitions | 40+ endpoints |
| `app/Http/Controllers/Api/PropertyController.php` | Property logic | index, show, search, store, destroy |
| `app/Models/Property.php` | Property ORM | Relationships: agent, galleries, buyers |
| `app/Services/PropertyService.php` | Business logic | getProperties, searchProperties, createProperty |
| `database/migrations/2026_03_10_140752_create_properties_table.php` | Property schema | price, location, status, agent_id |
| `database/factories/PropertyFactory.php` | Seeding | Property test data generation |
| `app/Http/Resources/PropertyResource.php` | API transformation | Property JSON formatting |

### Mobile Critical Files

| File | Purpose | Key Methods |
|------|---------|------------|
| `routes/web.php` | Mobile routes | 10+ web routes |
| `app/Http/Controllers/PropertyController.php` | Property views | index, show, byAgent, favorites |
| `app/Services/PropertyHubApiService.php` | API bridge | 20+ wrapper methods |
| `nativephp.json` | NativePHP config | Desktop app setup |

### Configuration Files

| File | Purpose |
|------|---------|
| `.env` | Environment: DB, API_URL, APP_KEY, DEBUG |
| `config/database.php` | SQLite config, connection parameters |
| `config/auth.php` | Sanctum guards & token settings |
| `config/app.php` | Timezone, debug mode, app name |

---

## 🔗 Data Flow Diagrams

### Authentication Flow

```
User Registration/Login
        ↓
[Mobile App] POST /api/auth/register or /api/auth/login
        ↓
[Backend API] AuthController@register or AuthController@login
        ↓
Validates input → Creates/Validates user → Hash password check → Create Sanctum token
        ↓
Returns: {status, data, token}
        ↓
[Mobile App] Stores token in session → Includes in Authorization header for protected endpoints
```

### Property Viewing Flow

```
User browsing properties
        ↓
[Mobile App] GET /properties
        ↓
[PropertyController] Queries PropertyService
        ↓
[PropertyService] SELECT * FROM properties with agent, galleries, buyers
        ↓
Returns paginated collection
        ↓
[Mobile App] Renders via Blade view with PropertyResource transformation
        ↓
Search/filter applied if parameters present (location, min_price, max_price)
```

### Appointment Booking Flow

```
User clicks "Book Appointment"
        ↓
[Mobile] GET /appointments/book/{propertyId} → Show form
        ↓
[Mobile] User selects agent date
        ↓
[Mobile] AJAX POST /appointments/slots?agent_id=X&date=Y-m-d
        ↓
[Backend] AppointmentService@getAvailableSlots
        ↓
Queries Calendar → Checks existed appointments → Returns available hours (9-18)
        ↓
[Mobile] Displays time picker with available slots only
        ↓
[Mobile] POST /appointments with agent_id, date_time
        ↓
[Backend] AppointmentService@bookAppointment
        ↓
Validates → Checks double-booking → Creates appointment → Returns success
        ↓
[Mobile] Redirect to appointments.index with success message
```

---

## 📈 Database Growth Patterns

### Expected Table Sizes (Estimated)

```
users:               10,000 - 100,000  (mixed roles)
properties:          1,000 - 50,000    (active listings)
galleries:           5,000 - 200,000   (avg 5-10 images/property)
messages:            50,000 - 500,000  (high volume)
appointments:        10,000 - 100,000  (historical + current)
property_user:       5,000 - 150,000   (favorites pivot)
calendars:           100 - 5,000       (one per agent)
reports:             100 - 10,000      (admin generated)
```

### Optimization Considerations

- **Index on `properties(status, agent_id)`** for filtering
- **Index on `messages(sender_id, receiver_id, timestamp)`** for conversation queries
- **Index on `appointments(calendar_id, date_time)`** for availability queries
- **Index on `property_user(user_id, property_id)`** for favorite lookups
- **Archive old messages/appointments** to improve query speed

---

## 🚨 Critical Gaps & Risks

### High Priority
1. **No Payment System** - Cannot complete transactions
2. **No Real-time Notifications** - Users unaware of messages/appointments
3. **Limited Admin Dashboard** - Report functionality unclear
4. **No File Upload** - Image URLs must be provided manually
5. **Basic Search** - LIKE queries will be slow at scale

### Medium Priority
1. **No Role-Based Middleware** - Authorization gaps
2. **No 2FA/Security Hardening** - Single password authentication only
3. **No Mobile UI Components** - Views appear minimal
4. **No Caching** - Every query hits database

### Low Priority
1. **No API Versioning** - Hard to evolve API
2. **No Rate Limiting** - Vulnerable to abuse
3. **No Audit Logs** - No action tracking
4. **No Soft Deletes** - Cascading deletes risky

---

## 🎯 Recommended Next Steps

1. **Immediate**: Implement file upload endpoint for property images
2. **Short-term**: Add Laravel Telescope for debugging, implement API rate limiting
3. **Medium-term**: Add payment gateway, notification system, mobile UI components
4. **Long-term**: Implement caching strategy, search indexing, real-time features

---

## 📚 Technical Stack Summary

| Layer | Technology |
|-------|------------|
| **Backend Framework** | Laravel 11 |
| **API Auth** | Laravel Sanctum |
| **Database** | SQLite |
| **Build Tool** | Vite |
| **Mobile Framework** | NativePHP |
| **Package Manager** | Composer (PHP), npm (JS) |
| **Queue System** | Available but not configured |
| **Testing** | PHPUnit |

---

**Document Status:** Complete Inventory  
**Last Updated:** April 3, 2026  
**Files Analyzed:** 50+  
**Controllers:** 10 (5 Backend API + 5 Mobile)  
**Models:** 7 (Backend) + 1 (Mobile cache)  
**Services:** 4 (Backend)  
**API Endpoints:** 40+  
**Database Tables:** 10  

