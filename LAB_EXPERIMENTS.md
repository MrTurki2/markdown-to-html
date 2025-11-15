# 🧪 دليل تجارب المختبر

مجموعة شاملة من التجارب المتقدمة لتحويل Markdown مع مميزات مختلفة

---

## 📋 نظرة عامة

تم نقل **8 تجارب** من المشروع السابق (`/Users/mrturki/Code/PHP/md-to-html`) إلى المشروع الجديد في قسم `/lab/experiments`

---

## 🔬 التجارب المتاحة

### Test 2: حفظ وإدارة الملفات 💾

**المسار:** `/lab/test2`

**المميزات:**
- حفظ Markdown و HTML في قاعدة البيانات
- إدارة الملفات المحفوظة
- تحميل HTML كملف كامل
- تحميل Markdown كملف .md
- قائمة بجميع الملفات المحفوظة
- استرجاع الملفات السابقة

**التقنيات:**
- SQLite Database
- League CommonMark
- Marked.js (Frontend)

**الـ Routes:**
```php
GET  /lab/test2
POST /lab/test2/save
GET  /lab/test2/files
GET  /lab/test2/file/{id}
```

---

### Test 3: حفظ ملفات نصية 📝

**المسار:** `/lab/test3`

**المميزات:**
- حفظ المحتوى كملف نصي في Storage
- دعم امتدادات .txt و .md
- تحميل الملفات مباشرة
- معاينة Markdown مباشرة

**التقنيات:**
- Laravel Storage
- File System
- Marked.js

**الـ Routes:**
```php
GET  /lab/test3
POST /lab/test3/save
```

---

### Test 4: محرر Quill WYSIWYG ✏️

**المسار:** `/lab/test4`

**المميزات:**
- محرر نصوص غني (WYSIWYG)
- Toolbar كامل مع أدوات تنسيق
- تحويل WYSIWYG إلى HTML
- معاينة فورية
- واجهة سهلة للمبتدئين

**التقنيات:**
- Quill.js Editor
- Delta Format
- HTML Conversion

**الـ Routes:**
```php
GET /lab/test4
```

---

### Test 5: توليد PDF 📄

**المسار:** `/lab/test5`

**المميزات:**
- تحويل HTML إلى PDF
- دعم كامل للعربية
- دعم RTL (من اليمين لليسار)
- خيارات تخصيص الصفحة:
  - حجم الصفحة (A4, Letter, etc.)
  - Margins
  - Header/Footer
- استخدام خطوط DejaVu لدعم العربية

**التقنيات:**
- mPDF Library
- Arabic Font Support
- RTL Directionality

**الـ Routes:**
```php
GET  /lab/test5
POST /lab/test5/generate-pdf
```

**مثال الاستخدام:**
```javascript
fetch('/lab/test5/generate-pdf', {
    method: 'POST',
    body: JSON.stringify({
        html: htmlContent,
        filename: 'document.pdf',
        options: {
            pageSize: 'A4'
        }
    })
});
```

---

### Test 6: توليد المحتوى 🤖

**المسار:** `/lab/test6`

**المميزات:**
- توليد محتوى تلقائي
- تحرير المحتوى بـ AI
- اقتراحات ذكية
- تحسين النصوص

**التقنيات:**
- OpenAI API (محتمل)
- Content Generation
- AI-powered editing

**الـ Routes:**
```php
GET  /lab/test6
POST /lab/test6/generate-content
POST /lab/test6/edit-content
```

---

### Test 8: لقطات الشاشة و PDF 📸

**المسار:** `/lab/test8`

**المميزات:**
- التقاط screenshots للصفحات
- تحويل HTML إلى PDF باستخدام Puppeteer
- جودة عالية
- دعم CSS والـ JavaScript
- خيارات متقدمة:
  - Viewport size
  - Full page or specific element
  - Image format (PNG, JPEG)

**التقنيات:**
- Spatie Browsershot
- Puppeteer
- Chrome Headless

**الـ Routes:**
```php
GET  /lab/test8
POST /lab/test8/screenshot
POST /lab/test8/pdf
```

**مثال Screenshot:**
```javascript
fetch('/lab/test8/screenshot', {
    method: 'POST',
    body: JSON.stringify({
        url: 'https://example.com',
        width: 1920,
        height: 1080
    })
});
```

---

### Test 9: PDF متقدم 📚

**المسار:** `/lab/test9`

**المميزات:**
- توليد PDF احترافي
- تنسيقات متقدمة
- دعم العربية الكامل
- خيارات تخصيص شاملة:
  - Multiple templates
  - Custom styling
  - Page numbering
  - Table of contents
  - Watermarks

**التقنيات:**
- mPDF Advanced Features
- Custom Templates
- Professional Layouts

**الـ Routes:**
```php
GET  /lab/test9
POST /lab/test9/generate-pdf
```

---

## 📊 مقارنة التجارب

| التجربة | الهدف | التقنية | التصدير | الصعوبة |
|--------|-------|---------|---------|---------|
| **Test 2** | حفظ الملفات | Database | HTML, MD | ⭐⭐ |
| **Test 3** | ملفات نصية | Storage | TXT, MD | ⭐ |
| **Test 4** | محرر WYSIWYG | Quill.js | HTML | ⭐⭐ |
| **Test 5** | PDF بسيط | mPDF | PDF | ⭐⭐⭐ |
| **Test 6** | AI Content | OpenAI | - | ⭐⭐⭐⭐ |
| **Test 8** | Screenshots | Puppeteer | PNG, PDF | ⭐⭐⭐⭐ |
| **Test 9** | PDF متقدم | mPDF Pro | PDF | ⭐⭐⭐⭐⭐ |

---

## 🎯 متى تستخدم كل تجربة؟

### للاستخدام اليومي
- **Test 2**: إذا كنت تريد حفظ عملك للرجوع إليه لاحقاً
- **Test 4**: إذا كنت تفضل التحرير المرئي السهل

### للتصدير
- **Test 5**: لتوليد PDF بسيط بسرعة
- **Test 8**: للحصول على PDF بجودة عالية مع CSS
- **Test 9**: لمستندات احترافية مع تنسيقات معقدة

### للمطورين
- **Test 3**: لحفظ ملفات نصية في التخزين
- **Test 6**: لتجريب AI content generation
- **Test 8**: لأتمتة screenshots

---

## 🔧 المتطلبات التقنية

### PHP Extensions
```bash
# Required for mPDF
php -m | grep -E 'gd|mbstring|dom|xml'

# Required for Puppeteer (via Node.js)
node --version
npm --version
```

### Composer Packages
```json
{
    "league/commonmark": "^2.7",
    "mpdf/mpdf": "^8.0",
    "spatie/browsershot": "^3.0"
}
```

### NPM Packages (Optional)
```bash
npm install puppeteer
```

---

## 📁 هيكلة الملفات

```
resources/views/lab/
├── experiments.blade.php    # صفحة فهرس التجارب
├── test2.blade.php         # حفظ الملفات
├── test3.blade.php         # ملفات نصية
├── test4.blade.php         # Quill Editor
├── test5.blade.php         # PDF Generation
├── test6.blade.php         # Content Generation
├── test8.blade.php         # Screenshots
└── test9.blade.php         # Advanced PDF

app/Http/Controllers/
└── MarkdownController.php  # جميع methods للتجارب

app/Models/
└── MarkdownFile.php        # Model للملفات

database/migrations/
└── 2025_09_22_214207_create_markdown_files_table.php
```

---

## 🚀 كيفية الاستخدام

### 1. تشغيل المشروع
```bash
cd /Users/mrturki/Code/PHP/markdown-to-html
php artisan serve
```

### 2. الوصول للتجارب
افتح المتصفح: `http://localhost:8000/lab/experiments`

### 3. اختر التجربة المناسبة
- اضغط على أي تجربة لفتحها
- اقرأ التعليمات في كل صفحة
- جرب المميزات المختلفة

---

## 🐛 استكشاف الأخطاء

### مشكلة: PDF لا يدعم العربية
**الحل:**
```php
// تأكد من استخدام خط DejaVu
$mpdf = new Mpdf([
    'default_font' => 'dejavusans',
    'mode' => 'utf-8'
]);
```

### مشكلة: Puppeteer لا يعمل
**الحل:**
```bash
# تثبيت Chrome headless
npm install puppeteer

# أو استخدام Chrome النظام
php artisan vendor:publish --tag=browsershot-config
```

### مشكلة: الملفات لا تُحفظ
**الحل:**
```bash
# تأكد من Permissions
chmod -R 775 storage/
php artisan migrate
```

---

## 💡 نصائح وحيل

### Test 2 (حفظ الملفات)
- أعط أسماء وصفية للملفات
- استخدم التاريخ في اسم الملف
- نظّف قاعدة البيانات بانتظام

### Test 5 & 9 (PDF)
- استخدم RTL directionality للعربية
- اختبر على صفحات صغيرة أولاً
- استخدم fonts مناسبة

### Test 8 (Screenshots)
- حدد viewport size مناسب
- استخدم delays للمحتوى الديناميكي
- حفّظ الصور المؤقتة

---

## 📚 موارد إضافية

### Documentation
- [mPDF Docs](https://mpdf.github.io/)
- [Quill.js Guide](https://quilljs.com/docs/)
- [Browsershot](https://github.com/spatie/browsershot)
- [League CommonMark](https://commonmark.thephpleague.com/)

### أمثلة
انظر إلى الملفات في `/resources/views/lab/` لأمثلة كاملة

---

## 🔜 خطط مستقبلية

### قريباً
- [ ] Test 10: Real-time collaboration
- [ ] Test 11: Version control
- [ ] Test 12: Export to DOCX

### مستقبلي
- [ ] Cloud storage integration
- [ ] Templates marketplace
- [ ] Advanced analytics

---

## 📧 الدعم

إذا واجهت مشاكل:
1. راجع هذا الملف
2. تحقق من logs: `storage/logs/laravel.log`
3. افتح issue على GitHub

---

**آخر تحديث:** 2025-11-15
**الإصدار:** 1.1.0 (مع التجارب)
**الحالة:** ✅ جميع التجارب منقولة وجاهزة

🧪 استمتع بالتجارب!
