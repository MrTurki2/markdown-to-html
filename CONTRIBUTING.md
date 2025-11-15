# 🤝 دليل المساهمة

شكراً لاهتمامك بالمساهمة في Markdown to HTML Converter! نرحب بجميع أنواع المساهمات.

---

## 🎯 طرق المساهمة

### 1️⃣ الإبلاغ عن الأخطاء (Bug Reports)

قبل فتح issue جديد:
- تأكد من عدم وجود issue مشابه
- استخدم أحدث نسخة من المشروع
- قدم معلومات كافية لإعادة إنتاج المشكلة

**Template للـ Bug Report:**
```markdown
**الوصف:**
وصف واضح للمشكلة

**خطوات إعادة الإنتاج:**
1. اذهب إلى '...'
2. اضغط على '...'
3. شاهد الخطأ

**السلوك المتوقع:**
ما كان يجب أن يحدث

**السلوك الفعلي:**
ما حدث بالفعل

**البيئة:**
- نظام التشغيل: [مثلاً macOS 14]
- PHP Version: [مثلاً 8.3]
- Laravel Version: [مثلاً 12.10]
- Browser: [مثلاً Chrome 120]
```

---

### 2️⃣ اقتراح ميزات جديدة (Feature Requests)

**Template للـ Feature Request:**
```markdown
**المشكلة:**
وصف المشكلة التي تحلها هذه الميزة

**الحل المقترح:**
كيف تتخيل الحل

**البدائل:**
حلول أخرى فكرت فيها

**سياق إضافي:**
أي معلومات أخرى مفيدة
```

---

### 3️⃣ المساهمة بالكود (Code Contributions)

#### خطوات المساهمة:

1. **Fork المشروع**
   ```bash
   # اضغط Fork على GitHub
   git clone https://github.com/YOUR_USERNAME/markdown-to-html.git
   cd markdown-to-html
   ```

2. **أنشئ Branch جديد**
   ```bash
   git checkout -b feature/amazing-feature
   # أو
   git checkout -b fix/bug-description
   ```

3. **أجرِ التغييرات**
   - اكتب كود نظيف
   - اتبع معايير Laravel
   - أضف تعليقات مفيدة
   - اكتب tests إن أمكن

4. **اختبر التغييرات**
   ```bash
   # شغل الاختبارات
   php artisan test

   # تأكد من عمل التطبيق
   php artisan serve
   ```

5. **Commit التغييرات**
   ```bash
   git add .
   git commit -m "feat: Add amazing feature"
   ```

   **معايير Commit Messages:**
   - `feat:` ميزة جديدة
   - `fix:` إصلاح خطأ
   - `docs:` تحديث وثائق
   - `style:` تنسيق الكود
   - `refactor:` إعادة هيكلة
   - `test:` إضافة اختبارات
   - `chore:` مهام صيانة

6. **Push إلى GitHub**
   ```bash
   git push origin feature/amazing-feature
   ```

7. **افتح Pull Request**
   - اذهب إلى GitHub
   - اضغط "New Pull Request"
   - اشرح التغييرات
   - انتظر المراجعة

---

## 📋 معايير الكود

### PHP/Laravel

```php
// ✅ جيد
class MarkdownController extends Controller
{
    /**
     * تحويل Markdown إلى HTML
     */
    public function convert(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'markdown' => 'required|string|max:1000000',
        ]);

        $html = $this->converter->convert($validated['markdown']);

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }
}
```

### JavaScript

```javascript
// ✅ جيد
function convertMarkdown() {
    const input = document.getElementById('markdown-input').value;

    if (!input.trim()) {
        showNotification('الرجاء إدخال نص', 'warning');
        return;
    }

    try {
        const html = marked.parse(input);
        displayResult(html);
    } catch (error) {
        showError(error.message);
    }
}
```

### Blade Templates

```blade
{{-- ✅ جيد --}}
@extends('layouts.app')

@section('title', 'عنوان الصفحة')

@section('content')
    <div class="container">
        <h1>{{ $title }}</h1>

        @if($items->isNotEmpty())
            @foreach($items as $item)
                <p>{{ $item->name }}</p>
            @endforeach
        @endif
    </div>
@endsection
```

---

## 🧪 الاختبارات

### كتابة Tests

```php
// tests/Feature/MarkdownConversionTest.php
namespace Tests\Feature;

use Tests\TestCase;

class MarkdownConversionTest extends TestCase
{
    public function test_can_convert_markdown_to_html(): void
    {
        $response = $this->postJson('/convert', [
            'markdown' => '# Hello World',
            'engine' => 'commonmark',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                 ])
                 ->assertJsonStructure([
                     'html',
                     'conversion_time',
                 ]);
    }

    public function test_validates_markdown_input(): void
    {
        $response = $this->postJson('/convert', [
            'markdown' => '',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['markdown']);
    }
}
```

### تشغيل Tests

```bash
# جميع الاختبارات
php artisan test

# اختبار معين
php artisan test --filter=MarkdownConversionTest

# مع coverage
php artisan test --coverage
```

---

## 📝 الوثائق

### تحديث README

عند إضافة ميزة جديدة، حدّث:
- قسم المميزات
- أمثلة الاستخدام
- API Documentation
- خطة التطوير

### إضافة تعليقات

```php
/**
 * تحويل Markdown إلى HTML باستخدام محرك معين
 *
 * @param string $markdown النص المراد تحويله
 * @param string $engine المحرك المستخدم (marked, commonmark, rust, python)
 * @param array $options خيارات إضافية للمحرك
 * @return array يحتوي على HTML والإحصائيات
 * @throws \InvalidArgumentException إذا كان المحرك غير معروف
 */
public function convert(string $markdown, string $engine, array $options = []): array
{
    // ...
}
```

---

## 🎨 التصميم والـ UI

### Tailwind CSS Guidelines

```html
<!-- ✅ جيد: استخدم classes وصفية -->
<button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
    تحويل
</button>

<!-- ❌ سيء: inline styles -->
<button style="background: blue; color: white;">
    تحويل
</button>
```

### دعم RTL

```css
/* تأكد من دعم RTL */
.container {
    padding-right: 1rem; /* للعربية */
    padding-left: 1rem;  /* للإنجليزية */
}

/* أو استخدم Tailwind */
<div class="pr-4 pl-4">
```

---

## 🔍 مراجعة الكود (Code Review)

سيتم مراجعة Pull Requests بناءً على:

1. **الوظيفة**: هل تعمل الميزة كما هو متوقع؟
2. **الكود**: هل الكود نظيف ويتبع المعايير؟
3. **الاختبارات**: هل هناك tests كافية؟
4. **الوثائق**: هل تم تحديث الوثائق؟
5. **الأداء**: هل التغييرات تؤثر على الأداء؟

---

## 🚀 أولويات التطوير

### مطلوب بشدة (High Priority)
- Rust Engine Integration
- Python Engine for RTL
- Theme System (20+ themes)

### مطلوب (Medium Priority)
- PDF Export
- DOCX Export
- Advanced Plugins

### مستقبلية (Low Priority)
- Real-time Collaboration
- Cloud Storage
- Multi-language UI

---

## 💬 التواصل

- **GitHub Issues**: للأخطاء والاقتراحات
- **Pull Requests**: للمساهمات
- **Discussions**: للأسئلة والنقاشات

---

## 📜 قواعد السلوك

نتوقع من جميع المساهمين:

1. **الاحترام**: كن محترماً مع الجميع
2. **البناء**: قدم نقد بناء
3. **التعاون**: اعمل مع الفريق
4. **الجودة**: احرص على جودة المساهمات
5. **الصبر**: كن صبوراً في المراجعات

---

## ⭐ نصائح للمساهمين الجدد

1. **ابدأ صغيراً**: ابدأ بإصلاحات بسيطة أو تحسينات في الوثائق
2. **اقرأ الكود**: افهم البنية قبل المساهمة
3. **اسأل**: لا تتردد في طرح الأسئلة
4. **اختبر**: جرب التطبيق قبل المساهمة
5. **تابع**: راجع Pull Requests الأخرى لتتعلم

---

## 🎁 الشكر

كل مساهمة تُقدّر، مهما كانت صغيرة! شكراً لجهودك في تحسين المشروع.

**مساهمون رئيسيون:**
- سيتم إضافة أسماء المساهمين هنا

---

**سعيد بمساهمتك! 🎉**
