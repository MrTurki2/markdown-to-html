<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test 8 - HTML to PDF Converter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Rubik', sans-serif; }
        .loader {
            border-top-color: #667eea !important;
            animation: spinner 1.5s linear infinite;
        }
        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .preview-container {
            background: repeating-linear-gradient(
                45deg,
                #f0f0f0,
                #f0f0f0 10px,
                #f5f5f5 10px,
                #f5f5f5 20px
            );
        }
        .tab-active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-md shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                    Test 8 - HTML to PDF Converter
                </h1>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600">📸 Screenshot & PDF Generator</span>
                    <a href="/" class="px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:shadow-lg transition-all">
                        الرئيسية
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6 py-8">
        <!-- Tabs -->
        <div class="flex gap-2 mb-6">
            <button id="htmlTab" class="tab px-6 py-3 rounded-lg font-medium tab-active transition-all">
                📝 HTML Code
            </button>
            <button id="urlTab" class="tab px-6 py-3 bg-white rounded-lg font-medium hover:bg-gray-50 transition-all">
                🌐 URL
            </button>
            <button id="fileTab" class="tab px-6 py-3 bg-white rounded-lg font-medium hover:bg-gray-50 transition-all">
                📁 Upload File
            </button>
        </div>

        <!-- Input Forms -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-6">
            <!-- HTML Input -->
            <div id="htmlInput" class="tab-content">
                <h3 class="text-xl font-bold mb-4 text-gray-800">📝 أدخل كود HTML</h3>
                <textarea id="htmlCode" rows="15" class="w-full p-4 border border-gray-200 rounded-lg font-mono text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="<!DOCTYPE html>
<html>
<head>
    <title>مثال</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        h1 { color: #333; }
    </style>
</head>
<body>
    <h1>مرحباً بالعالم</h1>
    <p>هذا مثال على محتوى HTML</p>
</body>
</html>"><!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>نموذج تجريبي</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            padding: 40px;
            direction: rtl;
            text-align: right;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }
        .card {
            background: rgba(255,255,255,0.2);
            padding: 20px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <h1>مرحباً بك في Test 8 🚀</h1>
    <div class="card">
        <h2>تحويل HTML إلى PDF</h2>
        <p>هذا مثال على تحويل محتوى HTML إلى ملف PDF باستخدام Chrome Headless.</p>
        <ul>
            <li>✅ دعم كامل للعربية</li>
            <li>✅ تصوير دقيق للصفحة</li>
            <li>✅ حفظ بصيغة PDF عالية الجودة</li>
        </ul>
    </div>
</body>
</html></textarea>
            </div>

            <!-- URL Input -->
            <div id="urlInput" class="tab-content hidden">
                <h3 class="text-xl font-bold mb-4 text-gray-800">🌐 أدخل رابط الصفحة</h3>
                <input type="url" id="urlField" class="w-full p-4 border border-gray-200 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="https://example.com">
                <div class="mt-3 text-sm text-gray-600">
                    💡 يمكنك إدخال أي رابط صفحة ويب لتصويرها وتحويلها إلى PDF
                </div>
            </div>

            <!-- File Upload -->
            <div id="fileInput" class="tab-content hidden">
                <h3 class="text-xl font-bold mb-4 text-gray-800">📁 رفع ملف HTML</h3>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-purple-500 transition-colors">
                    <input type="file" id="fileUpload" accept=".html,.htm" class="hidden">
                    <label for="fileUpload" class="cursor-pointer">
                        <div class="text-5xl mb-3">📂</div>
                        <div class="text-lg font-medium text-gray-700">اضغط لاختيار ملف HTML</div>
                        <div class="text-sm text-gray-500 mt-2">أو اسحب الملف وأفلته هنا</div>
                    </label>
                </div>
                <div id="fileName" class="mt-3 text-sm text-gray-600"></div>
            </div>

            <!-- Options -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h4 class="font-bold text-gray-800 mb-3">⚙️ خيارات التحويل</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">حجم الصفحة</label>
                        <select id="pageSize" class="w-full mt-1 p-2 border rounded-lg">
                            <option value="A4">A4</option>
                            <option value="A3">A3</option>
                            <option value="Letter">Letter</option>
                            <option value="Legal">Legal</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">الاتجاه</label>
                        <select id="orientation" class="w-full mt-1 p-2 border rounded-lg">
                            <option value="portrait">عمودي</option>
                            <option value="landscape">أفقي</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">الهوامش (mm)</label>
                        <input type="number" id="margins" value="10" min="0" max="50" class="w-full mt-1 p-2 border rounded-lg">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 mt-6">
                <button id="screenshotBtn" class="flex-1 bg-gradient-to-r from-green-500 to-teal-500 text-white py-3 px-6 rounded-lg font-medium hover:shadow-lg transition-all">
                    📸 تصوير Screenshot
                </button>
                <button id="pdfBtn" class="flex-1 bg-gradient-to-r from-purple-500 to-pink-500 text-white py-3 px-6 rounded-lg font-medium hover:shadow-lg transition-all">
                    📄 تحويل إلى PDF
                </button>
                <button id="printBtn" class="flex-1 bg-gradient-to-r from-blue-500 to-cyan-500 text-white py-3 px-6 rounded-lg font-medium hover:shadow-lg transition-all">
                    🖨️ طباعة مباشرة
                </button>
            </div>
        </div>

        <!-- Preview & Results -->
        <div id="results" class="hidden">
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <h3 class="text-xl font-bold mb-4 text-gray-800">📋 النتائج</h3>

                <!-- Loading State -->
                <div id="loading" class="hidden text-center py-12">
                    <div class="loader border-4 border-gray-200 rounded-full w-12 h-12 mx-auto mb-4"></div>
                    <div class="text-gray-600">جاري المعالجة...</div>
                </div>

                <!-- Success State -->
                <div id="success" class="hidden">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">✅</span>
                            <div>
                                <div class="font-bold text-green-800">نجحت العملية!</div>
                                <div class="text-sm text-green-600" id="successMessage"></div>
                            </div>
                        </div>
                    </div>
                    <div id="downloadLinks" class="flex gap-3"></div>
                </div>

                <!-- Error State -->
                <div id="error" class="hidden">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">❌</span>
                            <div>
                                <div class="font-bold text-red-800">حدث خطأ!</div>
                                <div class="text-sm text-red-600" id="errorMessage"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview -->
                <div id="preview" class="hidden mt-6">
                    <h4 class="font-bold text-gray-800 mb-3">👁️ معاينة</h4>
                    <div class="preview-container rounded-lg p-4 max-h-96 overflow-auto">
                        <img id="previewImage" class="w-full rounded shadow-lg">
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Section -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white/80 backdrop-blur rounded-xl p-6">
                <div class="text-3xl mb-3">🎯</div>
                <h4 class="font-bold text-gray-800 mb-2">دقة عالية</h4>
                <p class="text-sm text-gray-600">تصوير بدقة عالية مع الحفاظ على جميع التنسيقات والألوان</p>
            </div>
            <div class="bg-white/80 backdrop-blur rounded-xl p-6">
                <div class="text-3xl mb-3">⚡</div>
                <h4 class="font-bold text-gray-800 mb-2">سرعة فائقة</h4>
                <p class="text-sm text-gray-600">معالجة سريعة باستخدام Chrome Headless المحسّن</p>
            </div>
            <div class="bg-white/80 backdrop-blur rounded-xl p-6">
                <div class="text-3xl mb-3">🌍</div>
                <h4 class="font-bold text-gray-800 mb-2">دعم شامل</h4>
                <p class="text-sm text-gray-600">دعم كامل للعربية و CSS3 و JavaScript</p>
            </div>
        </div>
    </main>

    <script>
        // Tab switching
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach((tab, index) => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('tab-active', 'bg-gradient-to-r', 'from-purple-500', 'to-pink-500', 'text-white'));
                tabs.forEach(t => t.classList.add('bg-white'));
                contents.forEach(c => c.classList.add('hidden'));

                tab.classList.remove('bg-white');
                tab.classList.add('tab-active');

                if (index === 0) contents[0].classList.remove('hidden');
                else if (index === 1) contents[1].classList.remove('hidden');
                else if (index === 2) contents[2].classList.remove('hidden');
            });
        });

        // File upload
        const fileUpload = document.getElementById('fileUpload');
        const fileName = document.getElementById('fileName');
        let uploadedContent = '';

        fileUpload.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                fileName.innerHTML = `📄 ${file.name} (${(file.size / 1024).toFixed(2)} KB)`;

                const reader = new FileReader();
                reader.onload = (e) => {
                    uploadedContent = e.target.result;
                };
                reader.readAsText(file);
            }
        });

        // Helper function to get input content
        function getInputContent() {
            const activeTab = document.querySelector('.tab-active');

            if (activeTab.id === 'htmlTab') {
                return {
                    type: 'html',
                    content: document.getElementById('htmlCode').value
                };
            } else if (activeTab.id === 'urlTab') {
                return {
                    type: 'url',
                    content: document.getElementById('urlField').value
                };
            } else if (activeTab.id === 'fileTab') {
                return {
                    type: 'html',
                    content: uploadedContent
                };
            }
        }

        // Show loading
        function showLoading() {
            document.getElementById('results').classList.remove('hidden');
            document.getElementById('loading').classList.remove('hidden');
            document.getElementById('success').classList.add('hidden');
            document.getElementById('error').classList.add('hidden');
            document.getElementById('preview').classList.add('hidden');
        }

        // Show success
        function showSuccess(message, downloadUrl, previewUrl) {
            document.getElementById('loading').classList.add('hidden');
            document.getElementById('success').classList.remove('hidden');
            document.getElementById('successMessage').textContent = message;

            const downloadLinks = document.getElementById('downloadLinks');
            downloadLinks.innerHTML = '';

            if (downloadUrl) {
                const link = document.createElement('a');
                link.href = downloadUrl;
                link.className = 'flex-1 bg-gradient-to-r from-green-500 to-teal-500 text-white py-2 px-4 rounded-lg text-center hover:shadow-lg transition-all';
                link.textContent = '⬇️ تحميل';
                link.download = true;
                downloadLinks.appendChild(link);
            }

            if (previewUrl) {
                document.getElementById('preview').classList.remove('hidden');
                document.getElementById('previewImage').src = previewUrl;
            }
        }

        // Show error
        function showError(message) {
            document.getElementById('loading').classList.add('hidden');
            document.getElementById('error').classList.remove('hidden');
            document.getElementById('errorMessage').textContent = message;
        }

        // Screenshot button
        document.getElementById('screenshotBtn').addEventListener('click', async () => {
            const input = getInputContent();
            if (!input.content) {
                alert('الرجاء إدخال محتوى أولاً');
                return;
            }

            showLoading();

            try {
                const response = await fetch('/test8/screenshot', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        type: input.type,
                        content: input.content
                    })
                });

                const data = await response.json();

                if (data.success) {
                    showSuccess('تم أخذ لقطة الشاشة بنجاح!', data.download_url, data.preview_url);
                } else {
                    showError(data.error || 'فشل في أخذ لقطة الشاشة');
                }
            } catch (error) {
                showError('حدث خطأ في الاتصال: ' + error.message);
            }
        });

        // PDF button
        document.getElementById('pdfBtn').addEventListener('click', async () => {
            const input = getInputContent();
            if (!input.content) {
                alert('الرجاء إدخال محتوى أولاً');
                return;
            }

            showLoading();

            try {
                const response = await fetch('/test8/pdf', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        type: input.type,
                        content: input.content,
                        options: {
                            format: document.getElementById('pageSize').value,
                            orientation: document.getElementById('orientation').value,
                            margin: document.getElementById('margins').value
                        }
                    })
                });

                const data = await response.json();

                if (data.success) {
                    showSuccess('تم إنشاء ملف PDF بنجاح!', data.download_url);
                } else {
                    showError(data.error || 'فشل في إنشاء PDF');
                }
            } catch (error) {
                showError('حدث خطأ في الاتصال: ' + error.message);
            }
        });

        // Print button
        document.getElementById('printBtn').addEventListener('click', () => {
            const input = getInputContent();
            if (!input.content) {
                alert('الرجاء إدخال محتوى أولاً');
                return;
            }

            if (input.type === 'html') {
                const printWindow = window.open('', '_blank');
                printWindow.document.write(input.content);
                printWindow.document.close();
                printWindow.focus();
                setTimeout(() => {
                    printWindow.print();
                }, 500);
            } else if (input.type === 'url') {
                window.open(input.content, '_blank');
            }
        });
    </script>
</body>
</html>