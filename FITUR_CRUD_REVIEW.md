# 📋 DOKUMENTASI FITUR CRUD & REVIEW SYSTEM

## Ringkasan Implementasi

Sistem CRUD lengkap telah diimplementasikan dengan fitur-fitur berikut:

### ✅ 1. ADMIN EVENT MANAGEMENT DENGAN UPLOAD GAMBAR

#### Database Migration
- File: `database/migrations/2026_05_26_000001_add_image_to_events_table.php`
- Kolom baru:
  - `image_path` - menyimpan path gambar event
  - `tour_guide_id` - foreign key ke tour guide

#### Controller: `app/Http/Controllers/Admin/EventController.php`
**Fitur:**
- ✅ Create event dengan upload gambar (JPG, PNG, GIF, max 2MB)
- ✅ Edit event dengan kemampuan update gambar
- ✅ Delete gambar otomatis saat event dihapus
- ✅ Validation untuk file upload

**Routes:**
```
GET    /admin/events              - List semua events
GET    /admin/events/create       - Form create event
POST   /admin/events              - Store event baru
GET    /admin/events/{id}/edit    - Form edit event
PUT    /admin/events/{id}         - Update event
DELETE /admin/events/{id}         - Hapus event
```

#### Views:
- `resources/views/admin/events/create.blade.php` - Form create dengan upload gambar
- `resources/views/admin/events/edit.blade.php` - Form edit dengan preview gambar lama
- `resources/views/admin/events/index.blade.php` - List events dengan thumbnail gambar

---

### ✅ 2. EVENT REVIEW SYSTEM OLEH USER

#### Database Migration
- File: `database/migrations/2026_05_26_000002_add_event_and_user_to_reviews_table.php`
- Kolom baru di table reviews:
  - `event_id` - foreign key ke event
  - `user_id` - foreign key ke user yang review

#### Model Relationships
- **Event.php**: 
  ```php
  - hasMany(Review::class, 'event_id')
  - averageRating() method untuk hitung rating rata-rata
  ```
- **Review.php**:
  ```php
  - belongsTo(Event::class, 'event_id')
  - belongsTo(User::class, 'user_id')
  ```

#### Controller: `app/Http/Controllers/ReviewController.php`
**Fitur:**
- ✅ User bisa memberikan review ke event (rating 1-5, komentar)
- ✅ Otomatis set user_id dari user yang login
- ✅ Validasi: max 1000 karakter komentar
- ✅ User tidak bisa review event 2x

**Routes:**
```
POST /events/{event}/review - Store review event (require auth)
```

#### Views:
- `resources/views/events/show.blade.php` - Detail event dengan:
  - Gallery gambar event
  - Info tour guide lengkap
  - Form review untuk user yang sudah login
  - List review dari user lain
  - Rating average display
  - Review counter

---

### ✅ 3. ADMIN REVIEW MANAGEMENT

#### Controller: `app/Http/Controllers/Admin/ReviewController.php`
**Fitur:**
- ✅ Admin bisa manage general reviews (testimonial)
- ✅ Admin bisa link review ke event tertentu
- ✅ Full CRUD untuk reviews

**Routes:**
```
GET    /admin/reviews              - List semua reviews
GET    /admin/reviews/create       - Form create review
POST   /admin/reviews              - Store review baru
GET    /admin/reviews/{id}/edit    - Form edit review
PUT    /admin/reviews/{id}         - Update review
DELETE /admin/reviews/{id}         - Hapus review
```

#### Views:
- `resources/views/admin/reviews/create.blade.php` - Form create review dengan event dropdown
- `resources/views/admin/reviews/edit.blade.php` - Form edit dengan event field

---

### ✅ 4. BOOKING REVIEW SYSTEM OLEH USER

#### Database Migration
- File: `database/migrations/2026_05_26_000003_create_booking_reviews_table.php`
- Table baru: `booking_reviews` dengan fields:
  - `id` - primary key
  - `booking_id` - foreign key ke booking
  - `user_id` - foreign key ke user
  - `rating` - rating 1-5
  - `comment` - text review
  - `timestamps` - created_at, updated_at

#### Model: `app/Models/BookingReview.php` (New)
**Relationships:**
```php
- belongsTo(Booking::class)
- belongsTo(User::class)
```

#### Model Update: `app/Models/Booking.php`
**Relationships:**
```php
- hasOne(BookingReview::class) - One booking can have one review
```

#### Controller: `app/Http/Controllers/BookingReviewController.php`
**Fitur:**
- ✅ User bisa review booking mereka
- ✅ Review hanya bisa diberikan setelah tanggal kunjungan
- ✅ User bisa delete review yang sudah dibuat
- ✅ Authorization: user hanya bisa review booking mereka sendiri

**Routes:**
```
POST   /bookings/{booking}/review      - Store booking review (require auth)
DELETE /booking-reviews/{review}       - Delete booking review (require auth)
```

#### Controller: `app/Http/Controllers/ProfileController.php` (Updated)
**Fitur baru:**
- ✅ `bookingDetail()` method untuk show detail booking dengan review form
- ✅ Authorization check: user hanya bisa akses booking milik mereka

**Routes:**
```
GET /profile/bookings/{booking} - Detail booking dengan review option
```

#### Views:
- `resources/views/profile/booking-detail.blade.php` - Detail booking dengan:
  - Info booking lengkap
  - Form review jika belum di-review dan tanggal sudah lewat
  - Display review jika sudah diberikan
  - Delete review button
  - Status display
- `resources/views/profile/bookings.blade.php` - Updated dengan:
  - "Lihat Detail" button ke booking-detail
  - Badge "Review Diberikan" jika sudah review

---

### ✅ 5. EVENT DETAIL PAGE (USER-FACING)

#### Controller: `app/Http/Controllers/EventDetailController.php` (New)
**Fitur:**
- ✅ Show event detail dengan lengkap
- ✅ Load relationships: tourGuide, reviews.user

**Routes:**
```
GET /events/{event} - Show event detail
```

#### View: `resources/views/events/show.blade.php`
**Menampilkan:**
- ✅ Gambar event
- ✅ Event details (tanggal, waktu, lokasi)
- ✅ Tour guide info lengkap:
  - Nama tour guide
  - Deskripsi
  - Nomor telepon
  - Bahasa yang dikuasai
- ✅ Deskripsi event
- ✅ Form review untuk user yang login
- ✅ List review dengan user info
- ✅ Average rating display
- ✅ Review counter
- ✅ Status event (Akan Datang / Selesai)

---

### ✅ 6. HOME PAGE EVENTS DISPLAY (Updated)

#### View: `resources/views/partials/events.blade.php` (Updated)
**Perubahan:**
- ✅ Tampilkan gambar event
- ✅ Link ke event detail page
- ✅ Show tour guide name
- ✅ Show average rating badge jika ada review
- ✅ Cards dengan hover effect

---

## 📊 Database Schema

### Events Table (Updated)
```sql
- id
- name
- description
- date
- time
- location
- image_path          ← NEW
- tour_guide_id       ← NEW (FK)
- timestamps
```

### Reviews Table (Updated)
```sql
- id
- event_id            ← NEW (FK)
- user_id             ← NEW (FK)
- visitor_name
- rating
- comment
- timestamps
```

### Booking Reviews Table (New)
```sql
- id
- booking_id (FK)
- user_id (FK)
- rating (1-5)
- comment
- timestamps
```

---

## 🔐 Security & Authorization

1. **Event Review:**
   - Require user to be authenticated (`middleware('auth')`)
   - User data automatically captured

2. **Booking Review:**
   - Require user to be authenticated
   - Only booking owner can review their booking
   - Review only allowed after visit date has passed
   - Authorization check in controller

3. **File Upload:**
   - Validation: JPG, PNG, GIF only
   - Max file size: 2MB
   - Stored in `storage/app/public/events/`
   - Old images deleted when updated/deleted

---

## 📝 Routes Summary

```php
// Event Detail (Public)
GET  /events/{event}                       - Show event detail

// Event Review (User)
POST /events/{event}/review                - Store event review

// Booking Detail & Review (User)
GET  /profile/bookings/{booking}           - Show booking detail
POST /bookings/{booking}/review            - Store booking review
DELETE /booking-reviews/{review}           - Delete booking review

// Admin Events Management
GET  /admin/events                         - List events
GET  /admin/events/create                  - Create form
POST /admin/events                         - Store
GET  /admin/events/{id}/edit               - Edit form
PUT  /admin/events/{id}                    - Update
DELETE /admin/events/{id}                  - Delete

// Admin Review Management
GET  /admin/reviews                        - List reviews
GET  /admin/reviews/create                 - Create form
POST /admin/reviews                        - Store
GET  /admin/reviews/{id}/edit              - Edit form
PUT  /admin/reviews/{id}                   - Update
DELETE /admin/reviews/{id}                 - Delete
```

---

## 🎨 User Interface

### Admin Side
- Event management dengan upload gambar
- Review management dengan event linking
- Thumbnail preview
- Full CRUD operations

### User Side
- Event detail page dengan gambar & tour guide info
- Review event form
- Booking detail dengan review option
- Review history

---

## ⚙️ Installation & Setup

1. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

2. **Create Storage Symlink:**
   ```bash
   php artisan storage:link
   ```

3. **Permissions:**
   - Ensure `storage/app/public` is writable
   - Images accessible via `/storage/` URL

---

## 📱 Features Checklist

- [x] Admin bisa upload gambar untuk event
- [x] Event linked dengan tour guide
- [x] User bisa review event (dengan rating & komentar)
- [x] Event detail show tour guide info lengkap
- [x] User bisa review booking mereka
- [x] Review hanya setelah tanggal kunjungan
- [x] User bisa delete review yang sudah dibuat
- [x] Full admin CRUD untuk event dengan gambar
- [x] Full admin CRUD untuk review
- [x] Authorization & Security implemented
- [x] Database migrations completed
- [x] All views created & styled

---

**Status: ✅ COMPLETE**

Semua fitur telah diimplementasikan dan siap digunakan!
