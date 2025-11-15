<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>محول Markdown إلى PDF - Test5</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;600;700&display=swap');

        body {
            font-family: 'Noto Kufi Arabic', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .preview-container {
            font-family: 'Noto Kufi Arabic', sans-serif;
        }

        .preview-container h1 {
            font-size: 2.5em;
            font-weight: 700;
            color: #1a202c;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
            margin: 20px 0;
        }

        .preview-container h2 {
            font-size: 2em;
            font-weight: 600;
            color: #2d3748;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 8px;
            margin: 18px 0;
        }

        .preview-container h3 {
            font-size: 1.5em;
            font-weight: 600;
            color: #2d3748;
            margin: 15px 0;
        }

        .preview-container p {
            line-height: 1.8;
            margin: 15px 0;
        }

        .preview-container blockquote {
            border-right: 4px solid #667eea;
            padding-right: 20px;
            margin: 20px 0;
            color: #4a5568;
            font-style: italic;
            background: #f7fafc;
            padding: 15px 20px;
            border-radius: 5px;
        }

        .preview-container code {
            background: #2d3748;
            color: #68d391;
            padding: 3px 8px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }

        .preview-container pre {
            background: #2d3748;
            color: #68d391;
            padding: 20px;
            border-radius: 8px;
            overflow-x: auto;
            margin: 20px 0;
        }

        .preview-container ul, .preview-container ol {
            padding-right: 30px;
            margin: 15px 0;
        }

        .preview-container li {
            margin: 8px 0;
        }

        .preview-container table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .preview-container table th,
        .preview-container table td {
            border: 1px solid #cbd5e0;
            padding: 12px;
            text-align: right;
        }

        .preview-container table th {
            background: #667eea;
            color: white;
            font-weight: 600;
        }

        .preview-container table tr:nth-child(even) {
            background: #f7fafc;
        }

        .loading-spinner {
            display: none;
            animation: spin 1s linear infinite;
        }

        .loading-spinner.show {
            display: inline-block;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="gradient-bg text-white py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-center mb-2">🚀 محول Markdown إلى PDF</h1>
            <p class="text-center text-xl">مع دعم كامل للغة العربية والتنسيقات</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Markdown Input Section -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">📝 نص Markdown</h2>
                    <button onclick="loadExample()" class="text-sm bg-purple-100 text-purple-700 px-3 py-1 rounded-lg hover:bg-purple-200">
                        تحميل مثال
                    </button>
                </div>
                <textarea
                    id="markdown-input"
                    class="w-full h-96 p-4 border-2 border-gray-300 rounded-lg font-mono text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                    placeholder="اكتب نص Markdown هنا..."># عنوان الوثيقة الرئيسي

## مقدمة
هذا مثال على وثيقة **Markdown** باللغة العربية التي سيتم تحويلها إلى *PDF* احترافي.

### المميزات:
- دعم كامل للغة العربية 🌟
- تنسيقات متنوعة وجميلة
- جداول منظمة
- أكواد برمجية

> "التقنية تجعل الحياة أسهل وأجمل" - مقولة ملهمة

---

## جدول البيانات

| الاسم | الوظيفة | الخبرة |
|------|---------|--------|
| أحمد | مطور ويب | 5 سنوات |
| فاطمة | مصممة UI | 3 سنوات |
| خالد | محلل بيانات | 7 سنوات |

### مثال على كود برمجي:
```javascript
function convertToPDF() {
    console.log("تحويل إلى PDF...");
    return "نجح التحويل!";
}
```

## الخاتمة
هذا المحول يدعم جميع عناصر Markdown مع الحفاظ على جودة التنسيق في ملف PDF النهائي.

**تم إنشاء هذه الوثيقة باستخدام محول Markdown إلى PDF** ✨</textarea>
            </div>

            <!-- Preview Section -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">👁️ معاينة</h2>
                <div id="preview" class="preview-container h-96 overflow-y-auto border-2 border-gray-200 rounded-lg p-4">
                    <p class="text-gray-500 text-center">المعاينة ستظهر هنا...</p>
                </div>
            </div>
        </div>

        <!-- Actions Section -->
        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="flex gap-2 items-center">
                    <input
                        type="text"
                        id="filename"
                        placeholder="اسم الملف"
                        value="document"
                        class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    >
                    <select
                        id="pdf-options"
                        class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    >
                        <option value="A4">A4</option>
                        <option value="A5">A5</option>
                        <option value="Letter">Letter</option>
                    </select>
                </div>

                <div class="flex gap-3">
                    <button
                        onclick="generatePDF()"
                        class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition-all flex items-center gap-2"
                    >
                        <svg class="loading-spinner w-5 h-5" id="loading-spinner" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span id="generate-btn-text">📄 تحويل إلى PDF</span>
                    </button>

                    <button
                        onclick="downloadHTML()"
                        class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-6 py-3 rounded-lg font-semibold hover:shadow-lg transition-all"
                    >
                        🌐 تحميل HTML
                    </button>
                </div>
            </div>

            <!-- PDF Settings -->
            <details class="mt-4">
                <summary class="cursor-pointer text-purple-600 font-semibold">⚙️ إعدادات PDF المتقدمة</summary>
                <div class="mt-3 grid grid-cols-2 md:grid-cols-4 gap-3">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" id="include-toc" class="rounded">
                        <span class="text-sm">فهرس المحتويات</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" id="include-page-numbers" checked class="rounded">
                        <span class="text-sm">أرقام الصفحات</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" id="include-header" checked class="rounded">
                        <span class="text-sm">رأس الصفحة</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" id="include-footer" checked class="rounded">
                        <span class="text-sm">تذييل الصفحة</span>
                    </label>
                </div>
            </details>
        </div>

        <!-- Status Messages -->
        <div id="status-message" class="hidden fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg animate-pulse">
            <span id="status-text">جاري المعالجة...</span>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        const markdownInput = document.getElementById('markdown-input');
        const preview = document.getElementById('preview');
        const loadingSpinner = document.getElementById('loading-spinner');
        const generateBtnText = document.getElementById('generate-btn-text');

        // Update preview on input
        markdownInput.addEventListener('input', updatePreview);

        // Initial preview
        updatePreview();

        function updatePreview() {
            const markdown = markdownInput.value;

            if (!markdown.trim()) {
                preview.innerHTML = '<p class="text-gray-500 text-center">المعاينة ستظهر هنا...</p>';
                return;
            }

            // Configure marked for Arabic support
            marked.setOptions({
                breaks: true,
                gfm: true,
                tables: true,
                sanitize: false
            });

            const html = marked.parse(markdown);
            preview.innerHTML = html;
        }

        function loadExample() {
            markdownInput.value = `# تقرير المبيعات السنوي 2024

## الملخص التنفيذي
نقدم لكم تقرير المبيعات السنوي الذي يوضح **الإنجازات** و*التحديات* التي واجهناها خلال العام.

### النقاط الرئيسية:
1. نمو المبيعات بنسبة **35%**
2. توسع في 5 أسواق جديدة
3. إطلاق 3 منتجات مبتكرة

## البيانات المالية

| الربع | المبيعات (مليون ريال) | النمو % |
|-------|----------------------|---------|
| الأول | 12.5 | 15% |
| الثاني | 15.8 | 26% |
| الثالث | 18.2 | 15% |
| الرابع | 22.1 | 21% |

### تحليل الأداء
> "لقد حققنا نتائج استثنائية تجاوزت التوقعات بفضل جهود الفريق المتميز" - المدير التنفيذي

#### المناطق الأكثر نمواً:
- **الرياض**: 40% من إجمالي المبيعات
- **جدة**: 25% من إجمالي المبيعات
- **الدمام**: 20% من إجمالي المبيعات
- **مناطق أخرى**: 15%

### الخطط المستقبلية
\`\`\`
الأهداف لعام 2025:
- زيادة المبيعات بنسبة 40%
- افتتاح 10 فروع جديدة
- إطلاق منصة التجارة الإلكترونية
\`\`\`

---

## الخاتمة
نتطلع إلى عام مليء بالنجاحات والإنجازات الجديدة.

**شكراً لثقتكم** 🙏

*تم إعداد هذا التقرير بواسطة: قسم المبيعات والتسويق*`;
            updatePreview();
            showStatus('تم تحميل المثال!', 'success');
        }

        function generatePDF() {
            const markdown = markdownInput.value;
            const filename = document.getElementById('filename').value || 'document';

            if (!markdown.trim()) {
                showStatus('الرجاء إدخال نص Markdown أولاً!', 'error');
                return;
            }

            // Show loading
            loadingSpinner.classList.add('show');
            generateBtnText.textContent = 'جاري التحويل...';

            // Convert markdown to HTML
            const html = marked.parse(markdown);

            // Get options
            const pageSize = document.getElementById('pdf-options').value;
            const includePageNumbers = document.getElementById('include-page-numbers').checked;
            const includeHeader = document.getElementById('include-header').checked;
            const includeFooter = document.getElementById('include-footer').checked;

            // Send to server
            fetch('/generate-pdf', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    markdown: markdown,
                    html: html,
                    filename: filename,
                    options: {
                        pageSize: pageSize,
                        pageNumbers: includePageNumbers,
                        header: includeHeader,
                        footer: includeFooter
                    }
                })
            })
            .then(response => response.blob())
            .then(blob => {
                // Download PDF
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename + '.pdf';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);

                showStatus('تم تحويل وتحميل ملف PDF بنجاح!', 'success');
            })
            .catch(error => {
                console.error('Error:', error);
                showStatus('حدث خطأ في تحويل PDF', 'error');
            })
            .finally(() => {
                // Hide loading
                loadingSpinner.classList.remove('show');
                generateBtnText.textContent = '📄 تحويل إلى PDF';
            });
        }

        function downloadHTML() {
            const markdown = markdownInput.value;
            const filename = document.getElementById('filename').value || 'document';

            if (!markdown.trim()) {
                showStatus('الرجاء إدخال نص Markdown أولاً!', 'error');
                return;
            }

            const html = marked.parse(markdown);
            const fullHTML = `<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${filename}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;600;700&display=swap');
        body {
            font-family: 'Noto Kufi Arabic', sans-serif;
            line-height: 1.8;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
            direction: rtl;
        }
        h1 { color: #1a202c; border-bottom: 3px solid #667eea; padding-bottom: 10px; }
        h2 { color: #2d3748; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; }
        h3 { color: #2d3748; }
        blockquote { border-right: 4px solid #667eea; padding: 15px 20px; background: #f7fafc; }
        code { background: #2d3748; color: #68d391; padding: 3px 8px; border-radius: 3px; }
        pre { background: #2d3748; color: #68d391; padding: 20px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { border: 1px solid #cbd5e0; padding: 12px; }
        table th { background: #667eea; color: white; }
    </style>
</head>
<body>
${html}
</body>
</html>`;

            const blob = new Blob([fullHTML], { type: 'text/html;charset=utf-8' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename + '.html';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);

            showStatus('تم تحميل ملف HTML بنجاح!', 'success');
        }

        function showStatus(message, type = 'success') {
            const statusMessage = document.getElementById('status-message');
            const statusText = document.getElementById('status-text');

            statusText.textContent = message;
            statusMessage.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg animate-pulse ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white`;

            setTimeout(() => {
                statusMessage.classList.add('hidden');
            }, 3000);
        }
    </script>
</body>
</html>