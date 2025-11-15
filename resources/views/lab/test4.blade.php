<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>محرر النصوص المتقدم - Test4</title>

    <!-- Quill CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        #filename {
            padding: 10px 15px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 14px;
            width: 200px;
            outline: none;
        }

        #filename::placeholder {
            color: rgba(255,255,255,0.7);
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid rgba(255,255,255,0.3);
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
        }

        .btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-save {
            background: #27ae60;
            border-color: #27ae60;
        }

        .btn-save:hover {
            background: #229954;
        }

        /* Quill Editor Styling */
        #editor-container {
            background: white;
            min-height: 500px;
        }

        #editor {
            height: 500px;
            font-size: 16px;
            line-height: 1.8;
            direction: rtl;
        }

        .ql-toolbar {
            background: #f8f9fa;
            border: none !important;
            border-bottom: 2px solid #e9ecef !important;
            padding: 15px !important;
            direction: rtl;
        }

        .ql-container {
            border: none !important;
            font-family: 'Arial', sans-serif;
        }

        .ql-editor {
            padding: 40px !important;
            direction: rtl !important;
            text-align: right !important;
        }

        .ql-editor h1 {
            font-size: 2.5em;
            color: #2c3e50;
            margin: 20px 0;
        }

        .ql-editor h2 {
            font-size: 2em;
            color: #34495e;
            margin: 18px 0;
        }

        .ql-editor h3 {
            font-size: 1.5em;
            color: #34495e;
            margin: 15px 0;
        }

        .ql-editor p {
            margin: 15px 0;
        }

        .ql-editor blockquote {
            border-right: 4px solid #667eea;
            padding-right: 20px;
            margin: 20px 0;
            color: #555;
            font-style: italic;
        }

        .ql-editor pre {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .ql-editor ul, .ql-editor ol {
            padding-right: 30px;
        }

        /* Custom toolbar buttons */
        .ql-toolbar .ql-formats button {
            width: 35px !important;
            height: 35px !important;
            margin: 0 2px;
        }

        .ql-toolbar .ql-formats button:hover {
            background: #667eea !important;
            color: white !important;
            border-radius: 5px;
        }

        .ql-toolbar .ql-formats button.ql-active {
            background: #764ba2 !important;
            color: white !important;
            border-radius: 5px;
        }

        /* Status message */
        .status {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: #2c3e50;
            color: white;
            padding: 15px 25px;
            border-radius: 50px;
            font-size: 14px;
            display: none;
            animation: slideIn 0.3s;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            z-index: 1000;
        }

        .status.show {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status.success {
            background: #27ae60;
        }

        .status.error {
            background: #e74c3c;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Info panel */
        .info-panel {
            background: #f8f9fa;
            padding: 20px 40px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-text {
            color: #666;
            font-size: 14px;
        }

        .word-count {
            background: #667eea;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>
                ✨ محرر النصوص المتقدم
            </h1>
            <div class="header-actions">
                <input type="text" id="filename" placeholder="اسم الملف" value="document">
                <div class="btn-group">
                    <button class="btn" onclick="exportAsMarkdown()">
                        📄 تصدير Markdown
                    </button>
                    <button class="btn btn-save" onclick="saveFile()">
                        💾 حفظ
                    </button>
                </div>
            </div>
        </div>

        <div class="info-panel">
            <div class="info-text">
                اكتب نصك مباشرة واستخدم شريط الأدوات للتنسيق
            </div>
            <div class="word-count" id="word-count">
                0 كلمة
            </div>
        </div>

        <div id="editor-container">
            <div id="editor">
                <h1>مرحباً في محرر النصوص المتقدم!</h1>
                <p>هذا محرر <strong>احترافي</strong> يتيح لك كتابة وتنسيق النصوص بكل <em>سهولة</em>.</p>

                <h2>كيف يعمل المحرر؟</h2>
                <p>فقط اكتب نصك واستخدم شريط الأدوات في الأعلى للتنسيق. لا حاجة لمعرفة أي رموز أو أكواد!</p>

                <h3>المميزات الرئيسية:</h3>
                <ul>
                    <li>تنسيق سهل وسريع</li>
                    <li>واجهة نظيفة وجميلة</li>
                    <li>دعم كامل للغة العربية</li>
                    <li>تصدير إلى Markdown</li>
                </ul>

                <blockquote>
                    "البساطة هي أقصى درجات التطور" - ليوناردو دافنشي
                </blockquote>

                <p>جرب كتابة نصك الآن واستمتع بالتجربة! 🚀</p>
            </div>
        </div>
    </div>

    <div class="status" id="status"></div>

    <!-- Include Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <!-- TurndownJS for HTML to Markdown conversion -->
    <script src="https://unpkg.com/turndown/dist/turndown.js"></script>

    <script>
        // Initialize Quill editor
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'ابدأ الكتابة...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'align': [] }],
                    ['blockquote', 'code-block'],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        // Word count
        quill.on('text-change', function() {
            const text = quill.getText();
            const words = text.trim().split(/\s+/).length;
            document.getElementById('word-count').textContent = words + ' كلمة';

            // Auto-save to localStorage
            localStorage.setItem('editor-content', quill.root.innerHTML);
        });

        // Load saved content
        window.onload = function() {
            const saved = localStorage.getItem('editor-content');
            if (saved) {
                quill.root.innerHTML = saved;
            }
        };

        // Export as Markdown
        function exportAsMarkdown() {
            const turndownService = new TurndownService({
                headingStyle: 'atx',
                codeBlockStyle: 'fenced'
            });

            const html = quill.root.innerHTML;
            const markdown = turndownService.turndown(html);

            const filename = document.getElementById('filename').value || 'document';
            downloadFile(markdown, filename + '.md', 'text/markdown');
            showStatus('✅ تم تصدير الملف كـ Markdown', 'success');
        }

        // Save file (as HTML and Markdown)
        function saveFile() {
            const filename = document.getElementById('filename').value || 'document';
            const html = quill.root.innerHTML;

            // Convert to Markdown for saving
            const turndownService = new TurndownService({
                headingStyle: 'atx',
                codeBlockStyle: 'fenced'
            });
            const markdown = turndownService.turndown(html);

            if (!quill.getText().trim()) {
                showStatus('❌ لا يوجد محتوى للحفظ', 'error');
                return;
            }

            // Send to server
            fetch('/save-text-file', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    filename: filename + '.md',
                    content: markdown
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showStatus('✅ تم حفظ الملف بنجاح!', 'success');
                    // Download as well
                    downloadFile(markdown, filename + '.md', 'text/markdown');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Download locally anyway
                downloadFile(markdown, filename + '.md', 'text/markdown');
                showStatus('💾 تم الحفظ محلياً', 'success');
            });
        }

        // Download file
        function downloadFile(content, filename, mimeType) {
            const blob = new Blob([content], { type: mimeType + ';charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        // Show status message
        function showStatus(message, type = 'success') {
            const status = document.getElementById('status');
            status.textContent = message;
            status.className = 'status show ' + type;

            setTimeout(() => {
                status.classList.remove('show');
            }, 3000);
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                saveFile();
            }
        });

        // Auto-save every 30 seconds
        setInterval(() => {
            if (quill.getText().trim()) {
                localStorage.setItem('editor-content', quill.root.innerHTML);
                showStatus('💾 حفظ تلقائي', 'success');
            }
        }, 30000);
    </script>
</body>
</html>