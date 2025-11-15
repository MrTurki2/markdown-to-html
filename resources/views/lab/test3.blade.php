<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>محرر Markdown المباشر - Test3</title>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Arial', sans-serif;
            background: #f5f5f5;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 20px;
            font-weight: normal;
        }

        .controls {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #45a049;
        }

        .btn-edit {
            background: #2196F3;
        }

        .btn-edit:hover {
            background: #1976D2;
        }

        #filename {
            padding: 6px 10px;
            border: 1px solid #555;
            border-radius: 4px;
            background: #444;
            color: white;
            font-size: 14px;
        }

        .editor-container {
            flex: 1;
            display: flex;
            overflow: hidden;
        }

        #editor {
            flex: 1;
            padding: 30px;
            background: white;
            overflow-y: auto;
            outline: none;
            font-size: 16px;
            line-height: 1.8;
            color: #333;
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }

        #editor.edit-mode {
            font-family: 'Courier New', monospace;
            white-space: pre-wrap;
            background: #fafafa;
            border: 2px solid #2196F3;
        }

        /* Markdown Styles */
        #editor h1 {
            font-size: 2.5em;
            font-weight: bold;
            margin: 20px 0;
            color: #2c3e50;
            border-bottom: 3px solid #ecf0f1;
            padding-bottom: 10px;
        }

        #editor h2 {
            font-size: 2em;
            font-weight: bold;
            margin: 18px 0;
            color: #34495e;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 8px;
        }

        #editor h3 {
            font-size: 1.5em;
            font-weight: bold;
            margin: 15px 0;
            color: #34495e;
        }

        #editor p {
            margin: 15px 0;
            line-height: 1.8;
        }

        #editor ul, #editor ol {
            margin: 15px 0;
            padding-right: 30px;
        }

        #editor li {
            margin: 8px 0;
            line-height: 1.6;
        }

        #editor blockquote {
            border-right: 4px solid #3498db;
            padding: 10px 20px;
            margin: 15px 0;
            background: #ecf0f1;
            color: #555;
            font-style: italic;
        }

        #editor code {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }

        #editor pre {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            margin: 15px 0;
        }

        #editor pre code {
            background: none;
            padding: 0;
        }

        #editor a {
            color: #3498db;
            text-decoration: none;
            border-bottom: 1px dashed #3498db;
        }

        #editor a:hover {
            color: #2980b9;
            border-bottom-style: solid;
        }

        #editor table {
            border-collapse: collapse;
            width: 100%;
            margin: 15px 0;
        }

        #editor table th,
        #editor table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: right;
        }

        #editor table th {
            background: #34495e;
            color: white;
            font-weight: bold;
        }

        #editor table tr:nth-child(even) {
            background: #f9f9f9;
        }

        #editor hr {
            border: none;
            border-top: 2px solid #ecf0f1;
            margin: 20px 0;
        }

        #editor img {
            max-width: 100%;
            height: auto;
            margin: 15px 0;
            border-radius: 5px;
        }

        .status {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: #333;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            display: none;
            animation: fadeIn 0.3s;
        }

        .status.show {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📝 محرر Markdown المباشر</h1>
        <div class="controls">
            <input type="text" id="filename" placeholder="document" value="document">
            <button class="btn btn-edit" onclick="toggleEditMode()">✏️ تعديل</button>
            <button class="btn" onclick="saveFile()">💾 حفظ كملف</button>
        </div>
    </div>

    <div class="editor-container">
        <div id="editor" contenteditable="false"># مرحباً في محرر Markdown المباشر

هذا محرر **بسيط وفعال** يتيح لك كتابة وتعديل نصوص *Markdown* بشكل مباشر.

## كيفية الاستخدام:

1. اضغط على زر **تعديل** للبدء في الكتابة
2. اكتب نص Markdown كما تريد
3. اضغط على **معاينة** لرؤية النتيجة
4. احفظ العمل كملف نصي

### المميزات:
- تحرير مباشر في نفس المكان
- معاينة فورية للتنسيق
- حفظ سريع كملف `.txt`
- واجهة بسيطة وسهلة

> "البساطة هي أقصى درجات الرقي" - ليوناردو دافنشي

---

**جرب الكتابة الآن!** اضغط على زر التعديل وابدأ...

```javascript
// مثال على كود
function markdown() {
    return "Simple is better";
}
```

| الميزة | الوصف |
|-------|-------|
| السرعة | تحويل فوري |
| البساطة | واجهة نظيفة |
| الفعالية | أداء ممتاز |</div>
    </div>

    <div class="status" id="status"></div>

    <script>
        let isEditMode = false;
        let markdownContent = '';
        const editor = document.getElementById('editor');
        const status = document.getElementById('status');

        // Store initial markdown content
        const initialMarkdown = `# مرحباً في محرر Markdown المباشر

هذا محرر **بسيط وفعال** يتيح لك كتابة وتعديل نصوص *Markdown* بشكل مباشر.

## كيفية الاستخدام:

1. اضغط على زر **تعديل** للبدء في الكتابة
2. اكتب نص Markdown كما تريد
3. اضغط على **معاينة** لرؤية النتيجة
4. احفظ العمل كملف نصي

### المميزات:
- تحرير مباشر في نفس المكان
- معاينة فورية للتنسيق
- حفظ سريع كملف \`.txt\`
- واجهة بسيطة وسهلة

> "البساطة هي أقصى درجات الرقي" - ليوناردو دافنشي

---

**جرب الكتابة الآن!** اضغط على زر التعديل وابدأ...

\`\`\`javascript
// مثال على كود
function markdown() {
    return "Simple is better";
}
\`\`\`

| الميزة | الوصف |
|-------|-------|
| السرعة | تحويل فوري |
| البساطة | واجهة نظيفة |
| الفعالية | أداء ممتاز |`;

        // Initialize with rendered markdown
        window.onload = function() {
            markdownContent = initialMarkdown;
            renderMarkdown();
        };

        function toggleEditMode() {
            const btn = document.querySelector('.btn-edit');

            if (isEditMode) {
                // Switch to preview mode
                markdownContent = editor.innerText;
                renderMarkdown();
                editor.contentEditable = false;
                editor.classList.remove('edit-mode');
                btn.textContent = '✏️ تعديل';
                btn.style.background = '#2196F3';
                showStatus('وضع المعاينة');
            } else {
                // Switch to edit mode
                editor.contentEditable = true;
                editor.classList.add('edit-mode');
                editor.innerText = markdownContent;
                btn.textContent = '👁️ معاينة';
                btn.style.background = '#FF9800';
                editor.focus();
                showStatus('وضع التحرير');
            }

            isEditMode = !isEditMode;
        }

        function renderMarkdown() {
            // Configure marked options for Arabic support
            marked.setOptions({
                breaks: true,
                gfm: true,
                tables: true,
                sanitize: false
            });

            // Convert markdown to HTML
            const html = marked.parse(markdownContent);
            editor.innerHTML = html;
        }

        function saveFile() {
            const filename = document.getElementById('filename').value || 'document';
            const content = isEditMode ? editor.innerText : markdownContent;

            // Send to server to save
            fetch('/save-text-file', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    filename: filename + '.txt',
                    content: content
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showStatus('✅ تم حفظ الملف بنجاح!');

                    // Also trigger download
                    downloadFile(content, filename + '.txt');
                } else {
                    showStatus('❌ فشل في حفظ الملف');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Still download locally even if server save fails
                downloadFile(content, filename + '.txt');
                showStatus('💾 تم التحميل محلياً');
            });
        }

        function downloadFile(content, filename) {
            const blob = new Blob([content], { type: 'text/plain;charset=utf-8' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }

        function showStatus(message) {
            status.textContent = message;
            status.classList.add('show');
            setTimeout(() => {
                status.classList.remove('show');
            }, 3000);
        }

        // Auto-save draft to localStorage
        setInterval(() => {
            if (isEditMode) {
                markdownContent = editor.innerText;
            }
            localStorage.setItem('markdown-draft', markdownContent);
        }, 30000); // Every 30 seconds

        // Load draft if exists
        const draft = localStorage.getItem('markdown-draft');
        if (draft && confirm('توجد مسودة محفوظة. هل تريد استردادها؟')) {
            markdownContent = draft;
            renderMarkdown();
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // Ctrl+E or Cmd+E to toggle edit mode
            if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
                e.preventDefault();
                toggleEditMode();
            }
            // Ctrl+S or Cmd+S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                saveFile();
            }
        });
    </script>
</body>
</html>