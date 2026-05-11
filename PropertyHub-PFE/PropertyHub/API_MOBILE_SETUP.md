# PropertyHub API & Mobile App Setup Guide

## 📋 Overview

This document explains the complete API infrastructure and mobile app integration for PropertyHub. The system consists of:
- **Main App**: Laravel backend with REST API
- **Mobile App**: NativePHP Laravel app consuming the API
- **Design System**: PropertyHub color palette applied throughout

---

## 🔌 API Architecture

### System Overview
```
┌─────────────────────────────────────────────────────────────┐
│                    PropertyHub System                        │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  ┌─────────────┐          ┌──────────────┐                  │
│  │ Mobile App  │◄────────►│ Backend API  │                  │
│  │ NativePHP   │ HTTP/    │ (Laravel)    │                  │
│  │ Port: 3000  │ JSON     │ Port: 8000   │                  │
│  └─────────────┘          └──────────────┘                  │
│         │                         │                          │
│         └─────────────┬───────────┘                          │
│                       │                                      │
│         ┌─────────────▼────────────┐                        │
│         │    SQLite Database       │                        │
│         │  (Local Persistence)     │                        │
│         └──────────────────────────┘                        │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

### Base URL
```
http://localhost:8000/api
```

### Authentication Mechanism: Laravel Sanctum

**How it works:**
1. User registers/logs in → receives `API_TOKEN`
2. Token stored in session or local variable
3. Token included in `Authorization: Bearer {token}` header
4. Backend verifies token before granting access
5. Token invalidated on logout

**Token Lifecycle:**
```
Registration/Login → Token Created → Stored Locally → Sent with Requests → Validated → Logout → Token Invalid
```

### API Response Format
All endpoints return JSON with standardized structure:

**Success Response:**
```json
{
  "status": "success",
  "message": "Operation completed",
  "data": { /* actual data */ },
  "meta": { 
    "pagination": {
      "total": 100,
      "per_page": 15,
      "current_page": 1,
      "last_page": 7
    }
  }
}
```

**Error Response:**
```json
{
  "status": "error",
  "message": "Validation failed",
  "errors": {
    "email": ["Email already exists"]
  }
}
```

### HTTP Status Codes Used
- `200 OK` - Successful GET/PUT/PATCH/DELETE
- `201 Created` - Successful POST with resource creation
- `400 Bad Request` - Invalid input data
- `401 Unauthorized` - Missing or invalid token
- `403 Forbidden` - Insufficient permissions
- `404 Not Found` - Resource doesn't exist
- `422 Unprocessable Entity` - Validation error
- `500 Internal Server Error` - Server error

---

## 🛣️ API Endpoints

### Complete Endpoint Reference with Examples

#### POST `/auth/register`
Register a new user
```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password",
    "password_confirmation": "password",
    "role": "buyer"
  }'
```

**Response:**
```json
{
  "status": "success",
  "data": { "id": 1, "name": "John Doe", "email": "john@example.com", "role": "buyer" },
  "token": "1|eyJ..."
}
```

#### POST `/auth/login`
Login with email and password
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password"
  }'
```

#### GET `/auth/user` (Protected)
Get current authenticated user
```bash
curl -H "Authorization: Bearer TOKEN" http://localhost:8000/api/auth/user
```

#### POST `/auth/logout` (Protected)
Logout and invalidate token

---

### Properties

#### GET `/properties`
Get all properties (paginated)
```bash
curl http://localhost:8000/api/properties?page=1&per_page=15&status=active
```

#### GET `/properties?search=/search`
Search properties
```bash
curl "http://localhost:8000/api/properties/search?location=New%20York&min_price=100000&max_price=500000"
```

#### GET `/properties/{id}`
Get specific property details
```bash
curl http://localhost:8000/api/properties/1
```

#### GET `/properties/agent/{agentId}`
Get all properties by specific agent
```bash
curl http://localhost:8000/api/properties/agent/5
```

#### POST `/properties/{id}/favorite` (Protected)
Add property to favorites
```bash
curl -X POST -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/properties/1/favorite
```

#### DELETE `/properties/{id}/favorite` (Protected)
Remove from favorites
```bash
curl -X DELETE -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/properties/1/favorite
```

#### GET `/favorites` (Protected)
Get user's favorite properties
```bash
curl -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/favorites?page=1&per_page=15
```

#### GET `/dashboard/stats`
Get property statistics
```bash
curl http://localhost:8000/api/dashboard/stats
```

---

### Appointments

#### GET `/appointments` (Protected)
Get user's appointments
```bash
curl -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/appointments?status=scheduled
```

#### GET `/appointments/agent/{agentId}/slots`
Get available slots for agent
```bash
curl "http://localhost:8000/api/appointments/agent/1/slots?date=2026-04-15"
```

#### POST `/appointments` (Protected)
Book an appointment
```bash
curl -X POST -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "agent_id": 1,
    "date_time": "2026-04-15 14:00"
  }' \
  http://localhost:8000/api/appointments
```

#### POST `/appointments/{id}/cancel` (Protected)
Cancel appointment
```bash
curl -X POST -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/appointments/1/cancel
```

#### POST `/appointments/{id}/reschedule` (Protected)
Reschedule appointment
```bash
curl -X POST -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"date_time": "2026-04-20 15:00"}' \
  http://localhost:8000/api/appointments/1/reschedule
```

---

### Messages

#### GET `/messages/conversations` (Protected)
Get list of conversations
```bash
curl -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/messages/conversations
```

#### GET `/messages/conversation/{userId}` (Protected)
Get conversation with specific user
```bash
curl -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/messages/conversation/5?page=1&per_page=50
```

#### POST `/messages` (Protected)
Send a message
```bash
curl -X POST -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "receiver_id": 5,
    "content": "Hi, are you interested in this property?"
  }' \
  http://localhost:8000/api/messages
```

#### DELETE `/messages/{id}` (Protected)
Delete a message
```bash
curl -X DELETE -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/messages/1
```

#### GET `/messages/inbox` (Protected)
Get received messages
```bash
curl -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/messages/inbox
```

#### GET `/messages/sent` (Protected)
Get sent messages
```bash
curl -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/messages/sent
```

---

### Users

#### GET `/users/{id}`
Get user profile
```bash
curl http://localhost:8000/api/users/1
```

#### POST `/users/profile` (Protected)
Update user profile
```bash
curl -X POST -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jane Doe",
    "phone": "+1234567890",
    "avatar_url": "https://example.com/avatar.jpg"
  }' \
  http://localhost:8000/api/users/profile
```

#### GET `/agents`
Get all agents
```bash
curl http://localhost:8000/api/agents?page=1&per_page=15
```

---

## 📱 Mobile App Setup

### Project Structure
```
mobile-app/app/
├── app/
│   ├── Http/Controllers/
│   │   ├── PropertyController.php
│   │   ├── AuthController.php
│   │   └── AppointmentController.php
│   ├── Services/
│   │   └── PropertyHubApiService.php
│   └── Models/
├── resources/views/
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── properties/
│   │   ├── index.blade.php
│   │   ├── show.blade.php
│   │   ├── favorites.blade.php
│   │   └── by-agent.blade.php
│   ├── appointments/
│   │   ├── index.blade.php
│   │   └── book.blade.php
│   └── layouts/
│       └── app.blade.php
└── routes/web.php
```

### Configuration

#### 1. Environment Variables
Update `.env` file in mobile app:
```env
PROPERTY_HUB_API_URL=http://localhost:8000/api
API_TIMEOUT=30
CACHE_DRIVER=file
SESSION_DRIVER=file
```

#### 2. PropertyHubApiService
Located at `app/Services/PropertyHubApiService.php`

**Service Methods Reference:**

**Authentication:**
```php
$apiService = new PropertyHubApiService();

// Register new user
$result = $apiService->register('John Doe', 'john@example.com', 'password');
// Returns: ['status' => 'success', 'token' => '1|eyJ...', 'user' => {...}]

// Login
$result = $apiService->login('john@example.com', 'password');
// Returns: ['status' => 'success', 'token' => '1|eyJ...', 'user' => {...}]

// Get current user (requires token)
$apiService->setToken($token);
$user = $apiService->getCurrentUser();

// Logout
$apiService->logout();
```

**Properties:**
```php
// Get all properties (paginated)
$properties = $apiService->getProperties($page = 1, $perPage = 15, $status = 'active');

// Get single property
$property = $apiService->getProperty($id);

// Get properties by agent
$properties = $apiService->getPropertiesByAgent($agentId);

// Search properties
$results = $apiService->searchProperties('New York', $minPrice, $maxPrice);

// Favorites
$apiService->addToFavorites($propertyId);
$apiService->removeFromFavorites($propertyId);
$favorites = $apiService->getFavorites();
```

**Appointments:**
```php
// Get user appointments
$appointments = $apiService->getAppointments($status = 'scheduled');

// Get available slots for agent
$slots = $apiService->getAvailableSlots($agentId, '2026-04-15');

// Book appointment
$appointment = $apiService->bookAppointment($agentId, '2026-04-15 14:00');

// Cancel appointment
$result = $apiService->cancelAppointment($appointmentId);

// Reschedule appointment
$result = $apiService->rescheduleAppointment($appointmentId, '2026-04-20 15:00');
```

**Messages:**
```php
// Get conversations list
$conversations = $apiService->getConversations();

// Get conversation with specific user
$messages = $apiService->getConversation($userId, $page = 1);

// Send message
$message = $apiService->sendMessage($receiverId, 'Hello there!');

// Get inbox
$inbox = $apiService->getInbox();

// Get sent messages
$sent = $apiService->getSentMessages();

// Delete message
$result = $apiService->deleteMessage($messageId);
```

**Dashboard & Agents:**
```php
// Get system stats
$stats = $apiService->getDashboardStats();
// Returns: [
//   'total_properties' => 250,
//   'active_listings' => 180,
//   'total_agents' => 25,
//   'total_users' => 1500
// ]

// Get all agents
$agents = $apiService->getAgents();
```

#### 3. Complete Implementation Example
```php
<?php
// In a controller or service

use App\Services\PropertyHubApiService;

class PropertyController extends Controller
{
    protected $api;
    
    public function __construct()
    {
        $this->api = new PropertyHubApiService();
        
        // Set token from session if available
        if (session('auth_token')) {
            $this->api->setToken(session('auth_token'));
        }
    }
    
    // Browse properties
    public function index()
    {
        $properties = $this->api->getProperties(1, 15);
        return view('properties.index', ['properties' => $properties]);
    }
    
    // Show property details with booking option
    public function show($id)
    {
        $property = $this->api->getProperty($id);
        $agent = $property['agent']; // Agent info included
        $slots = $this->api->getAvailableSlots($agent['id'], date('Y-m-d'));
        
        return view('properties.show', [
            'property' => $property,
            'agent' => $agent,
            'slots' => $slots
        ]);
    }
    
    // Book appointment
    public function bookAppointment(Request $request)
    {
        $result = $this->api->bookAppointment(
            $request->agent_id,
            $request->date_time
        );
        
        return response()->json($result);
    }
}
```

### Mobile App Routes

**Authentication Routes:**
```php
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:sanctum');
```

**Property Routes:**
```php
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/search', [PropertyController::class, 'search'])->name('properties.search');
Route::get('/properties/{id}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/properties/agent/{agentId}', [PropertyController::class, 'byAgent'])->name('properties.by-agent');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/properties/{id}/favorite', [PropertyController::class, 'addFavorite']);
    Route::delete('/properties/{id}/favorite', [PropertyController::class, 'removeFavorite']);
    Route::get('/favorites', [PropertyController::class, 'favorites'])->name('favorites');
});
```

**Appointment Routes:**
```php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::get('/appointments/book/{agentId}', [AppointmentController::class, 'bookForm']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel']);
    Route::post('/appointments/{id}/reschedule', [AppointmentController::class, 'reschedule']);
});

Route::get('/agents', [AppointmentController::class, 'getAgents']);
Route::get('/appointments/agent/{agentId}/slots', [AppointmentController::class, 'getSlots']);
```

**Message Routes:**
```php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/messages/conversations', [MessageController::class, 'conversations']);
    Route::get('/messages/conversation/{userId}', [MessageController::class, 'show']);
    Route::post('/messages', [MessageController::class, 'store']);
    Route::delete('/messages/{id}', [MessageController::class, 'delete']);
    Route::get('/messages/inbox', [MessageController::class, 'inbox']);
    Route::get('/messages/sent', [MessageController::class, 'sent']);
});
```

**Route Summary:**

| Route | Method | Auth | Purpose |
|-------|--------|------|---------|
| `/register` | POST | ❌ | Create new account |
| `/login` | POST | ❌ | Login & get token |
| `/logout` | POST | ✅ | Logout & invalidate token |
| `/profile` | GET | ✅ | Get current user profile |
| `/properties` | GET | ❌ | Browse all properties |
| `/properties/search` | GET | ❌ | Search with filters |
| `/properties/{id}` | GET | ❌ | View property details |
| `/properties/{id}/favorite` | POST | ✅ | Add to favorites |
| `/properties/{id}/favorite` | DELETE | ✅ | Remove from favorites |
| `/favorites` | GET | ✅ | View bookmarked properties |
| `/appointments` | GET | ✅ | View user's appointments |
| `/appointments` | POST | ✅ | Book new appointment |
| `/appointments/{id}/cancel` | POST | ✅ | Cancel appointment |
| `/appointments/{id}/reschedule` | POST | ✅ | Reschedule appointment |
| `/messages/conversations` | GET | ✅ | View all conversations |
| `/messages/conversation/{id}` | GET | ✅ | View conversation thread |
| `/messages` | POST | ✅ | Send message |
| `/messages/{id}` | DELETE | ✅ | Delete message |

---

## 🎨 Design System

### Color Palette
```css
--primary-500: #3b65ad;      /* Deep Slate Blue */
--primary-600: #2d4f8e;      /* Darker blue */
--secondary-500: #029fcaff;  /* Vibrant Cyan */
--slate-50: #f8fafc;         /* Light background */
--slate-950: #0f172a;        /* Dark text */
```

### Typography
- **Font**: Inter (Google Fonts)
- **Heading**: Bold (600-700 weight)
- **Body**: Regular (400-500 weight)

### Components
- **Border Radius**: 12px (rounded-xl)
- **Button Height**: 40px (py-2.5 px-4)
- **Shadow**: `shadow-sm` for cards, `shadow-lg` for overlays
- **Button Styles**:
  - Primary: Blue background, white text, rounded corners
  - Secondary: White background, blue border, blue text

### Responsive Breakpoints
- Mobile: Default (< 640px)
- Tablet: `md:` (≥ 768px)
- Desktop: `lg:` (≥ 1024px)

---

## 🔄 Data Flow

### User Journey: Browse & Book

```
1. User opens mobile app
   ↓
2. Views properties (GET /properties)
   ↓
3. Searches or filters
   ↓
4. Clicks property -> Views details (GET /properties/{id})
   ↓
5. Clicks "Book Appointment"
   ↓
6. Logs in if needed (POST /auth/login)
   ↓
7. Views available slots (GET /appointments/agent/{id}/slots)
   ↓
8. Confirms booking (POST /appointments)
   ↓
9. Appointment confirmed
```

### Authentication Flow

```
1. User registers (POST /auth/register)
2. Receives API token
3. Token stored in session
4. Included in all protected requests
5. Token expires on logout (POST /auth/logout)
```

---

## 🚀 Running the Application

### Backend (Main App)
```bash
cd C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub

# Start Laravel server
php artisan serve

# Start Vite dev server (in another terminal)
npm run dev
```
Access at: `http://localhost:8000`

### Mobile App
```bash
cd C:\GitHub\PropertyHub-PFE\mobile-app\app

# Start dev server
npm run dev

# Or with NativePHP
npm run dev
```

---

## 📊 Database Schema & Models

### Complete Database Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                   PropertyHub Database Schema                    │
├─────────────────────────────────────────────────────────────────┤

┌────────────────────────────┐
│ users                      │
├────────────────────────────┤
│ id (PK)                    │
│ name                       │
│ email (UNIQUE)             │
│ password                   │
│ role (buyer|agent|admin)   │
│ license_number (nullable)  │ ← Agents only
│ avatar_url                 │
│ phone                      │
│ created_at, updated_at     │
└────────┬───────────────────┘
         │
    ┌────┴─────┬─────────────┬─────────────┐
    │           │             │             │
┌───▼────────────────────┐ ┌──▼──────────────────┐ ┌──▼──────────────────┐
│ properties             │ │ appointments       │ │ messages            │
├────────────────────────┤ ├────────────────────┤ ├─────────────────────┤
│ id (PK)                │ │ id (PK)            │ │ id (PK)             │
│ agent_id (FK→users)    │ │ buyer_id (FK)      │ │ sender_id (FK)      │
│ title                  │ │ agent_id (FK)      │ │ receiver_id (FK)    │
│ price                  │ │ date_time          │ │ content             │
│ location               │ │ status             │ │ timestamp           │
│ description            │ │ calendar_id (FK)   │ │ created_at          │
│ status (active|sold)   │ │ created_at         │ │ updated_at          │
│ created_at, updated_at │ └────────────────────┘ └─────────────────────┘
└────┬────────────────────┘
     │
     ├─►┌────────────────────┐
     │  │ galleries          │
     │  ├────────────────────┤
     │  │ id (PK)            │
     │  │ property_id (FK)   │
     │  │ image_urls (JSON)  │
     │  │ created_at         │
     │  └────────────────────┘
     │
     └─►┌────────────────────┐
        │ property_user      │ ← Favorites pivot
        ├────────────────────┤
        │ user_id (FK)       │
        │ property_id (FK)   │
        │ created_at         │
        └────────────────────┘

┌────────────────────────────┐      ┌────────────────────────────┐
│ calendars                  │      │ reports                    │
├────────────────────────────┤      ├────────────────────────────┤
│ id (PK)                    │      │ id (PK)                    │
│ agent_id (FK→users)        │      │ admin_id (FK→users)        │
│ available_days (JSON)      │      │ title                      │
│ available_hours (JSON)     │      │ data_summary (JSON)        │
│ created_at, updated_at     │      │ period (month|year)        │
└────────────────────────────┘      │ created_at                 │
                                    └────────────────────────────┘
```

### Model Relationships (Laravel)

```php
// User Model
class User extends Model {
    // As agent
    public function properties() { return $this->hasMany(Property::class, 'agent_id'); }
    public function appointments() { return $this->hasMany(Appointment::class, 'agent_id'); }
    public function calendar() { return $this->hasOne(Calendar::class, 'agent_id'); }
    
    // As buyer
    public function favoriteProperties() { return $this->belongsToMany(Property::class); }
    
    // Messaging
    public function sentMessages() { return $this->hasMany(Message::class, 'sender_id'); }
    public function receivedMessages() { return $this->hasMany(Message::class, 'receiver_id'); }
}

// Property Model
class Property extends Model {
    public function agent() { return $this->belongsTo(User::class, 'agent_id'); }
    public function galleries() { return $this->hasMany(Gallery::class); }
    public function appointments() { return $this->hasMany(Appointment::class); }
    public function buyers() { return $this->belongsToMany(User::class); } // Favorites
}

// Appointment Model
class Appointment extends Model {
    public function buyer() { return $this->belongsTo(User::class, 'buyer_id'); }
    public function agent() { return $this->belongsTo(User::class, 'agent_id'); }
    public function calendar() { return $this->belongsTo(Calendar::class); }
}

// Message Model
class Message extends Model {
    public function sender() { return $this->belongsTo(User::class, 'sender_id'); }
    public function receiver() { return $this->belongsTo(User::class, 'receiver_id'); }
}
```

---

## ⚙️ Installation & Setup Instructions

### Step 1: Clone and Navigate
```bash
# Clone/navigate to backend
cd C:\GitHub\PropertyHub-PFE\PropertyHub-PFE\PropertyHub

# Install PHP dependencies
composer install
```

### Step 2: Environment Configuration
```bash
# Copy example env file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create database file
touch database/database.sqlite
chmod 664 database/database.sqlite
chmod 775 database/
```

### Step 3: Database Initialization
```bash
# Run migrations (creates all tables)
php artisan migrate

# Seed sample data (optional - creates test data)
php artisan db:seed

# Or refresh (clear + migrate + seed)
php artisan migrate:fresh --seed
```

### Step 4: Start Backend Server
```bash
# Terminal 1: Laravel development server (port 8000)
php artisan serve

# Terminal 2: Vite asset compilation (in same directory)
npm run dev
```

### Step 5: Setup Mobile App
```bash
# Navigate to mobile app
cd C:\GitHub\PropertyHub-PFE\mobile-app\app

# Install dependencies
npm install

# Configure environment
echo 'PROPERTY_HUB_API_URL=http://localhost:8000/api' > .env

# Start mobile app (port 3000)
npm run dev
```

### Verification Checklist
- [ ] Backend running on `http://localhost:8000`
- [ ] Mobile app running on `http://localhost:3000`
- [ ] API responds to GET `/api/properties`
- [ ] Can register new user via POST `/api/auth/register`
- [ ] Receive API token on registration
- [ ] Can login with POST `/api/auth/login`

---

---

## 🔐 Security Best Practices

1. **API Token**: Never expose in frontend code
2. **CORS**: Configure if mobile app on different domain
3. **Rate Limiting**: Implement on API endpoints
4. **Input Validation**: All POST/PUT data validated
5. **Authorization**: Check user role/permissions before action

---

---

## 🔧 Complete Environmental Setup

### Backend Environment (.env)
```env
APP_NAME=PropertyHub
APP_ENV=development
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=/path/to/database.sqlite

SANCTUM_STATEFUL_DOMAINS=localhost,localhost:3000,127.0.0.1:3000
SESSION_DOMAIN=localhost

MAIL_MAILER=log
BROADCAST_DRIVER=log
QUEUE_CONNECTION=database
SESSION_DRIVER=database

CORS_ALLOWED_ORIGINS=http://localhost:3000,http://127.0.0.1:3000
```

### Mobile App Environment (.env)
```env
APP_NAME=PropertyHub-Mobile
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:3000

PROPERTY_HUB_API_URL=http://localhost:8000/api
API_TIMEOUT=30

CACHE_DRIVER=file
SESSION_DRIVER=file
```

### Database Setup (Backend)
```bash
cd PropertyHub-PFE/PropertyHub

# Generate app key
php artisan key:generate

# Create SQLite database
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed sample data (optional)
php artisan db:seed
```

---

## 🛠️ Quick Integration Checklist

### ✅ Pre-Launch Verification

**Backend (Main App)**:
- [ ] Database migrations completed (`php artisan migrate`)
- [ ] Sanctum token guards configured in `config/auth.php`
- [ ] CORS middleware enabled in `app/Http/Middleware/HandleCors.php`
- [ ] API routes registered in `routes/api.php`
- [ ] Services working (`php artisan test`)
- [ ] Development server running on port 8000

**Mobile App**:
- [ ] `.env` file configured with correct `PROPERTY_HUB_API_URL`
- [ ] PropertyHubApiService initialized and tested
- [ ] Blade views for all feature routes
- [ ] Authentication guard middleware applied to protected routes
- [ ] CSS/Tailwind compiled (run `npm run build`)

---

## 🧪 Testing the Integration

### Test Authentication Flow
```bash
# Register new user
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "role": "buyer"
  }'

# Response will include your API token
# Copy the token for next steps
```

### Test Protected Endpoint
```bash
# Get current user (replace TOKEN with actual token)
curl -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/auth/user
```

### Test Properties Endpoint
```bash
# Get all properties
curl http://localhost:8000/api/properties?page=1&per_page=15

# Search properties
curl "http://localhost:8000/api/properties/search?location=New%20York&min_price=100000&max_price=500000"
```

---

## 🎯 Complete User Workflows

### Workflow 1: Browse & Bookmark Properties (Buyer)

```
1. Mobile App homepage loads → GET /properties
2. User sees property list → Display with PropertyResource
3. User clicks property → GET /properties/{id}
4. User bookmarks → POST /properties/{id}/favorite (protected)
5. User views bookmarks → GET /favorites (protected)
```

**Testing:**
```bash
# Add to favorites
curl -X POST -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/properties/1/favorite

# Get favorites
curl -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/favorites?page=1
```

---

### Workflow 2: Book Appointment (Buyer + Agent)

```
1. User clicks "Book Appointment" on property
2. System shows agent info → GET /agents/{agentId}
3. User selects date → GET /appointments/agent/{agentId}/slots?date=2026-04-15
4. User confirms booking → POST /appointments (protected)
5. Appointment confirmed → Database creates entry + Status: scheduled
6. Agent can view appointments → GET /appointments?status=scheduled
```

**Testing:**
```bash
# Get available slots for agent 1 on April 15, 2026
curl "http://localhost:8000/api/appointments/agent/1/slots?date=2026-04-15"

# Book appointment (as buyer)
curl -X POST -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "agent_id": 1,
    "date_time": "2026-04-15 14:00"
  }' \
  http://localhost:8000/api/appointments
```

---

### Workflow 3: Send Messages (Any Role)

```
1. User opens conversations → GET /messages/conversations
2. User clicks conversation → GET /messages/conversation/{userId}
3. User types message → POST /messages (protected)
4. Message delivered → Real-time polling or WebSocket
5. User can delete → DELETE /messages/{id} (protected)
```

**Testing:**
```bash
# Send message
curl -X POST -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "receiver_id": 2,
    "content": "Interested in this property!"
  }' \
  http://localhost:8000/api/messages

# Get conversations
curl -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/messages/conversations
```

---

## 🔐 Key Security Features to Verify

### 1. Token-Based Authentication
- Sanctum tokens issued on login/register
- Tokens expire when user logs out
- Each protected endpoint verifies token validity

### 2. Authorization Checks
- Users can only view their own appointments/messages
- Agents can only manage their own properties
- Admin endpoints check role == 'admin'

### 3. Input Validation
- Email uniqueness enforced at DB level
- Price/dates validated before storage
- Message content sanitized

### 4. CORS Configuration
Verify in `config/cors.php`:
```php
'allowed_origins' => ['http://localhost:3000', 'http://127.0.0.1:3000'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'exposed_headers' => [],
'max_age' => 0,
'supports_credentials' => true,
```

---

## 📱 Mobile App Views Implementation

### Essential Views to Create
All should be in `resources/views/`:

```
auth/login.blade.php          → Login form
auth/register.blade.php       → Registration form
properties/index.blade.php    → Property listing
properties/show.blade.php     → Property details + Book button
favorites/index.blade.php     → Bookmarked properties
appointments/index.blade.php  → User appointments
appointments/book.blade.php   → Appointment booking form
messages/index.blade.php      → Conversation list
messages/show.blade.php       → Single conversation + message form
layouts/app.blade.php         → Main layout with navbar
```

### Example View Structure (Blade)
```blade
{{-- resources/views/properties/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Properties</h1>
    
    @foreach($properties as $property)
        <div class="property-card">
            <h2>{{ $property['title'] }}</h2>
            <p>{{ $property['location'] }}</p>
            <p class="price">${{ number_format($property['price']) }}</p>
            <a href="/properties/{{ $property['id'] }}">View Details</a>
        </div>
    @endforeach
    
    {{ $properties->links() }}
</div>
@endsection
```

---

## 🚀 Production Deployment

### Before Going Live

1. **Backend**:
   - [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
   - [ ] Generate strong `APP_KEY`
   - [ ] Configure real database (PostgreSQL recommended)
   - [ ] Set up SSL/HTTPS
   - [ ] Configure proper email driver
   - [ ] Enable rate limiting on API endpoints
   - [ ] Set up proper logging

2. **Mobile App**:
   - [ ] Point `PROPERTY_HUB_API_URL` to production domain
   - [ ] Build for production: `npm run build`
   - [ ] Enable cache headers
   - [ ] Test all workflows end-to-end

3. **Database**:
   - [ ] Backup production database regularly
   - [ ] Run migrations on production: `php artisan migrate --force`
   - [ ] Monitor database growth

---

## 🐛 Troubleshooting

### Issue: API returns 401 Unauthorized
**Cause:** Missing or invalid token
**Solution:**
- Check token is included in Authorization header: `Authorization: Bearer {token}`
- Verify token hasn't expired (re-login to get new token)
- Check `SANCTUM_STATEFUL_DOMAINS` in `.env` matches your domain

### Issue: CORS errors in browser console
**Cause:** Cross-origin request blocked
**Solution:**
```php
// In config/cors.php, ensure:
'allowed_origins' => ['http://localhost:3000'],
'supports_credentials' => true,
```

### Issue: Mobile app can't connect to API
**Cause:** Incorrect URL or servers not running
**Solution:**
```bash
# Verify backend is running on port 8000
lsof -i :8000

# Verify PROPERTY_HUB_API_URL in mobile app .env
cat mobile-app/app/.env | grep PROPERTY_HUB_API_URL

# Test connectivity
curl http://localhost:8000/api/health
```

### Issue: Database errors on migration
**Cause:** Missing SQLite file or permissions
**Solution:**
```bash
# Create database file
touch database/database.sqlite

# Fix permissions
chmod 664 database/database.sqlite
chmod 775 database/

# Run migrations
php artisan migrate:fresh --seed
```

### Issue: NativePHP app won't start
**Cause:** Dependencies or configuration issue
**Solution:**
```bash
cd mobile-app/app
rm -rf node_modules package-lock.json
npm install
npm run dev
```

---

## 📊 Testing Endpoints Systematically

### Test Suite Script
```bash
#!/bin/bash
# save as test-api.sh

BASE_URL="http://localhost:8000/api"

echo "Testing PropertyHub API..."

# 1. Register user
echo "1. Registering user..."
REGISTER=$(curl -s -X POST $BASE_URL/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test-'$(date +%s)'@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "role": "buyer"
  }')

TOKEN=$(echo $REGISTER | jq -r '.token')
echo "Token: $TOKEN"

# 2. Get properties
echo "2. Getting properties..."
curl -s $BASE_URL/properties | jq '.data | length'

# 3. Get user profile
echo "3. Getting user profile..."
curl -s -H "Authorization: Bearer $TOKEN" $BASE_URL/auth/user | jq '.data.name'

# 4. Search properties
echo "4. Searching properties..."
curl -s "$BASE_URL/properties/search?location=new%20york" | jq '.data | length'

# 5. Book appointment
echo "5. Booking appointment..."
curl -s -X POST -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"agent_id": 1, "date_time": "2026-04-15 14:00"}' \
  $BASE_URL/appointments | jq '.status'

echo "✅ API testing complete!"
```

---

## 📚 Master API Reference

| Feature | Endpoint | Method | Auth | Status |
|---------|----------|--------|------|--------|
| Register | `/auth/register` | POST | ❌ | ✅ |
| Login | `/auth/login` | POST | ❌ | ✅ |
| Get User | `/auth/user` | GET | ✅ | ✅ |
| Logout | `/auth/logout` | POST | ✅ | ✅ |
| Get Properties | `/properties` | GET | ❌ | ✅ |
| Search Properties | `/properties/search` | GET | ❌ | ✅ |
| Get Property | `/properties/{id}` | GET | ❌ | ✅ |
| Add Favorite | `/properties/{id}/favorite` | POST | ✅ | ✅ |
| Remove Favorite | `/properties/{id}/favorite` | DELETE | ✅ | ✅ |
| Get Favorites | `/favorites` | GET | ✅ | ✅ |
| Get Appointments | `/appointments` | GET | ✅ | ✅ |
| Get Slots | `/appointments/agent/{id}/slots` | GET | ❌ | ✅ |
| Book Appointment | `/appointments` | POST | ✅ | ✅ |
| Cancel Appointment | `/appointments/{id}/cancel` | POST | ✅ | ✅ |
| Reschedule Appointment | `/appointments/{id}/reschedule` | POST | ✅ | ✅ |
| Get Conversations | `/messages/conversations` | GET | ✅ | ✅ |
| Get Conversation | `/messages/conversation/{id}` | GET | ✅ | ✅ |
| Send Message | `/messages` | POST | ✅ | ✅ |
| Delete Message | `/messages/{id}` | DELETE | ✅ | ✅ |
| Get Inbox | `/messages/inbox` | GET | ✅ | ✅ |
| Get Sent | `/messages/sent` | GET | ✅ | ✅ |
| Get Agents | `/agents` | GET | ❌ | ✅ |
| Get Dashboard Stats | `/dashboard/stats` | GET | ❌ | ✅ |

---

## 🎓 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Sanctum API Authentication](https://laravel.com/docs/sanctum)
- [NativePHP Docs](https://nativephp.com)
- [Tailwind CSS](https://tailwindcss.com)
- [PropertyHub Codebase Index](../../CODEBASE_STRUCTURE_INVENTORY.md)
- [Services Documentation](./SERVICES.md)

---

**Last Updated**: April 3, 2026
**Version**: 2.0 (Production Ready)
**Status**: ✅ Complete & Functional
