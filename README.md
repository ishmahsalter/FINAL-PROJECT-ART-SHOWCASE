# **RIOTE ARTSHOWCASE - Digital Art Platform**

**RIOTE ARTSHOWCASE** adalah platform showcase karya seni digital yang dirancang untuk menjadi wadah bagi kreator untuk memamerkan portofolio mereka dan bagi pengguna lain untuk menemukan inspirasi. Sistem ini menghubungkan kreator dengan audiens melalui fitur-fitur interaktif seperti likes, komentar, dan favorites.

## 🎨 **Fitur Utama**

### 👥 **Multi-Role System**
1. **Admin** - Full platform management
2. **Member (Kreator)** - Upload & manage artworks
3. **Curator** - Create & manage challenges
4. **Public User (Guest)** - Browse artworks & challenges

### 🖼️ **Artwork Management**
- Upload karya seni digital (gambar, ilustrasi, foto)
- Kategori terorganisir (Fotografi, UI/UX, 3D Art, dll)
- Tag sistem untuk discoverability
- Multiple image upload support
- Zoom & detail view untuk artwork

### 🏆 **Challenge System**
- Curator dapat membuat challenge/kompetisi
- Member dapat submit karya ke challenge
- Sistem pemenang dengan hadiah
- Timeline & deadline management
- Gallery submission publik

### 💬 **Interaction System**
- Like/Unlike artworks
- Favorites/Bookmarks
- Comment system
- Report content (SARA, Plagiat, Konten Tidak Pantas)
- Follow/Following system

### 🔒 **Security & Moderation**
- Report content system
- Admin moderation queue
- User management & approval
- Content filtering & categorization
- Role-based access control

## 🚀 **Tech Stack**

### **Backend**
- **Framework**: Laravel 10
- **Language**: PHP 8.2+
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Breeze
- **Storage**: Laravel Filesystem (Local/S3)

### **Frontend**
- **CSS Framework**: Tailwind CSS 3.3
- **JavaScript**: Alpine.js 3.13
- **Build Tool**: Vite 4.4
- **Icons**: Heroicons & Font Awesome 6
- **Animations**: Animate.css & Custom CSS

### **External Services**
- **File Storage**: AWS S3 (optional)
- **Email**: Laravel Mail (SMTP)
- **Notifications**: Laravel Notifications

## 📁 **Struktur Proyek**

```
riote-artshowcase/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # Admin controllers
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UserController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   └── ModerationController.php
│   │   │   ├── Member/          # Member controllers
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── ArtworkController.php
│   │   │   │   ├── ProfileController.php
│   │   │   │   └── FollowController.php
│   │   │   ├── Curator/         # Curator controllers
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── ChallengeController.php
│   │   │   ├── Auth/            # Authentication
│   │   │   └── HomeController.php
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php
│   │   │   ├── MemberMiddleware.php
│   │   │   ├── CuratorMiddleware.php
│   │   │   └── CuratorPendingMiddleware.php
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Artwork.php
│   │   ├── Challenge.php
│   │   ├── Category.php
│   │   ├── Comment.php
│   │   ├── Like.php
│   │   ├── Favorite.php
│   │   ├── Report.php
│   │   ├── Follow.php
│   │   ├── Collection.php
│   │   └── Submission.php
│   ├── Providers/
│   └── View/Components/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   │   ├── 2025_01_01_000001_create_users_table.php
│   │   ├── 2025_01_01_000002_create_artworks_table.php
│   │   ├── 2025_01_01_000003_create_challenges_table.php
│   │   ├── 2025_01_01_000004_create_categories_table.php
│   │   ├── 2025_01_01_000005_create_comments_table.php
│   │   ├── 2025_01_01_000006_create_likes_table.php
│   │   ├── 2025_01_01_000007_create_favorites_table.php
│   │   ├── 2025_01_01_000008_create_reports_table.php
│   │   ├── 2025_01_01_000009_create_follows_table.php
│   │   ├── 2025_01_01_000010_create_collections_table.php
│   │   └── 2025_01_01_000011_create_submissions_table.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── CategorySeeder.php
│   │   └── UserSeeder.php
│   └── factories/
├── public/
│   ├── storage/                 # Uploaded files
│   └── index.php
├── resources/
│   ├── css/
│   │   └── app.css             # Tailwind CSS
│   ├── js/
│   │   ├── app.js
│   │   └── components/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php
│       │   ├── guest.blade.php
│       │   └── navigation.blade.php
│       ├── auth/               # Authentication views
│       ├── admin/              # Admin dashboard
│       │   ├── dashboard.blade.php
│       │   ├── users/
│       │   ├── categories/
│       │   ├── moderation/
│       │   └── challenges/
│       ├── member/             # Member dashboard
│       │   ├── dashboard.blade.php
│       │   ├── artworks/
│       │   ├── profile/
│       │   ├── collections/
│       │   ├── favorites/
│       │   └── follow/
│       ├── curator/            # Curator dashboard
│       │   ├── dashboard.blade.php
│       │   └── challenges/
│       ├── artworks/           # Public artwork views
│       │   ├── index.blade.php
│       │   ├── show.blade.php
│       │   └── partials/
│       ├── challenges/         # Public challenge views
│       │   ├── index.blade.php
│       │   ├── show.blade.php
│       │   └── partials/
│       ├── profile/            # Public profile views
│       ├── search/             # Search results
│       ├── static/             # Static pages
│       ├── components/         # Reusable components
│       ├── home/               # Homepage
│       │   ├── public.blade.php
│       │   ├── member.blade.php
│       │   └── partials/
│       └── welcome.blade.php
├── routes/
│   ├── web.php                 # Web routes
│   ├── api.php                 # API routes
│   ├── auth.php                # Authentication routes
│   └── console.php
├── storage/
│   ├── app/
│   │   ├── public/
│   │   │   ├── artworks/       # Artwork images
│   │   │   ├── avatars/        # User avatars
│   │   │   └── banners/        # Challenge banners
│   ├── framework/
│   └── logs/
├── tests/
├── vendor/
├── .env.example
├── .gitattributes
├── .gitignore
├── artisan
├── composer.json
├── package.json
├── phpunit.xml
├── tailwind.config.js
├── vite.config.js
└── README.md
```

## 🛠️ **Instalasi & Setup**

### **Prerequisites**
- PHP >= 8.2
- Composer >= 2.5
- Node.js >= 18.0
- NPM >= 9.0
- MySQL >= 8.0
- Git

### **Step 1: Clone Repository**
```bash
git clone https://github.com/yourusername/riote-artshowcase.git
cd riote-artshowcase
```

### **Step 2: Install Dependencies**
```bash
composer install
npm install
```

### **Step 3: Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` file:
```env
APP_NAME="RIOTE ARTSHOWCASE"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=art_showcase
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
```

### **Step 4: Database Setup**
```bash
php artisan migrate --seed
```

### **Step 5: Build Assets**
```bash
npm run dev
# Untuk production: npm run build
```

### **Step 6: Link Storage**
```bash
php artisan storage:link
```

### **Step 7: Jalankan Server**
```bash
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

## 👥 **Default Users**

Setelah seeding, tersedia user default:

### **Admin**
- Email: admin@riote-artshowcase.com
- Password: password

### **Member (Kreator)**
- Email: member@riote-artshowcase.com  
- Password: password

### **Curator**
- Email: curator@riote-artshowcase.com
- Password: password

## 📊 **Database Schema**

### **Users Table**
```sql
users:
- id (bigint, PK)
- name (string)
- email (string, unique)
- username (string, unique, nullable)
- password (string)
- role (enum: admin, member, curator)
- status (enum: active, pending, suspended)
- bio (text, nullable)
- profile_photo (string, nullable)
- website_url (string, nullable)
- social_links (json, nullable)
- email_verified_at (timestamp, nullable)
- remember_token (string, nullable)
- created_at, updated_at
```

### **Artworks Table**
```sql
artworks:
- id (bigint, PK)
- user_id (bigint, FK)
- category_id (bigint, FK, nullable)
- title (string)
- description (text)
- image_path (string)
- additional_images (json, nullable)
- tags (json, nullable)
- views_count (integer, default: 0)
- likes_count (integer, default: 0)
- comments_count (integer, default: 0)
- is_featured (boolean, default: false)
- allow_download (boolean, default: false)
- width (integer, nullable)
- height (integer, nullable)
- software (string, nullable)
- created_at, updated_at
```

### **Challenges Table**
```sql
challenges:
- id (bigint, PK)
- curator_id (bigint, FK)
- title (string)
- description (text)
- rules (text)
- prize (string)
- start_date (timestamp)
- end_date (timestamp)
- banner_image (string, nullable)
- status (enum: draft, active, closed, cancelled)
- submission_count (integer, default: 0)
- created_at, updated_at
```

### **Relationships**
```php
User:
- hasMany Artwork
- hasMany Challenge (as curator)
- hasMany Comment
- hasMany Like
- hasMany Favorite
- hasMany Report
- hasMany Collection
- belongsToMany User (followers/following)

Artwork:
- belongsTo User
- belongsTo Category
- hasMany Comment
- hasMany Like  
- hasMany Favorite
- hasMany Report
- belongsToMany Collection
- belongsToMany Challenge (through Submission)

Challenge:
- belongsTo User (as curator)
- hasMany Submission
- hasMany Artwork (through Submission)
```

## 🔐 **Role Permissions**

### **Admin (Super Administrator)**
- ✅ Full platform access
- ✅ User management (CRUD semua user)
- ✅ Category management
- ✅ Content moderation (approve/reject reports)
- ✅ Challenge oversight
- ✅ System settings
- ✅ Analytics & reports

### **Member (Kreator)**
- ✅ Upload & manage artworks
- ✅ Edit profile
- ✅ Like & favorite artworks
- ✅ Comment on artworks
- ✅ Report content
- ✅ Follow other creators
- ✅ Create collections/moodboards
- ✅ Submit to challenges

### **Curator**
- ✅ Create & manage challenges
- ✅ View submissions
- ✅ Select winners
- ✅ Edit profile
- ⚠️ Needs admin approval first
- ❌ Cannot upload artworks (unless also member)

### **Public User (Guest)**
- ✅ Browse artworks
- ✅ View profiles
- ✅ View challenges
- ✅ Search & filter
- ❌ Cannot interact (need login)

## 🎯 **API Endpoints**

### **Public API**
```
GET  /api/artworks              # List artworks
GET  /api/artworks/{id}         # Artwork details
GET  /api/challenges            # List challenges  
GET  /api/challenges/{id}       # Challenge details
GET  /api/users/{id}            # User profile
GET  /api/search?q=term         # Search
```

### **Authenticated API (Member)**
```
POST   /api/artworks/{id}/like      # Like artwork
POST   /api/artworks/{id}/favorite  # Favorite artwork
POST   /api/artworks/{id}/comment   # Add comment
DELETE /api/comments/{id}           # Delete comment
POST   /api/follow/{userId}         # Follow user
POST   /api/report/artwork          # Report artwork
POST   /api/challenges/{id}/submit  # Submit to challenge
```

### **Admin API**
```
GET    /api/admin/users            # List users
PUT    /api/admin/users/{id}       # Update user
DELETE /api/admin/users/{id}       # Delete user
GET    /api/admin/reports          # List reports
PUT    /api/admin/reports/{id}     # Process report
GET    /api/admin/analytics        # Platform analytics
```

## 🧪 **Testing**

### **Unit Tests**
```bash
php artisan test
```

### **Feature Tests**
```bash
php artisan test --testsuite=Feature
```

### **Browser Tests**
```bash
php artisan dusk
```

### **Test Coverage**
```bash
XDEBUG_MODE=coverage php artisan test --coverage-html coverage
```

## 🚀 **Deployment**

### **Production Requirements**
- PHP >= 8.2 dengan extensions: bcmath, ctype, fileinfo, json, mbstring, openssl, pdo, tokenizer, xml, gd
- MySQL >= 8.0 atau PostgreSQL >= 13
- Composer
- Node.js & NPM
- Supervisor (untuk queues)
- Redis (optional untuk caching)

### **Deployment Steps**

1. **Clone ke Production Server**
```bash
git clone https://github.com/yourusername/riote-artshowcase.git /var/www/riote-artshowcase
cd /var/www/riote-artshowcase
```

2. **Environment Setup**
```bash
cp .env.example .env
nano .env  # Configure production settings
```

3. **Install Dependencies**
```bash
composer install --optimize-autoloader --no-dev
npm ci
npm run build
```

4. **Database & Permissions**
```bash
php artisan migrate --force
php artisan storage:link
chmod -R 755 storage bootstrap/cache
```

5. **Optimize**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

6. **Setup Queue Worker (Supervisor)**
```ini
[program:riote-artshowcase-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/riote-artshowcase/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/riote-artshowcase/storage/logs/worker.log
```

7. **Schedule Task (Cron)**
```bash
* * * * * cd /var/www/riote-artshowcase && php artisan schedule:run >> /dev/null 2>&1
```

### **Performance Optimization**

1. **Caching**
```bash
# Redis caching
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

2. **CDN untuk Assets**
```env
ASSET_URL=https://cdn.yourdomain.com
```

3. **File Storage (S3)**
```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=ap-southeast-1
AWS_BUCKET=riote-artshowcase
AWS_URL=https://s3.ap-southeast-1.amazonaws.com
```

## 📈 **Monitoring & Analytics**

### **Built-in Analytics**
- User growth statistics
- Artwork upload trends
- Challenge participation rates
- Most liked/visited artworks
- Category distribution

### **Third-party Integration**
- Google Analytics (optional)
- Sentry (error tracking)
- Cloudflare (CDN & security)
- AWS CloudWatch (logs)

## 🔧 **Maintenance**

### **Daily Tasks**
- Check moderation queue
- Review reported content
- Approve pending curators
- Monitor system logs

### **Weekly Tasks**
- Backup database
- Clear old logs
- Update dependencies
- Review analytics

### **Monthly Tasks**
- Security audit
- Performance review
- User feedback analysis
- Feature planning

## 🤝 **Contributing**

### **Development Workflow**
1. Fork repository
2. Create feature branch: `git checkout -b feature/amazing-feature`
3. Commit changes: `git commit -m 'Add amazing feature'`
4. Push to branch: `git push origin feature/amazing-feature`
5. Open Pull Request

### **Coding Standards**
- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add tests for new features
- Update documentation
- Use English for comments and documentation

### **Commit Message Convention**
```
feat: Add new artwork zoom feature
fix: Resolve image upload validation
docs: Update API documentation
style: Format code according to PSR-12
refactor: Improve artwork search algorithm
test: Add tests for like functionality
chore: Update dependencies
```

## 📝 **License**

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 **Tim Pengembang**

- **Project Lead**: [Ishmah Nurwasilah]
- **Backend Developer**: [Ishmah Nurwasilah]
- **Frontend Developer**: [Ishmah Nurwasilah]
- **UI/UX Designer**: [Ishmah Nurwasilah]
- **QA Tester**: [Ishmah Nurwasilah]

## 🙏 **Acknowledgments**

- Laravel Community
- Tailwind CSS Team
- Alpine.js Contributors
- All our amazing beta testers
- Open source community

## 📞 **Support**

- **Documentation**: [docs.riote-artshowcase.com](https://docs.riote-artshowcase.com)
- **Issues**: [GitHub Issues](https://github.com/yourusername/riote-artshowcase/issues)
- **Email**: support@riote-artshowcase.com
- **Discord**: [Join our community](https://discord.gg/riote-artshowcase)

---

**RIOTE ARTSHOWCASE** - Where extraordinary talent meets global recognition. 🎨✨

© 2025 RIOTE ARTSHOWCASE. All rights reserved.
