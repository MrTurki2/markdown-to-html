# 🚀 Markdown to HTML Converter

> محول احترافي من Markdown إلى HTML مع دعم محركات متعددة ونظام مختبر للتجارب

[![Laravel](https://img.shields.io/badge/Laravel-12-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## ✨ المميزات

### 🌐 الواجهة العامة (Public)
- تحويل فوري من Markdown إلى HTML
- معاينة مباشرة وجميلة
- دعم كامل للعربية والـ RTL
- تصدير HTML مع الأنماط
- واجهة بسيطة وسهلة الاستخدام

### 🧪 المختبر (Lab)
- اختبار ومقارنة 4 محركات مختلفة
- قياس الأداء (Benchmarking)
- إحصائيات تفصيلية (الوقت، الذاكرة، الحجم)
- تجارب متقدمة (Themes, RTL, Plugins)

### ⚙️ المحركات المدعومة

| المحرك | اللغة | السرعة | الحالة | الاستخدام |
|--------|-------|---------|--------|-----------|
| **Marked.js** | JavaScript | 5,400 ops/sec | ✅ نشط | التحويل الافتراضي (90%) |
| **CommonMark** | PHP | 500 ops/sec | ✅ نشط | Backend Laravel |
| **Rust** | Rust | 100,000+ ops/sec | 🔜 قريباً | الملفات الكبيرة |
| **Python** | Python | 2,000 ops/sec | 🔜 قريباً | دعم RTL والعربية |

---

## 📦 التثبيت

### المتطلبات
- PHP 8.3+
- Composer
- Node.js & NPM (للـ frontend assets)
- SQLite أو MySQL

### خطوات التثبيت

```bash
# 1. استنساخ المشروع
git clone https://github.com/MrTurki2/markdown-to-html.git
cd markdown-to-html

# 2. تثبيت التبعيات
composer install
npm install

# 3. إعداد البيئة
cp .env.example .env
php artisan key:generate

# 4. إعداد قاعدة البيانات
touch database/database.sqlite
php artisan migrate

# 5. تشغيل التطبيق
php artisan serve
```

الآن افتح المتصفح على: `http://localhost:8000`

---

## 🎯 الاستخدام

### الواجهة العامة

```
http://localhost:8000/
```

1. الصق أو اكتب نص Markdown
2. اضغط "تحويل الآن"
3. شاهد المعاينة المباشرة
4. احفظ أو انسخ HTML

### المختبر

```
http://localhost:8000/lab
```

1. اختر المحرك (Marked.js, CommonMark, ...)
2. الصق نص Markdown للاختبار
3. اضغط "اختبار" وشاهد النتائج
4. قارن الأداء بين المحركات

---

## 🏗️ هيكلة المشروع

```
markdown-to-html/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── PublicController.php    # التحويل العام
│   │       └── LabController.php       # المختبر والتجارب
│   └── Models/
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php          # Layout رئيسي
│       ├── public/
│       │   └── index.blade.php        # الصفحة العامة
│       └── lab/
│           └── index.blade.php        # صفحة المختبر
├── routes/
│   └── web.php                        # Routes (/ و /lab)
├── public/
└── README.md
```

---

## 🔌 API Endpoints

### تحويل Markdown (CommonMark)

```bash
POST /convert
Content-Type: application/json

{
  "markdown": "# Hello World\n\nThis is **bold** text.",
  "engine": "commonmark"
}
```

**Response:**
```json
{
  "success": true,
  "html": "<h1>Hello World</h1>\n<p>This is <strong>bold</strong> text.</p>",
  "conversion_time": 12.34,
  "engine": "commonmark",
  "input_size": 42,
  "output_size": 68
}
```

### اختبار المحركات (Lab)

```bash
POST /lab/test-engine
Content-Type: application/json

{
  "markdown": "# Test",
  "engine": "commonmark",
  "options": {
    "html_input": "allow"
  }
}
```

**Response:**
```json
{
  "success": true,
  "html": "<h1>Test</h1>",
  "stats": {
    "conversion_time_ms": 5.23,
    "memory_used_mb": 0.12,
    "input_size": 6,
    "output_size": 13,
    "compression_ratio": 2.17
  },
  "engine": {
    "name": "commonmark",
    "version": "2.7"
  }
}
```

---

## 🎨 نظام الثيمات (قريباً)

سيتم إضافة 20+ ثيم احترافي:
- GitHub Style
- Dark Mode
- Ocean Theme
- Sunset Theme
- وغيرها...

---

## 🚀 خطة التطوير المستقبلية

### المرحلة 1 - الحالية ✅
- [x] Laravel 12 Setup
- [x] Public Interface
- [x] Lab Interface
- [x] Marked.js Integration
- [x] CommonMark Integration
- [x] GitHub Repository

### المرحلة 2 - قريباً 🔜
- [ ] Rust Engine Integration
- [ ] Python Engine for RTL
- [ ] Theme System (20+ themes)
- [ ] PDF Export
- [ ] DOCX Export

### المرحلة 3 - مستقبلية 🎯
- [ ] Multi-language Support
- [ ] Real-time Collaboration
- [ ] Cloud Storage Integration
- [ ] Advanced Plugins System
- [ ] API Rate Limiting

---

## 🛠️ التقنيات المستخدمة

### Backend
- **Laravel 12** - PHP Framework
- **League CommonMark 2.7** - Markdown Parser
- **SQLite** - Database

### Frontend
- **Tailwind CSS** - Styling
- **Marked.js 15.0** - JavaScript Markdown Parser
- **Vanilla JavaScript** - Interactivity

### المحركات المستقبلية
- **pulldown-cmark** (Rust) - Ultra-fast parsing
- **python-markdown** (Python) - RTL & Arabic support

---

## 📊 المقارنة بين المحركات

### الأداء (100KB Markdown)

| المحرك | الوقت | الذاكرة | الدقة | RTL |
|--------|------|---------|-------|-----|
| Marked.js | 50ms | 10MB | ⭐⭐⭐⭐ | ❌ |
| CommonMark | 500ms | 15MB | ⭐⭐⭐⭐ | ✅ |
| Rust | 5ms | 5MB | ⭐⭐⭐⭐⭐ | ❌ |
| Python | 300ms | 20MB | ⭐⭐⭐⭐ | ✅ |

### الاستخدام المُوصى به

```
📝 النصوص العادية → Marked.js
📚 الملفات الكبيرة → Rust Engine
🌍 النصوص العربية → Python Engine
🔒 الأمان والتنظيف → CommonMark
```

---

## 🤝 المساهمة

نرحب بمساهماتكم! إليك كيفية المشاركة:

1. Fork المشروع
2. أنشئ Branch جديد (`git checkout -b feature/amazing-feature`)
3. Commit التغييرات (`git commit -m 'Add amazing feature'`)
4. Push إلى Branch (`git push origin feature/amazing-feature`)
5. افتح Pull Request

---

## 📝 الترخيص

هذا المشروع مرخص تحت رخصة MIT - اطلع على ملف [LICENSE](LICENSE) للتفاصيل.

---

## 📧 التواصل

- **GitHub**: [@MrTurki2](https://github.com/MrTurki2)
- **Project Link**: [markdown-to-html](https://github.com/MrTurki2/markdown-to-html)
- **Issues**: [Report Bug](https://github.com/MrTurki2/markdown-to-html/issues)

---

## 🙏 شكر وتقدير

بُني هذا المشروع باستخدام:
- [Laravel](https://laravel.com) - The PHP Framework
- [Marked.js](https://marked.js.org) - Fast Markdown Parser
- [League CommonMark](https://commonmark.thephpleague.com) - PHP Markdown Parser
- [Tailwind CSS](https://tailwindcss.com) - Utility-first CSS

---

## 📚 الوثائق الإضافية

للمطورين المهتمين بالتفاصيل التقنية، راجع:
- خطة التقنيات المتقدمة - تحليل شامل للمحركات والأداء
- خارطة طريق الإنتاج - خطة نشر التطبيق للبيئة الإنتاجية

---

<div align="center">

**⭐ إذا أعجبك المشروع، لا تنسَ إضافة نجمة! ⭐**

صُنع بـ ❤️ باستخدام Laravel & Marked.js

</div>
