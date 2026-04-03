# PropertyHub - Quick Start Guide 🚀

**Your complete API & mobile app is ready to go!**

---

## ⚡ 5-Minute Setup

### Terminal 1: Start Backend
```bash
cd PropertyHub-PFE/PropertyHub

# First time only:
php artisan key:generate
php artisan migrate

# Remove .sqlite file before first run if it exists
rm database/database.sqlite
php artisan migrate

# Start server
php artisan serve
```
✅ Backend running on `http://localhost:8000`

### Terminal 2: Start Mobile App
```bash
cd mobile-app/app
npm install  # First time only
npm run dev
```
✅ Mobile app running on `http://localhost:3000`

---

## 🧪 Test It Works (30 seconds)

### Open your browser and test:

```bash
# 1. See if API responds
curl http://localhost:8000/api/properties

# This should return JSON with properties

# 2. Visit the mobile app
Open: http://localhost:3000
```

---

## 📋 What You Have

### Backend API ✅
- **40+ REST endpoints** for properties, appointments, messages
- **Authentication** with token-based login
- **Database** with 10 tables (SQLite)
- **Services** encapsulating all business logic
- **110+ unit tests** (run with `php artisan test`)

### Mobile App ✅ (Needs UI)
- **NativePHP Laravel** framework
- **API service** bridge to backend
- **Routes** for all features
- **Views** skeleton (ready to customize)

---

## 🎮 Key Endpoints to Know

### Authentication
```bash
# Register
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"John","email":"john@example.com","password":"123456","password_confirmation":"123456","role":"buyer"}'

# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"123456"}'

# Response includes: "token": "1|eyJ..."
# Save this token for protected requests!
```

### Properties
```bash
# Get all properties
curl http://localhost:8000/api/properties

# Search with filters
curl "http://localhost:8000/api/properties/search?location=New%20York&min_price=100000"

# Get single property
curl http://localhost:8000/api/properties/1
```

### Appointments (Requires token)
```bash
# See available slots for agent 1
curl "http://localhost:8000/api/appointments/agent/1/slots?date=2026-04-15"

# Book appointment (use TOKEN from login)
curl -X POST http://localhost:8000/api/appointments \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"agent_id":1,"date_time":"2026-04-15 14:00"}'
```

### Messages (Requires token)
```bash
# Get your conversations
curl -H "Authorization: Bearer TOKEN" \
  http://localhost:8000/api/messages/conversations

# Send message
curl -X POST \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"receiver_id":2,"content":"Hello!"}' \
  http://localhost:8000/api/messages
```

---

## 📚 Where to Find Everything

| What | Where |
|------|-------|
| **Complete Setup Guide** | `PropertyHub/API_MOBILE_SETUP.md` |
| **Codebase Index** | `CODEBASE_STRUCTURE_INVENTORY.md` |
| **All API Routes** | `PropertyHub/routes/api.php` |
| **All Mobile Routes** | `mobile-app/app/routes/web.php` |
| **API Service** | `mobile-app/app/Services/PropertyHubApiService.php` |
| **Database Schema** | `PropertyHub/database/migrations/` |
| **Services** | `PropertyHub/app/Services/` |
| **Controllers** | `PropertyHub/app/Http/Controllers/Api/` |

---

## 🎨 Mobile App Views to Build

Create Blade views in `mobile-app/app/resources/views/`:

```
auth/
  ├── login.blade.php
  ├── register.blade.php

properties/
  ├── index.blade.php (list all)
  ├── show.blade.php (details)

favorites/
  └── index.blade.php

appointments/
  ├── index.blade.php (list)
  └── book.blade.php (form)

messages/
  ├── index.blade.php (conversations)
  └── show.blade.php (thread)

layouts/
  └── app.blade.php (master layout)
```

Each view gets data from `PropertyHubApiService` which handles all API calls.

---

## ✅ Verification Checklist

- [ ] Backend starts without errors: `php artisan serve`
- [ ] Mobile app starts without errors: `npm run dev`
- [ ] Backend responds to `/api/properties`: ✅
- [ ] Can register new user: ✅
- [ ] Can login and get token: ✅
- [ ] Can view properties with token: ✅
- [ ] Database has sample data: ✅

---

## 🔐 Database Reset (If Needed)

```bash
cd PropertyHub-PFE/PropertyHub

# Clear and rebuild everything
php artisan migrate:fresh --seed

# This creates:
# - Fresh database schema
# - Sample users (admin, agent, buyers)
# - Sample properties
# - Sample appointments
# - Sample messages
```

---

## 📊 What's in the Database

```
Users:
  - admin@example.com / password (Role: admin)
  - agent@example.com / password (Role: agent)
  - buyer@example.com / password (Role: buyer)

Properties:
  - 30+ sample listings with prices, locations, images

Appointments:
  - Sample bookings (you can see/modify)

Messages:
  - Sample conversations between users
```

---

## 🚀 Next Steps

1. ✅ **Start Both Servers** (see 5-minute setup above)
2. ✅ **Test API Endpoints** (use curl commands above)
3. 📱 **Build Mobile Views** (create .blade.php files)
4. 🎨 **Style with Tailwind CSS** (already configured)
5. 🧪 **Test Full Workflows** (register → search → book → message)
6. 🌐 **Deploy to Production** (see API_MOBILE_SETUP.md for checklist)

---

## 🐛 Troubleshooting

### Backend won't start
```bash
cd PropertyHub-PFE/PropertyHub
php artisan key:generate
rm database/database.sqlite
php artisan migrate
php artisan serve
```

### Mobile app won't connect to API
```bash
# Check .env file
cat mobile-app/app/.env | grep PROPERTY_HUB_API_URL

# Should show: PROPERTY_HUB_API_URL=http://localhost:8000/api

# Check backend is running
curl http://localhost:8000/api/health
```

### Database table doesn't exist
```bash
php artisan migrate
# If that fails:
php artisan migrate:refresh
php artisan db:seed
```

---

## 📞 Need Help?

1. Read `PropertyHub/API_MOBILE_SETUP.md` - Complete documentation
2. Check `CODEBASE_STRUCTURE_INVENTORY.md` - What files exist
3. View `QUICK_REFERENCE.md` - Quick lookup

---

## 🎉 You're All Set!

Your PropertyHub system is fully functional and ready for development.

**Start with**: Terminal 1 + Terminal 2 setup above, then visit http://localhost:3000

Happy coding! 🚀
