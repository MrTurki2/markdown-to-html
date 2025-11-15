<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>مولد المحتوى بالذكاء الاصطناعي - Test6</title>

    <!-- Marked.js for Markdown parsing -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

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
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 20px;
            height: calc(100vh - 40px);
        }

        .sidebar {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .generator-form {
            padding: 30px;
            flex: 1;
            overflow-y: auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2d3748;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #667eea;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .range-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .range-group input[type="range"] {
            flex: 1;
        }

        .range-value {
            background: #667eea;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            min-width: 30px;
            text-align: center;
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .content-area {
            display: flex;
            flex-direction: column;
            flex: 1;
            overflow: hidden;
        }

        .content-tabs {
            display: flex;
            background: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
        }

        .tab {
            flex: 1;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            border: none;
            background: none;
            font-weight: 600;
            color: #6c757d;
            transition: all 0.3s;
        }

        .tab.active {
            color: #667eea;
            background: white;
            border-bottom: 2px solid #667eea;
        }

        .content-panels {
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        .content-panel {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 40px;
            overflow-y: auto;
            display: none;
        }

        .content-panel.active {
            display: block;
        }

        #markdown-content {
            width: 100%;
            height: 100%;
            border: none;
            outline: none;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.6;
            resize: none;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }

        #html-preview {
            background: white;
            border-radius: 8px;
            padding: 30px;
            line-height: 1.8;
            direction: rtl;
        }

        #html-preview h1 {
            color: #1a202c;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
            margin: 20px 0;
        }

        #html-preview h2 {
            color: #2d3748;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 8px;
            margin: 18px 0;
        }

        #html-preview h3 {
            color: #2d3748;
            margin: 15px 0;
        }

        #html-preview p {
            margin: 15px 0;
        }

        #html-preview blockquote {
            border-right: 4px solid #667eea;
            padding: 15px 20px;
            margin: 20px 0;
            background: #f7fafc;
            color: #4a5568;
        }

        #html-preview code {
            background: #edf2f7;
            color: #2d3748;
            padding: 2px 5px;
            border-radius: 3px;
        }

        #html-preview pre {
            background: #2d3748;
            color: #68d391;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            margin: 20px 0;
        }

        #html-preview ul, #html-preview ol {
            padding-right: 30px;
            margin: 15px 0;
        }

        #html-preview li {
            margin: 8px 0;
        }

        .chat-area {
            background: #f8f9fa;
            border-top: 2px solid #e9ecef;
            padding: 20px;
            display: none;
        }

        .chat-area.active {
            display: block;
        }

        .chat-messages {
            max-height: 200px;
            overflow-y: auto;
            margin-bottom: 15px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .chat-message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 8px;
            animation: slideIn 0.3s ease;
        }

        .chat-message.user {
            background: #667eea;
            color: white;
            margin-left: 20%;
        }

        .chat-message.ai {
            background: #e2e8f0;
            color: #2d3748;
            margin-right: 20%;
        }

        .chat-input-area {
            display: flex;
            gap: 10px;
        }

        .chat-input {
            flex: 1;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            outline: none;
        }

        .chat-send {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .loading.show {
            display: block;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

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

        @media (max-width: 1200px) {
            .container {
                grid-template-columns: 1fr;
                height: auto;
            }

            .sidebar {
                order: 2;
            }

            .main-content {
                order: 1;
                min-height: 600px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="header">
                <h1>🤖 مولد المحتوى بالذكاء الاصطناعي</h1>
            </div>

            <div class="generator-form">
                <form id="content-form">
                    <div class="form-group">
                        <label for="topic">موضوع التقرير:</label>
                        <input type="text" id="topic" name="topic" placeholder="مثال: سيارة تسلا" required>
                    </div>

                    <div class="form-group">
                        <label for="paragraphs">عدد الفقرات:</label>
                        <div class="range-group">
                            <input type="range" id="paragraphs" name="paragraphs" min="1" max="10" value="3">
                            <span class="range-value" id="paragraphs-value">3</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tone">نبرة الكتابة:</label>
                        <select id="tone" name="tone">
                            <option value="formal">رسمية ومهنية</option>
                            <option value="casual">ودية وغير رسمية</option>
                            <option value="technical">تقنية ومتخصصة</option>
                            <option value="creative">إبداعية وجذابة</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="language">اللغة:</label>
                        <select id="language" name="language">
                            <option value="arabic">العربية</option>
                            <option value="english">English</option>
                        </select>
                    </div>

                    <button type="submit" class="btn" id="generate-btn">
                        🚀 توليد المحتوى
                    </button>
                </form>

                <div class="loading" id="loading">
                    <div class="spinner"></div>
                    <div>جاري توليد المحتوى...</div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-area">
                <div class="content-tabs">
                    <button class="tab active" onclick="switchTab('markdown')">📝 Markdown</button>
                    <button class="tab" onclick="switchTab('preview')">👁️ معاينة</button>
                </div>

                <div class="content-panels">
                    <div class="content-panel active" id="markdown-panel">
                        <textarea id="markdown-content" placeholder="سيظهر المحتوى المولد هنا..."></textarea>
                    </div>

                    <div class="content-panel" id="preview-panel">
                        <div id="html-preview"></div>
                    </div>
                </div>
            </div>

            <div class="chat-area" id="chat-area">
                <div class="chat-messages" id="chat-messages">
                    <div class="chat-message ai">
                        مرحباً! يمكنني مساعدتك في تعديل المحتوى. جرب أن تطلب مني:
                        <br>• "أضف فقرة عن المقارنة"
                        <br>• "اجعل النبرة أكثر ودية"
                        <br>• "أضف إحصائيات ومعلومات رقمية"
                    </div>
                </div>

                <div class="chat-input-area">
                    <input type="text" class="chat-input" id="chat-input" placeholder="اكتب تعليمات التعديل...">
                    <button class="chat-send" onclick="sendEditRequest()">إرسال</button>
                </div>
            </div>
        </div>
    </div>

    <div class="status" id="status"></div>

    <script>
        let currentContent = '';

        // Update range value display
        document.getElementById('paragraphs').addEventListener('input', function() {
            document.getElementById('paragraphs-value').textContent = this.value;
        });

        // Form submission
        document.getElementById('content-form').addEventListener('submit', function(e) {
            e.preventDefault();
            generateContent();
        });

        // Tab switching
        function switchTab(tab) {
            // Remove active class from all tabs and panels
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.content-panel').forEach(p => p.classList.remove('active'));

            // Add active class to selected tab and panel
            event.target.classList.add('active');
            document.getElementById(tab + '-panel').classList.add('active');

            if (tab === 'preview') {
                updatePreview();
            }
        }

        // Generate content
        async function generateContent() {
            const formData = new FormData(document.getElementById('content-form'));
            const data = Object.fromEntries(formData);

            // Show loading
            document.getElementById('loading').classList.add('show');
            document.getElementById('generate-btn').disabled = true;

            try {
                const response = await fetch('/generate-content', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    currentContent = result.content;
                    document.getElementById('markdown-content').value = currentContent;
                    updatePreview();

                    // Show chat area
                    document.getElementById('chat-area').classList.add('active');

                    showStatus('✅ تم توليد المحتوى بنجاح!', 'success');
                } else {
                    showStatus('❌ ' + result.error, 'error');
                }
            } catch (error) {
                showStatus('❌ حدث خطأ في الاتصال', 'error');
                console.error('Error:', error);
            } finally {
                // Hide loading
                document.getElementById('loading').classList.remove('show');
                document.getElementById('generate-btn').disabled = false;
            }
        }

        // Update content when markdown changes
        document.getElementById('markdown-content').addEventListener('input', function() {
            currentContent = this.value;
            updatePreview();
        });

        // Update HTML preview
        function updatePreview() {
            const markdown = document.getElementById('markdown-content').value;
            const html = marked.parse(markdown);
            document.getElementById('html-preview').innerHTML = html;
        }

        // Send edit request
        async function sendEditRequest() {
            const input = document.getElementById('chat-input');
            const instruction = input.value.trim();

            if (!instruction || !currentContent) {
                showStatus('❌ يرجى كتابة تعليمات التعديل', 'error');
                return;
            }

            // Add user message to chat
            addChatMessage(instruction, 'user');
            input.value = '';

            try {
                const response = await fetch('/edit-content', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        content: currentContent,
                        instruction: instruction
                    })
                });

                const result = await response.json();

                if (result.success) {
                    currentContent = result.content;
                    document.getElementById('markdown-content').value = currentContent;
                    updatePreview();

                    addChatMessage('تم تطبيق التعديل بنجاح! ✅', 'ai');
                } else {
                    addChatMessage('حدث خطأ: ' + result.error, 'ai');
                }
            } catch (error) {
                addChatMessage('حدث خطأ في الاتصال', 'ai');
                console.error('Error:', error);
            }
        }

        // Add message to chat
        function addChatMessage(message, sender) {
            const chatMessages = document.getElementById('chat-messages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `chat-message ${sender}`;
            messageDiv.textContent = message;
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Enter key for chat
        document.getElementById('chat-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendEditRequest();
            }
        });

        // Show status message
        function showStatus(message, type = 'success') {
            const status = document.getElementById('status');
            status.textContent = message;
            status.className = 'status show ' + type;

            setTimeout(() => {
                status.classList.remove('show');
            }, 3000);
        }
    </script>
</body>
</html>