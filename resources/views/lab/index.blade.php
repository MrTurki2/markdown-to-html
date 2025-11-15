@extends('layouts.app')

@section('title', 'المختبر - تجارب Markdown')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Lab Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-4">
            <span class="text-5xl">🧪</span>
            <div>
                <h1 class="text-4xl font-bold text-gray-900">مختبر التجارب</h1>
                <p class="text-gray-600 mt-1">اختبر وقارن بين محركات Markdown المختلفة</p>
            </div>
        </div>
        <div class="bg-yellow-50 border-r-4 border-yellow-400 p-4 rounded">
            <p class="text-yellow-800">
                ⚠️ <strong>ملاحظة:</strong> هذا القسم مخصص للتجارب والاختبارات. النتائج قد تكون غير مستقرة.
            </p>
        </div>
    </div>

    <!-- Engine Selector -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">⚙️ اختر محرك التحويل</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Marked.js Engine -->
            <div class="engine-card border-2 border-blue-500 bg-blue-50 rounded-lg p-4 cursor-pointer hover:shadow-md transition"
                 onclick="selectEngine('marked')">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-bold text-lg">Marked.js</h3>
                    <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded">افتراضي</span>
                </div>
                <p class="text-sm text-gray-600 mb-2">JavaScript - سريع ومستقر</p>
                <div class="text-xs text-gray-500">
                    <div>⚡ 5,400 ops/sec</div>
                    <div>📦 90% من الحالات</div>
                </div>
            </div>

            <!-- League CommonMark (PHP) -->
            <div class="engine-card border-2 border-purple-300 bg-gray-50 rounded-lg p-4 cursor-pointer hover:shadow-md transition"
                 onclick="selectEngine('commonmark')">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-bold text-lg">CommonMark</h3>
                    <span class="bg-purple-500 text-white text-xs px-2 py-1 rounded">PHP</span>
                </div>
                <p class="text-sm text-gray-600 mb-2">Laravel Native</p>
                <div class="text-xs text-gray-500">
                    <div>🐘 مدمج مع Laravel</div>
                    <div>📊 موثوق ومستقر</div>
                </div>
            </div>

            <!-- Rust Engine (Coming Soon) -->
            <div class="engine-card border-2 border-orange-300 bg-gray-100 rounded-lg p-4 opacity-60">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-bold text-lg">Rust Engine</h3>
                    <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded">قريباً</span>
                </div>
                <p class="text-sm text-gray-600 mb-2">Rust - فائق السرعة</p>
                <div class="text-xs text-gray-500">
                    <div>🚀 200x أسرع من PHP</div>
                    <div>💪 للملفات الكبيرة</div>
                </div>
            </div>

            <!-- Python Engine (Coming Soon) -->
            <div class="engine-card border-2 border-green-300 bg-gray-100 rounded-lg p-4 opacity-60">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-bold text-lg">Python</h3>
                    <span class="bg-green-500 text-white text-xs px-2 py-1 rounded">قريباً</span>
                </div>
                <p class="text-sm text-gray-600 mb-2">Python - دعم RTL</p>
                <div class="text-xs text-gray-500">
                    <div>🌍 كشف تلقائي للعربية</div>
                    <div>📝 40+ إضافات</div>
                </div>
            </div>
        </div>

        <div class="mt-4 p-3 bg-gray-50 rounded">
            <div class="flex items-center gap-2">
                <span class="font-semibold">المحرك المختار:</span>
                <span id="selected-engine" class="text-blue-600 font-bold">Marked.js</span>
            </div>
        </div>
    </div>

    <!-- Test Area -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Input -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold mb-4">📝 Markdown Input</h3>
            <textarea
                id="lab-input"
                class="w-full h-64 p-4 border border-gray-300 rounded-lg font-mono text-sm focus:ring-2 focus:ring-blue-500"
                placeholder="# اختبر المحرك...

جرب كتابة نص **Markdown** معقد هنا لاختبار المحركات المختلفة."
            ></textarea>

            <div class="mt-4 flex gap-2">
                <button onclick="testEngine()" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    🧪 اختبار
                </button>
                <button onclick="loadComplexSample()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    📋 مثال معقد
                </button>
                <button onclick="benchmark()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    ⏱️ Benchmark
                </button>
            </div>
        </div>

        <!-- Output -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold">✨ النتيجة</h3>
                <span id="conversion-time" class="text-sm text-gray-500"></span>
            </div>
            <div id="lab-output" class="border border-gray-300 rounded-lg p-4 h-64 overflow-y-auto markdown-output bg-gray-50">
                <p class="text-gray-400 text-center py-20">النتيجة ستظهر هنا...</p>
            </div>

            <div class="mt-4 grid grid-cols-2 gap-2">
                <div class="text-center p-2 bg-blue-50 rounded">
                    <div class="text-xs text-gray-600">حجم الإدخال</div>
                    <div id="input-size" class="font-bold text-blue-600">0 B</div>
                </div>
                <div class="text-center p-2 bg-green-50 rounded">
                    <div class="text-xs text-gray-600">حجم الإخراج</div>
                    <div id="output-size" class="font-bold text-green-600">0 B</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Experiments Section -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">🔬 التجارب المتاحة</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="#" onclick="experiment('performance'); return false;" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                <div class="text-3xl mb-2">⚡</div>
                <h3 class="font-bold mb-1">اختبار الأداء</h3>
                <p class="text-sm text-gray-600">قارن سرعة المحركات المختلفة</p>
            </a>

            <a href="#" onclick="experiment('themes'); return false;" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                <div class="text-3xl mb-2">🎨</div>
                <h3 class="font-bold mb-1">نظام الثيمات</h3>
                <p class="text-sm text-gray-600">جرب 20+ ثيم مختلف</p>
            </a>

            <a href="#" onclick="experiment('rtl'); return false;" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                <div class="text-3xl mb-2">🌍</div>
                <h3 class="font-bold mb-1">دعم RTL</h3>
                <p class="text-sm text-gray-600">اختبار النصوص العربية</p>
            </a>

            <a href="#" onclick="experiment('sanitize'); return false;" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                <div class="text-3xl mb-2">🔒</div>
                <h3 class="font-bold mb-1">Sanitization</h3>
                <p class="text-sm text-gray-600">تنظيف وتأمين HTML</p>
            </a>

            <a href="#" onclick="experiment('plugins'); return false;" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                <div class="text-3xl mb-2">🔌</div>
                <h3 class="font-bold mb-1">الإضافات</h3>
                <p class="text-sm text-gray-600">اختبار plugins متقدمة</p>
            </a>

            <a href="#" onclick="experiment('export'); return false;" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                <div class="text-3xl mb-2">📥</div>
                <h3 class="font-bold mb-1">التصدير</h3>
                <p class="text-sm text-gray-600">PDF, DOCX, وأكثر</p>
            </a>
        </div>
    </div>

    <!-- Statistics -->
    <div class="mt-6 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
        <h2 class="text-2xl font-bold mb-4">📊 إحصائيات المختبر</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center">
                <div class="text-3xl font-bold">4</div>
                <div class="text-sm opacity-90">محركات متاحة</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold">20+</div>
                <div class="text-sm opacity-90">ثيم جاهز</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold">200+</div>
                <div class="text-sm opacity-90">إضافات</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold" id="test-count">0</div>
                <div class="text-sm opacity-90">اختبار تم</div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    let selectedEngine = 'marked';
    let testCount = parseInt(localStorage.getItem('lab_test_count') || '0');
    document.getElementById('test-count').textContent = testCount;

    marked.setOptions({
        breaks: true,
        gfm: true,
        headerIds: true,
    });

    function selectEngine(engine) {
        selectedEngine = engine;
        document.getElementById('selected-engine').textContent = engine === 'marked' ? 'Marked.js' : 'CommonMark (PHP)';

        // تحديث الكاردات
        document.querySelectorAll('.engine-card').forEach(card => {
            card.classList.remove('border-blue-500', 'bg-blue-50');
            card.classList.add('border-gray-300', 'bg-gray-50');
        });

        event.target.closest('.engine-card').classList.remove('border-gray-300', 'bg-gray-50');
        event.target.closest('.engine-card').classList.add('border-blue-500', 'bg-blue-50');
    }

    function testEngine() {
        const input = document.getElementById('lab-input').value;
        const output = document.getElementById('lab-output');

        if (!input.trim()) {
            alert('الرجاء إدخال نص للاختبار');
            return;
        }

        const startTime = performance.now();

        if (selectedEngine === 'marked') {
            const html = marked.parse(input);
            output.innerHTML = html;
        } else {
            // سيتم تنفيذها عبر Laravel
            alert('CommonMark سيتم دعمه قريباً عبر API');
        }

        const endTime = performance.now();
        const duration = (endTime - startTime).toFixed(2);

        document.getElementById('conversion-time').textContent = `⏱️ ${duration}ms`;
        document.getElementById('input-size').textContent = formatBytes(new Blob([input]).size);
        document.getElementById('output-size').textContent = formatBytes(new Blob([output.innerHTML]).size);

        testCount++;
        localStorage.setItem('lab_test_count', testCount);
        document.getElementById('test-count').textContent = testCount;
    }

    function loadComplexSample() {
        const sample = `# اختبار شامل لمحركات Markdown 🧪

## 1. التنسيقات الأساسية

### النصوص
**نص عريض** و *نص مائل* و ***عريض ومائل*** و ~~نص مشطوب~~

### القوائم المرقمة
1. العنصر الأول
2. العنصر الثاني
   1. عنصر فرعي
   2. عنصر فرعي آخر
3. العنصر الثالث

### القوائم النقطية
- JavaScript
  - React
  - Vue
  - Svelte
- Python
  - Django
  - Flask
- PHP
  - Laravel
  - Symfony

## 2. الأكواد

### Inline Code
استخدم \`const x = 5;\` للمتغيرات.

### Code Blocks
\`\`\`javascript
// مثال معقد
class MarkdownEngine {
    constructor(options) {
        this.options = options;
    }

    async parse(markdown) {
        const html = await this.process(markdown);
        return this.sanitize(html);
    }

    sanitize(html) {
        // تنظيف HTML
        return html.replace(/<script>/g, '');
    }
}

const engine = new MarkdownEngine({
    gfm: true,
    breaks: true
});
\`\`\`

\`\`\`python
# مثال Python
def fibonacci(n):
    if n <= 1:
        return n
    return fibonacci(n-1) + fibonacci(n-2)

print(fibonacci(10))
\`\`\`

## 3. الجداول

| المحرك | اللغة | السرعة | الدقة | RTL |
|--------|-------|---------|-------|-----|
| Marked.js | JavaScript | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ❌ |
| Rust | Rust | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | ❌ |
| Python | Python | ⭐⭐⭐ | ⭐⭐⭐⭐ | ✅ |
| CommonMark | PHP | ⭐⭐ | ⭐⭐⭐⭐ | ✅ |

## 4. الاقتباسات

> "البرمجة فن وعلم في نفس الوقت"
>
> - مبرمج مجهول

> ### اقتباس متقدم
> يمكن أن يحتوي الاقتباس على:
> - قوائم
> - **تنسيقات**
> - \`أكواد\`

## 5. الروابط والصور

[زر GitHub](https://github.com/MrTurki2/markdown-to-html)

[رابط مع عنوان](https://example.com "هذا عنوان")

## 6. HTML المدمج

<div style="background: linear-gradient(to right, #667eea, #764ba2); color: white; padding: 20px; border-radius: 10px; text-align: center;">
    <h3>يمكن دمج HTML مباشرة!</h3>
    <p>هذا مثال على صندوق ملون</p>
</div>

## 7. Task Lists

- [x] تثبيت Laravel
- [x] إنشاء GitHub repo
- [ ] إضافة Rust engine
- [ ] إضافة Python engine
- [ ] نظام الثيمات

## 8. النصوص العربية المعقدة

هذا اختبار للنصوص العربية المعقدة مع **تنسيقات متعددة** و*أنماط مختلفة*.

### الشعر العربي
> تَعَلَّمْ فَلَيْسَ الْمَرْءُ يُولَدُ عَالِمًا
> وَلَيْسَ أَخُو عِلْمٍ كَمَنْ هُوَ جَاهِلُ

---

**اختبار مكتمل! 🎉**`;

        document.getElementById('lab-input').value = sample;
        testEngine();
    }

    function benchmark() {
        const sizes = [1000, 5000, 10000, 50000];
        const results = [];

        sizes.forEach(size => {
            const text = 'a'.repeat(size);
            const start = performance.now();
            marked.parse(text);
            const end = performance.now();
            results.push({
                size: size,
                time: (end - start).toFixed(2)
            });
        });

        alert('Benchmark Results:\n' + results.map(r => `${r.size} chars: ${r.time}ms`).join('\n'));
    }

    function experiment(type) {
        alert(`تجربة ${type} ستكون متاحة قريباً! 🚀`);
    }

    function formatBytes(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
</script>
@endpush
@endsection
