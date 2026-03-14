# 🛠️ PropertyHub Services Documentation

This document explains the architecture and logic of the core services implemented in the PropertyHub project. These services encapsulate the business logic, ensuring a clean separation from controllers and models.

---

## 🏗️ Core Services Overview

### PUBLIC SERVICES

These services handle operations available to public users (buyers and agents on the public side).

#### 1. [PropertyService](app/Services/Public/PropertyService.php)
Manages property browsing, search, and favorite functionality for public users.

**Key Functions:**
- **Browse Properties:** `getAllActiveProperties()` - Get paginated list of active properties with galleries and agent details
- **Property Details:** `getPropertyDetails(int $id)` - Retrieve complete property information
- **Advanced Search:** `searchProperties(location, minPrice, maxPrice)` - Filter properties by location and price range
- **Agent Listings:** `getPropertiesByAgent(int $agentId)` - View all properties listed by a specific agent
- **Favorites Management:**
  - `addToFavorites()` - Add property to buyer's wishlist
  - `removeFromFavorites()` - Remove from wishlist
  - `isFavorited()` - Check if property is favorited
  - `getBuyerFavorites()` - Get all favorited properties

**Special Logic:**
- Duplicate favorites are prevented through existence checks
- Only active properties are shown in public listings
- Relationships include agent and gallery data for complete display

---

#### 2. [AppointmentService](app/Services/Public/AppointmentService.php)
Handles appointment booking, scheduling, and management.

**Key Functions:**
- **Availability:** `getAvailableSlots(int $agentId, string $date)` - Get open time slots for an agent
- **Booking:** `bookAppointment(buyer_id, agent_id, dateTime)` - Reserve an appointment slot
- **Management:**
  - `cancelAppointment()` - Cancel an existing appointment
  - `rescheduleAppointment()` - Move appointment to new time
  - `completeAppointment()` - Mark as completed
- **Retrieval:**
  - `getUserAppointments()` - Get user's appointments with optional status filter
  - `getAppointmentDetails()` - Retrieve full appointment info

**Special Logic:**
- **Data Integrity:** Database transactions prevent double-booking of time slots
- **Authorization:** Only buyer or agent can cancel/reschedule their own appointments
- **Business Hours:** Available slots are 9 AM to 6 PM (9-hour blocks)
- **Conflict Prevention:** System checks for slot availability before confirming booking

---

#### 3. [MessageService](app/Services/Public/MessageService.php)
Manages direct messaging between users (agents, buyers, admins).

**Key Functions:**
- **Communication:**
  - `sendMessage()` - Send message from one user to another
  - `deleteMessage()` - Delete message (sender or receiver only)
- **Conversation View:**
  - `getConversation()` - Get all messages between two users
  - `getRecentConversations()` - Get recent chat partners (last message with each)
- **Mailbox Operations:**
  - `getInbox()` - Received messages
  - `getSentMessages()` - Sent messages
- **Utilities:**
  - `getMessageDetails()` - Single message info
  - `countUnreadMessages()` - Message count (extensible for read flags)

**Special Logic:**
- **Content Sanitization:** Message content is trimmed of whitespace
- **Self-Messaging Prevention:** Users cannot message themselves
- **Authorization:** Only sender or receiver can delete messages
- **Conversation Grouping:** Bidirectional messages are grouped together

---

#### 4. [GalleryService](app/Services/Public/GalleryService.php)
Manages property image galleries and media display.

**Key Functions:**
- **Image Retrieval:**
  - `getPropertyGallery()` - Get all images for a property
  - `getPropertyThumbnail()` - Get first image (preview)
  - `getGalleryDetails()` - Get single gallery item
- **Image Statistics:**
  - `countPropertyImages()` - Count total images
  - `hasImages()` - Check if property has images

**Special Logic:**
- **Flexible Storage:** Handles image_urls as JSON arrays in database
- **Thumbnail Generation:** Automatically returns first image as thumbnail
- **Empty States:** Returns null for properties without images

---

### ADMIN SERVICES

These services provide administrative operations for system management.

#### 5. [AdminPropertyService](app/Services/Admin/AdminPropertyService.php)
Comprehensive property management for administrators.

**Key Functions:**
- **CRUD Operations:**
  - `createProperty()` - Create new property (with agent validation)
  - `updateProperty()` - Modify property details
  - `deleteProperty()` - Remove property from system
- **Retrieval:**
  - `getAllProperties()` - All properties with pagination
  - `getPropertiesByStatus()` - Filter by status (active, pending, sold)
  - `getPropertyDetails()` - Complete property info
- **Advanced Filtering:**
  - `searchByLocation()` - Find properties by location
  - `filterByPriceRange()` - Get properties in price bracket
  - `getPropertiesByAgent()` - Properties assigned to agent
- **Bulk Operations:**
  - `bulkUpdateStatus()` - Change status for multiple properties
- **Analytics:**
  - `getPropertyStatistics()` - Total, active, sold counts; pricing analytics

**Special Logic:**
- **Data Integrity:** Only users with 'agent' role can be assigned as property agent
- **Agent Validation:** System verifies agent exists and has proper role before assignment
- **Statistics:** Provides comprehensive metrics (count, avg price, min/max price)

---

#### 6. [AdminAppointmentService](app/Services/Admin/AdminAppointmentService.php)
System-wide appointment management and oversight.

**Key Functions:**
- **Retrieval:**
  - `getAllAppointments()` - All appointments with full details
  - `getAppointmentsByStatus()` - Filter by status
  - `getAgentAppointments()` - View specific agent's appointments
  - `getBuyerAppointments()` - View buyer's appointment history
  - `getAppointmentDetails()` - Single appointment info
- **Appointment Control:**
  - `updateAppointmentStatus()` - Change appointment status
  - `cancelAppointments()` - Bulk cancellation
  - `deleteAppointment()` - Remove appointment record
  - `getTodayAppointments()` - Today's schedule
- **Analytics:**
  - `getAppointmentStatistics()` - Status breakdown, completion rates
  - `getAppointmentsByDateRange()` - Historical queries

**Special Logic:**
- **Status Validation:** Only accepts valid statuses (scheduled, completed, cancelled, no-show)
- **Date Range Queries:** Supports historical appointment analysis
- **Real-time Views:** Today's appointments ordered chronologically

---

#### 7. [AdminUserService](app/Services/Admin/AdminUserService.php)
User account management and role assignment.

**Key Functions:**
- **User Management:**
  - `createUser()` - Create new account (with role assignment)
  - `updateUser()` - Edit user information
  - `deleteUser()` - Remove user (with integrity checks)
  - `resetPassword()` - Admin password reset
- **Retrieval:**
  - `getAllUsers()` - All users with relationships
  - `getUsersByRole()` - Filter by role (admin, agent, buyer)
  - `getAllAgents()` - Get all agents
  - `getAllBuyers()` - Get all buyers
  - `getUserDetails()` - Complete user profile
- **Search & Analytics:**
  - `searchUsers()` - Find by name or email
  - `getUserStatistics()` - Role distribution counts
  - `assignRole()` - Change user role

**Special Logic:**
- **Unique Email Constraint:** Prevents duplicate email addresses
- **Role Validation:** Only accepts valid roles (admin, agent, buyer)
- **Password Security:** Passwords are automatically hashed using Laravel's Hash facade
- **Data Protection:** Prevents deletion of users with active appointments or properties
- **Cascade Protection:** Ensures data integrity before user removal

---

#### 8. [AdminReportService](app/Services/Admin/AdminReportService.php)
System reporting and data export management.

**Key Functions:**
- **Report CRUD:**
  - `createReport()` - Generate new report (admin only)
  - `updateReport()` - Edit report data
  - `deleteReport()` - Remove report
- **Retrieval:**
  - `getAllReports()` - All reports with pagination
  - `getReportsByAdmin()` - Reports created by specific admin
  - `getReportDetails()` - Single report info
- **Analytics:**
  - `getRecentReports()` - Latest reports
  - `getReportCount()` - Total report count
  - `searchReports()` - Find by keyword in data summary

**Special Logic:**
- **Admin Verification:** Only users with 'admin' role can create reports
- **Timestamp Tracking:** Automatically records creation/update times

---

#### 9. [AdminDashboardService](app/Services/Admin/AdminDashboardService.php)
High-level metrics and dashboard data aggregation.

**Key Functions:**
- **Overview:**
  - `getDashboardOverview()` - Key metrics at a glance
  - `getSystemHealth()` - System operational status
- **Detailed Metrics:**
  - `getPropertyStats()` - Properties by status, pricing
  - `getAppointmentStats()` - Appointments by status
  - `getUserStats()` - User distribution by role
- **Real-time Data:**
  - `getRecentProperties()` - Latest added properties
  - `getRecentAppointments()` - Latest appointments
  - `getUpcomingAppointments()` - Scheduled for future
  - `getRecentUsers()` - New user registrations
  - `getTopAgents()` - Agents by property count
- **Activity Trends:**
  - `getActivitySummary()` - Last 30 days activity
  - `getAgentPropertyDistribution()` - Properties per agent

**Special Logic:**
- **Time-based Queries:** Separate historical (past) from upcoming (future) data
- **Aggregation:** Combines counts from multiple models for overview
- **Performance:** Uses count() and aggregate functions efficiently
- **Agent Ranking:** Orders by property count for top performer identification

---

#### 10. [AdminCalendarService](app/Services/Admin/AdminCalendarService.php)
Calendar and scheduling management for agents.

**Key Functions:**
- **Calendar Management:**
  - `createCalendarForAgent()` - Set up agent's calendar
  - `deleteCalendar()` - Remove calendar (with safeguards)
- **Retrieval:**
  - `getAllCalendars()` - All agent calendars
  - `getAgentCalendar()` - Specific agent's calendar
  - `getCalendarDetails()` - Complete calendar info
- **Appointment Viewing:**
  - `getCalendarWithAppointments()` - Calendar + all appointments
  - `getCalendarAppointmentsByDateRange()` - Appointments in period
- **Utilities:**
  - `agentHasCalendar()` - Check calendar existence
  - `getCalendarStatistics()` - Calendar count metrics

**Special Logic:**
- **One-to-One Relationship:** Each agent can have only one calendar
- **Deletion Protection:** Prevents deletion if calendar has appointments
- **Agent Validation:** Only creates calendars for users with 'agent' role
- **Cascade Safety:** Ensures no orphaned appointments when managing calendars

---

## ✅ Best Practices Applied

### 1. **Single Responsibility Principle**
Each service focuses on a specific domain (Properties, Appointments, Users, etc.)

### 2. **Database Transactions**
Used in create/update operations to ensure data consistency:
- Prevents double-booking in appointments
- Ensures atomic user creation with role assignment
- Maintains referential integrity

### 3. **Authorization Checks**
Services validate user roles and relationships:
- Only admins create reports
- Only agents can have calendars
- Only sender/receiver can delete messages

### 4. **Data Integrity Constraints**
Business rules are enforced at service level:
- Prevents deletion of agents with active properties
- Prevents deletion of calendars with appointments
- Prevents duplicate favorite entries

### 5. **Pagination for Large Datasets**
All retrieval operations support pagination to optimize performance:
```php
$result = $service->getAllProperties(15); // 15 items per page
```

### 6. **Error Handling**
Meaningful exceptions for invalid operations:
```php
throw new \Exception("Email already exists.");
throw new \Exception("Cannot delete user with active appointments.");
```

### 7. **Convention over Configuration**
Follows Laravel naming conventions:
- Relationship method names match model definitions
- Table names follow pluralization rules
- Service naming follows pattern: `{Domain}Service` or `Admin{Domain}Service`

---

## 📊 Service Relationship Map

```
PropertyHub Services Architecture
│
├─ PUBLIC SERVICES (User-facing)
│  ├─ PropertyService
│  │  └─ Relationships: Property, User (agent, buyer), Gallery
│  ├─ AppointmentService
│  │  └─ Relationships: Appointment, Calendar, User (buyer, agent)
│  ├─ MessageService
│  │  └─ Relationships: Message, User
│  └─ GalleryService
│     └─ Relationships: Gallery, Property
│
└─ ADMIN SERVICES (Administrative)
   ├─ AdminPropertyService
   │  └─ Relationships: Property, User (agent), Gallery
   ├─ AdminAppointmentService
   │  └─ Relationships: Appointment, Calendar, User
   ├─ AdminUserService
   │  └─ Relationships: User, Property, Appointment, Calendar
   ├─ AdminReportService
   │  └─ Relationships: Report, User (admin)
   ├─ AdminDashboardService
   │  └─ Relationships: Property, Appointment, User (aggregated)
   └─ AdminCalendarService
      └─ Relationships: Calendar, Appointment, User (agent)
```

---

## 🧪 Unit Testing

All services include comprehensive unit tests covering:
- **Happy Path:** Normal operations work correctly
- **Edge Cases:** Boundary conditions and data limits
- **Error Handling:** Exceptions thrown appropriately
- **Business Logic:** Domain rules are enforced
- **Authorization:** Only authorized users can perform actions

### Test Structure:
```
tests/Unit/Services/
├── Public/
│  ├── PropertyServiceTest.php
│  ├── AppointmentServiceTest.php
│  ├── MessageServiceTest.php
│  └── GalleryServiceTest.php
└── Admin/
   ├── AdminPropertyServiceTest.php
   ├── AdminAppointmentServiceTest.php
   ├── AdminUserServiceTest.php
   ├── AdminReportServiceTest.php
   ├── AdminDashboardServiceTest.php
   └── AdminCalendarServiceTest.php
```

### Running Tests:
```bash
# Run all service tests
php artisan test tests/Unit/Services

# Run specific service test
php artisan test tests/Unit/Services/Public/PropertyServiceTest

# Run with coverage
php artisan test --coverage tests/Unit/Services
```

---

## 🚀 Usage Example

### Creating a Property (Admin)
```php
$adminPropertyService = new AdminPropertyService();

$property = $adminPropertyService->createProperty([
    'price' => 250000,
    'location' => 'Manhattan, New York',
    'status' => 'active',
    'agent_id' => 5,
]);
```

### Booking an Appointment (Public)
```php
$appointmentService = new AppointmentService();

// First, check available slots
$slots = $appointmentService->getAvailableSlots($agent_id, '2026-03-20');

// Then book
$appointment = $appointmentService->bookAppointment(
    $buyer_id,
    $agent_id,
    '2026-03-20 14:00'
);
```

### Dashboard Overview (Admin)
```php
$dashboardService = new AdminDashboardService();

$overview = $dashboardService->getDashboardOverview();
// Returns: [
//     'total_properties' => 45,
//     'active_properties' => 32,
//     'total_appointments' => 128,
//     'scheduled_appointments' => 45,
//     ...
// ]
```

---

## 📝 Notes

- All timestamps are handled by Laravel's timestamp trait automatically
- Date/time operations use Carbon for consistency
- Pagination defaults to safe limits (15-20 items per page)
- Services follow the repository pattern indirectly through model queries
- All database operations use proper SQL bindings for security

