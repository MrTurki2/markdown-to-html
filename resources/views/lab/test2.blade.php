<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>محول Markdown مع الحفظ - Test2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .markdown-preview {
            min-height: 400px;
        }
        .markdown-preview h1 { font-size: 2em; font-weight: bold; margin: 0.5em 0; }
        .markdown-preview h2 { font-size: 1.5em; font-weight: bold; margin: 0.5em 0; }
        .markdown-preview h3 { font-size: 1.2em; font-weight: bold; margin: 0.5em 0; }
        .markdown-preview p { margin: 1em 0; }
        .markdown-preview ul { list-style-type: disc; margin-right: 2em; }
        .markdown-preview ol { list-style-type: decimal; margin-right: 2em; }
        .markdown-preview blockquote { border-right: 4px solid #ddd; padding-right: 1em; color: #666; }
        .markdown-preview code { background: #f4f4f4; padding: 2px 4px; border-radius: 3px; }
        .markdown-preview pre { background: #f4f4f4; padding: 1em; border-radius: 5px; overflow-x: auto; }
        .markdown-preview table { border-collapse: collapse; width: 100%; margin: 1em 0; }
        .markdown-preview table td, .markdown-preview table th { border: 1px solid #ddd; padding: 8px; }
        .markdown-preview table th { background: #f4f4f4; font-weight: bold; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-6">
            <h1 class="text-4xl font-bold text-center mb-2 text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
                محول Markdown المتقدم
            </h1>
            <p class="text-center text-gray-600">مع إمكانية الحفظ والتحميل</p>
        </div>

        <!-- File Management Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">اسم الملف</label>
                    <input
                        type="text"
                        id="filename"
                        placeholder="my-document"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="document"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الإجراءات</label>
                    <div class="flex gap-2">
                        <button
                            id="save-btn"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V2"></path>
                            </svg>
                            حفظ
                        </button>
                        <button
                            id="download-html-btn"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            تحميل HTML
                        </button>
                        <button
                            id="download-md-btn"
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            تحميل MD
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">الملفات المحفوظة</label>
                    <select
                        id="saved-files"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="">-- اختر ملف محفوظ --</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Markdown Input -->
            <div class="bg-white rounded-xl shadow-lg">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-6 py-4 rounded-t-xl">
                    <h2 class="text-xl font-semibold flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        نص Markdown
                    </h2>
                </div>
                <div class="p-6">
                    <div class="mb-3 flex gap-2">
                        <button onclick="insertMarkdown('**', '**')" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300" title="عريض">B</button>
                        <button onclick="insertMarkdown('*', '*')" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 italic" title="مائل">I</button>
                        <button onclick="insertMarkdown('# ', '')" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300" title="عنوان">H1</button>
                        <button onclick="insertMarkdown('## ', '')" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300" title="عنوان فرعي">H2</button>
                        <button onclick="insertMarkdown('- ', '')" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300" title="قائمة">•</button>
                        <button onclick="insertMarkdown('[', '](url)')" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300" title="رابط">🔗</button>
                        <button onclick="insertMarkdown('```\n', '\n```')" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300" title="كود">&lt;/&gt;</button>
                        <button onclick="insertTable()" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300" title="جدول">⊞</button>
                    </div>
                    <textarea
                        id="markdown-input"
                        class="w-full h-96 p-4 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono"
                        placeholder="اكتب نص Markdown هنا..."># مرحباً في محول Markdown المتقدم

## المميزات الجديدة:
- 💾 **حفظ الملفات** في قاعدة البيانات
- 📥 تحميل الملفات بصيغة HTML و MD
- 🎨 واجهة محسّنة وجذابة
- ⚡ معاينة فورية

### مثال على جدول:
| العمود الأول | العمود الثاني | العمود الثالث |
|-------------|--------------|--------------|
| خلية 1 | خلية 2 | خلية 3 |
| خلية 4 | خلية 5 | خلية 6 |

### مثال على الكود:
```javascript
function convertMarkdown(text) {
    return marked(text);
}
```

> "البرمجة ليست مجرد كتابة كود، بل هي فن حل المشكلات" - مجهول

---

**جرّب** *كل* `المميزات` الآن!</textarea>
                </div>
            </div>

            <!-- HTML Preview -->
            <div class="bg-white rounded-xl shadow-lg">
                <div class="bg-gradient-to-r from-green-500 to-teal-500 text-white px-6 py-4 rounded-t-xl">
                    <h2 class="text-xl font-semibold flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        معاينة HTML
                    </h2>
                </div>
                <div class="p-6">
                    <div id="html-preview" class="markdown-preview p-4 border-2 border-gray-300 rounded-lg bg-gray-50 overflow-auto h-96">
                        <p class="text-gray-500">المعاينة ستظهر هنا...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- HTML Code Output -->
        <div class="mt-6 bg-white rounded-xl shadow-lg">
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-6 py-4 rounded-t-xl flex justify-between items-center">
                <h2 class="text-xl font-semibold flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                    كود HTML
                </h2>
                <button
                    id="copy-html"
                    class="px-4 py-2 bg-white/20 backdrop-blur text-white rounded-lg hover:bg-white/30 transition-all flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    نسخ الكود
                </button>
            </div>
            <div class="p-6">
                <pre id="html-code" class="p-4 bg-gray-900 text-gray-100 rounded-lg overflow-x-auto max-h-64"><code class="text-sm">كود HTML سيظهر هنا...</code></pre>
            </div>
        </div>

        <!-- Success Message -->
        <div id="success-message" class="hidden fixed bottom-4 left-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-pulse">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="success-text">تمت العملية بنجاح!</span>
        </div>
    </div>

    <script>
        const markdownInput = document.getElementById('markdown-input');
        const htmlPreview = document.getElementById('html-preview');
        const htmlCode = document.getElementById('html-code');
        const copyButton = document.getElementById('copy-html');
        const saveBtn = document.getElementById('save-btn');
        const downloadHtmlBtn = document.getElementById('download-html-btn');
        const downloadMdBtn = document.getElementById('download-md-btn');
        const filenameInput = document.getElementById('filename');
        const savedFilesSelect = document.getElementById('saved-files');
        const successMessage = document.getElementById('success-message');
        const successText = document.getElementById('success-text');

        // Convert markdown on input
        markdownInput.addEventListener('input', convertMarkdown);

        // Initial conversion
        convertMarkdown();
        loadSavedFiles();

        function convertMarkdown() {
            const markdown = markdownInput.value;

            if (!markdown) {
                htmlPreview.innerHTML = '<p class="text-gray-500">المعاينة ستظهر هنا...</p>';
                htmlCode.textContent = 'كود HTML سيظهر هنا...';
                return;
            }

            fetch('/convert', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ markdown: markdown })
            })
            .then(response => response.json())
            .then(data => {
                htmlPreview.innerHTML = data.html;
                htmlCode.textContent = data.html;
            })
            .catch(error => {
                console.error('Error:', error);
                htmlPreview.innerHTML = '<p class="text-red-500">حدث خطأ في التحويل</p>';
            });
        }

        // Save file
        saveBtn.addEventListener('click', () => {
            const filename = filenameInput.value || 'document';
            const markdown = markdownInput.value;
            const html = htmlCode.textContent;

            if (!markdown) {
                showMessage('لا يوجد محتوى للحفظ!', 'error');
                return;
            }

            fetch('/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    filename: filename,
                    markdown: markdown,
                    html: html
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('تم حفظ الملف بنجاح!', 'success');
                    loadSavedFiles();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('حدث خطأ في حفظ الملف', 'error');
            });
        });

        // Load saved files
        function loadSavedFiles() {
            fetch('/files')
            .then(response => response.json())
            .then(data => {
                savedFilesSelect.innerHTML = '<option value="">-- اختر ملف محفوظ --</option>';
                data.files.forEach(file => {
                    const option = document.createElement('option');
                    option.value = file.id;
                    option.textContent = file.filename + ' - ' + new Date(file.created_at).toLocaleDateString('ar');
                    savedFilesSelect.appendChild(option);
                });
            });
        }

        // Load selected file
        savedFilesSelect.addEventListener('change', (e) => {
            const fileId = e.target.value;
            if (!fileId) return;

            fetch(`/file/${fileId}`)
            .then(response => response.json())
            .then(data => {
                if (data.file) {
                    markdownInput.value = data.file.markdown;
                    filenameInput.value = data.file.filename;
                    convertMarkdown();
                    showMessage('تم تحميل الملف بنجاح!', 'success');
                }
            });
        });

        // Download HTML
        downloadHtmlBtn.addEventListener('click', () => {
            const filename = filenameInput.value || 'document';
            const html = htmlCode.textContent;

            if (html === 'كود HTML سيظهر هنا...') {
                showMessage('لا يوجد محتوى للتحميل!', 'error');
                return;
            }

            const fullHtml = `<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${filename}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; max-width: 800px; margin: 0 auto; }
        h1, h2, h3 { color: #333; }
        code { background: #f4f4f4; padding: 2px 5px; border-radius: 3px; }
        pre { background: #f4f4f4; padding: 10px; border-radius: 5px; overflow-x: auto; }
        blockquote { border-right: 4px solid #ddd; padding-right: 10px; color: #666; }
        table { border-collapse: collapse; width: 100%; }
        table td, table th { border: 1px solid #ddd; padding: 8px; }
        table th { background: #f4f4f4; }
    </style>
</head>
<body>
${html}
</body>
</html>`;

            downloadFile(fullHtml, filename + '.html', 'text/html');
            showMessage('تم تحميل ملف HTML!', 'success');
        });

        // Download Markdown
        downloadMdBtn.addEventListener('click', () => {
            const filename = filenameInput.value || 'document';
            const markdown = markdownInput.value;

            if (!markdown) {
                showMessage('لا يوجد محتوى للتحميل!', 'error');
                return;
            }

            downloadFile(markdown, filename + '.md', 'text/markdown');
            showMessage('تم تحميل ملف Markdown!', 'success');
        });

        // Helper function to download file
        function downloadFile(content, filename, mimeType) {
            const blob = new Blob([content], { type: mimeType });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }

        // Copy HTML code to clipboard
        copyButton.addEventListener('click', () => {
            const htmlText = htmlCode.textContent;
            if (htmlText && htmlText !== 'كود HTML سيظهر هنا...') {
                navigator.clipboard.writeText(htmlText).then(() => {
                    showMessage('تم نسخ الكود!', 'success');
                });
            }
        });

        // Insert markdown helpers
        function insertMarkdown(before, after) {
            const start = markdownInput.selectionStart;
            const end = markdownInput.selectionEnd;
            const text = markdownInput.value;
            const selectedText = text.substring(start, end);

            markdownInput.value = text.substring(0, start) + before + selectedText + after + text.substring(end);
            markdownInput.focus();
            markdownInput.selectionStart = start + before.length;
            markdownInput.selectionEnd = start + before.length + selectedText.length;

            convertMarkdown();
        }

        function insertTable() {
            const table = '\n| العمود 1 | العمود 2 | العمود 3 |\n|----------|----------|----------|\n| خلية 1 | خلية 2 | خلية 3 |\n| خلية 4 | خلية 5 | خلية 6 |\n';
            const start = markdownInput.selectionStart;
            const text = markdownInput.value;

            markdownInput.value = text.substring(0, start) + table + text.substring(start);
            markdownInput.focus();

            convertMarkdown();
        }

        // Show success/error message
        function showMessage(text, type = 'success') {
            successText.textContent = text;
            successMessage.className = `fixed bottom-4 left-4 px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 animate-pulse ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white`;
            successMessage.classList.remove('hidden');

            setTimeout(() => {
                successMessage.classList.add('hidden');
            }, 3000);
        }
    </script>
</body>
</html>