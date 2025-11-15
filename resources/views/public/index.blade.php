@extends('layouts.app')

@section('title', 'محول Markdown إلى HTML - بسيط وسريع')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <h1 class="text-5xl font-bold text-gray-900 mb-4">
            حول نص Markdown إلى HTML جميل
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            الصق نص Markdown الخاص بك واحصل على HTML منسق وجميل فوراً. بسيط، سريع، ومجاني تماماً.
        </p>
    </div>

    <!-- Main Converter -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Input Section -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-800">📝 Markdown Input</h2>
                <button onclick="clearInput()" class="text-sm text-red-500 hover:text-red-700">
                    مسح
                </button>
            </div>

            <textarea
                id="markdown-input"
                class="w-full h-96 p-4 border border-gray-300 rounded-lg font-mono text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                placeholder="# مرحباً بك! 👋

اكتب أو الصق نص **Markdown** هنا...

## المميزات:
- تحويل فوري
- معاينة مباشرة
- دعم كامل لـ RTL والعربية
- تصدير HTML

```javascript
console.log('مثال على الكود');
```

> نصيحة: جرب كتابة Markdown وشاهد النتيجة مباشرة!"
            >{{ old('markdown', $sampleMarkdown ?? '') }}</textarea>

            <div class="mt-4 flex gap-2">
                <button
                    onclick="convertMarkdown()"
                    class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold shadow-md"
                >
                    🚀 تحويل الآن
                </button>
                <button
                    onclick="loadSample()"
                    class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition"
                >
                    📋 مثال
                </button>
            </div>
        </div>

        <!-- Output Section -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-800">✨ HTML Preview</h2>
                <div class="flex gap-2">
                    <button onclick="copyHTML()" class="text-sm text-blue-500 hover:text-blue-700">
                        📋 نسخ HTML
                    </button>
                    <button onclick="downloadHTML()" class="text-sm text-green-500 hover:text-green-700">
                        💾 تحميل
                    </button>
                </div>
            </div>

            <div class="border border-gray-300 rounded-lg overflow-hidden">
                <div id="html-preview" class="p-6 bg-white h-96 overflow-y-auto markdown-output">
                    <div class="text-center text-gray-400 py-20">
                        <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-lg">المعاينة ستظهر هنا بعد التحويل</p>
                    </div>
                </div>
            </div>

            <textarea
                id="html-output"
                class="hidden w-full h-96 p-4 border border-gray-300 rounded-lg font-mono text-sm mt-4"
                readonly
            ></textarea>
        </div>
    </div>

    <!-- Features Section -->
    <div class="mt-16">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">لماذا تستخدم هذه الأداة؟</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="text-4xl mb-4">⚡</div>
                <h3 class="text-xl font-bold mb-2">سريع وفوري</h3>
                <p class="text-gray-600">تحويل فوري بدون تأخير. استخدام Marked.js للحصول على أفضل أداء.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="text-4xl mb-4">🎨</div>
                <h3 class="text-xl font-bold mb-2">تنسيق جميل</h3>
                <p class="text-gray-600">HTML منسق باحترافية مع دعم كامل للعربية والـ RTL.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="text-4xl mb-4">🔒</div>
                <h3 class="text-xl font-bold mb-2">آمن ومجاني</h3>
                <p class="text-gray-600">لا يتم حفظ أي بيانات. كل شيء يتم محلياً في متصفحك.</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    // تكوين Marked.js
    marked.setOptions({
        breaks: true,
        gfm: true,
        headerIds: true,
        mangle: false
    });

    function convertMarkdown() {
        const input = document.getElementById('markdown-input').value;
        const preview = document.getElementById('html-preview');
        const output = document.getElementById('html-output');

        if (!input.trim()) {
            preview.innerHTML = '<div class="text-center text-gray-400 py-20"><p class="text-lg">الرجاء إدخال نص Markdown أولاً</p></div>';
            return;
        }

        try {
            const html = marked.parse(input);
            preview.innerHTML = html;
            output.value = html;

            // إضافة رسالة نجاح
            showNotification('تم التحويل بنجاح! ✅', 'success');
        } catch (error) {
            preview.innerHTML = `<div class="text-red-500 p-4">خطأ في التحويل: ${error.message}</div>`;
            showNotification('حدث خطأ في التحويل ❌', 'error');
        }
    }

    function clearInput() {
        document.getElementById('markdown-input').value = '';
        document.getElementById('html-preview').innerHTML = '<div class="text-center text-gray-400 py-20"><p class="text-lg">المعاينة ستظهر هنا بعد التحويل</p></div>';
        document.getElementById('html-output').value = '';
    }

    function loadSample() {
        const sample = `# مثال على Markdown 📝

## مقدمة
مرحباً بك في **محول Markdown** الأفضل! هذا مثال يوضح قدرات التحويل.

### المميزات الرئيسية:
- تحويل فوري وسريع ⚡
- دعم كامل للعربية والـ RTL 🌍
- معاينة مباشرة 👀
- تصدير HTML نظيف 💾

## أمثلة على التنسيق

### النصوص
يمكنك استخدام **نص عريض** و *نص مائل* و ~~نص مشطوب~~.

### القوائم
1. عنصر أول
2. عنصر ثاني
   - عنصر فرعي
   - عنصر فرعي آخر
3. عنصر ثالث

### الأكواد
\`\`\`javascript
function greet(name) {
    console.log(\`مرحباً \${name}!\`);
}
greet('العالم');
\`\`\`

### الاقتباس
> "البرمجة ليست عن الكتابة، بل عن التفكير"

### الروابط
زر [موقعنا على GitHub](https://github.com/MrTurki2/markdown-to-html)

### الجداول
| اللغة | المستوى | الاستخدام |
|------|---------|-----------|
| JavaScript | متقدم | Frontend |
| PHP | متقدم | Backend |
| Python | متوسط | Data |

---

جرب الآن! 🚀`;

        document.getElementById('markdown-input').value = sample;
        convertMarkdown();
    }

    function copyHTML() {
        const output = document.getElementById('html-output');
        const preview = document.getElementById('html-preview');

        if (!preview.querySelector('.markdown-output')) {
            showNotification('لا يوجد محتوى للنسخ', 'warning');
            return;
        }

        output.classList.remove('hidden');
        output.select();
        document.execCommand('copy');
        output.classList.add('hidden');

        showNotification('تم نسخ HTML! 📋', 'success');
    }

    function downloadHTML() {
        const output = document.getElementById('html-output').value;

        if (!output) {
            showNotification('لا يوجد محتوى للتحميل', 'warning');
            return;
        }

        const fullHTML = `<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Converted Document</title>
    <style>
        body {
            font-family: 'Cairo', 'Segoe UI', Tahoma, sans-serif;
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            line-height: 1.8;
        }
        h1 { font-size: 2.5rem; margin-bottom: 1rem; }
        h2 { font-size: 2rem; margin-bottom: 0.75rem; }
        h3 { font-size: 1.5rem; margin-bottom: 0.5rem; }
        code {
            background-color: #f4f4f4;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-family: monospace;
        }
        pre {
            background-color: #2d3748;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
        }
        blockquote {
            border-right: 4px solid #4299e1;
            padding-right: 1rem;
            color: #718096;
            font-style: italic;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 0.75rem;
            text-align: right;
        }
        th {
            background-color: #f7fafc;
        }
    </style>
</head>
<body>
${output}
</body>
</html>`;

        const blob = new Blob([fullHTML], { type: 'text/html' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'converted-' + Date.now() + '.html';
        a.click();
        window.URL.revokeObjectURL(url);

        showNotification('تم التحميل بنجاح! 💾', 'success');
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 left-1/2 transform -translate-x-1/2 px-6 py-3 rounded-lg shadow-lg text-white font-semibold z-50 ${
            type === 'success' ? 'bg-green-500' :
            type === 'error' ? 'bg-red-500' :
            'bg-yellow-500'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // تحويل تلقائي عند الكتابة (اختياري)
    document.getElementById('markdown-input').addEventListener('input', function() {
        // يمكن تفعيل هذا للتحويل التلقائي
        // convertMarkdown();
    });

    // اختصارات لوحة المفاتيح
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey || e.metaKey) {
            if (e.key === 'Enter') {
                e.preventDefault();
                convertMarkdown();
            }
        }
    });
</script>
@endpush
@endsection
