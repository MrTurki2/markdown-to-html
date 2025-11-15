<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test 9 - محول HTML إلى PDF النظيف</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            direction: rtl;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        .main-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .toolbar {
            background: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .options-group {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .option-item {
            display: flex;
            align-items: center;
            gap: 8px;
            background: white;
            padding: 8px 15px;
            border-radius: 10px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .option-item:hover {
            border-color: #667eea;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
        }

        .option-item label {
            font-size: 14px;
            color: #333;
            cursor: pointer;
            font-weight: 500;
        }

        select, input[type="radio"], input[type="checkbox"] {
            cursor: pointer;
        }

        select {
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .editor-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 500px;
        }

        .input-panel, .preview-panel {
            padding: 30px;
        }

        .input-panel {
            border-left: 1px solid #e0e0e0;
        }

        .panel-title {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .html-textarea {
            width: 100%;
            height: 400px;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            resize: vertical;
            transition: border-color 0.3s ease;
            direction: ltr;
            text-align: left;
        }

        .html-textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .preview-frame {
            width: 100%;
            height: 400px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            background: white;
            overflow: auto;
        }

        .buttons-section {
            padding: 20px 30px;
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(56, 239, 125, 0.3);
        }

        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .loading.active {
            display: flex;
        }

        .loading-content {
            background: white;
            padding: 30px 50px;
            border-radius: 15px;
            text-align: center;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .templates-section {
            padding: 20px 30px;
            background: white;
            border-bottom: 1px solid #e0e0e0;
        }

        .templates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .template-card {
            padding: 15px;
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .template-card:hover {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }

        .template-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .template-name {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .info-badge {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1000;
        }

        .info-badge.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .info-badge.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .editor-section {
                grid-template-columns: 1fr;
            }

            .input-panel {
                border-left: none;
                border-bottom: 1px solid #e0e0e0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🎯 Test 9 - محول HTML إلى PDF النظيف</h1>
            <p>ضع كود HTML واحصل على PDF احترافي فوراً</p>
        </div>

        <!-- Main Card -->
        <div class="main-card">
            <!-- Toolbar -->
            <div class="toolbar">
                <div class="options-group">
                    <div class="option-item">
                        <label>المحرك:</label>
                        <select id="engine">
                            <option value="auto">تلقائي ذكي</option>
                            <option value="chrome">Chrome (سريع)</option>
                            <option value="firefox">Firefox (تأثيرات)</option>
                        </select>
                    </div>

                    <div class="option-item">
                        <label>نوع العرض:</label>
                        <select id="deviceType">
                            <option value="desktop">سطح المكتب</option>
                            <option value="mobile">جوال حديث</option>
                            <option value="tablet">تابلت</option>
                        </select>
                    </div>

                    <div class="option-item">
                        <label>الحجم:</label>
                        <select id="pageSize">
                            <option value="A4">A4</option>
                            <option value="A3">A3</option>
                            <option value="Letter">Letter</option>
                            <option value="Legal">Legal</option>
                        </select>
                    </div>

                    <div class="option-item">
                        <label>الاتجاه:</label>
                        <select id="orientation">
                            <option value="portrait">عمودي</option>
                            <option value="landscape">أفقي</option>
                        </select>
                    </div>

                    <div class="option-item">
                        <label>نوع الصفحة:</label>
                        <select id="pageMode">
                            <option value="paged">مع صفحات (للطباعة)</option>
                            <option value="continuous">مستمر بدون فواصل (رقمي)</option>
                        </select>
                    </div>

                    <div class="option-item">
                        <label>الهوامش:</label>
                        <select id="margins">
                            <option value="10">صغيرة (10mm)</option>
                            <option value="15" selected>متوسطة (15mm)</option>
                            <option value="20">كبيرة (20mm)</option>
                            <option value="25">كبيرة جداً (25mm)</option>
                            <option value="0">بدون هوامش</option>
                            <option value="custom">مخصص</option>
                        </select>
                    </div>
                </div>

                <div class="options-group">
                    <div class="option-item" id="customMargins" style="display: none;">
                        <label>هوامش مخصصة (mm):</label>
                        <div style="display: flex; gap: 5px;">
                            <input type="number" id="marginTop" placeholder="أعلى" value="15" style="width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 5px;">
                            <input type="number" id="marginRight" placeholder="يمين" value="15" style="width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 5px;">
                            <input type="number" id="marginBottom" placeholder="أسفل" value="15" style="width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 5px;">
                            <input type="number" id="marginLeft" placeholder="يسار" value="15" style="width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>
                    </div>

                    <div class="option-item">
                        <label>
                            <input type="checkbox" id="printBackground" checked>
                            طباعة الخلفيات
                        </label>
                    </div>

                    <div class="option-item">
                        <label>
                            <input type="checkbox" id="displayHeader">
                            إضافة رأس وتذييل
                        </label>
                    </div>
                </div>
            </div>

            <!-- Templates Section -->
            <div class="templates-section">
                <div class="panel-title">قوالب جاهزة:</div>
                <div class="templates-grid">
                    <div class="template-card" onclick="loadTemplate('invoice')">
                        <div class="template-icon">📄</div>
                        <div class="template-name">فاتورة</div>
                    </div>
                    <div class="template-card" onclick="loadTemplate('report')">
                        <div class="template-icon">📊</div>
                        <div class="template-name">تقرير</div>
                    </div>
                    <div class="template-card" onclick="loadTemplate('cv')">
                        <div class="template-icon">👤</div>
                        <div class="template-name">سيرة ذاتية</div>
                    </div>
                    <div class="template-card" onclick="loadTemplate('certificate')">
                        <div class="template-icon">🏆</div>
                        <div class="template-name">شهادة</div>
                    </div>
                    <div class="template-card" onclick="loadTemplate('book')">
                        <div class="template-icon">📚</div>
                        <div class="template-name">كتاب</div>
                    </div>
                    <div class="template-card" onclick="loadTemplate('simple')">
                        <div class="template-icon">📝</div>
                        <div class="template-name">بسيط</div>
                    </div>
                </div>
            </div>

            <!-- Editor Section -->
            <div class="editor-section">
                <div class="input-panel">
                    <div class="panel-title">كود HTML:</div>
                    <textarea id="htmlInput" class="html-textarea" placeholder="ضع كود HTML هنا..."><!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 40px;
            direction: rtl;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            line-height: 1.8;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>مرحباً بك في محول PDF</h1>
    <p>هذا مثال بسيط على تحويل HTML إلى PDF.</p>
    <p>يمكنك تعديل هذا الكود أو استخدام أحد القوالب الجاهزة.</p>
</body>
</html></textarea>
                </div>

                <div class="preview-panel">
                    <div class="panel-title">معاينة:</div>
                    <iframe id="preview" class="preview-frame"></iframe>
                </div>
            </div>

            <!-- Buttons Section -->
            <div class="buttons-section">
                <button class="btn btn-secondary" onclick="updatePreview()">
                    <span>🔄</span> تحديث المعاينة
                </button>
                <button class="btn btn-primary" onclick="generatePDF()">
                    <span>📄</span> تحويل إلى PDF
                </button>
                <button class="btn btn-success" onclick="downloadAndOpen()">
                    <span>⚡</span> تحويل وفتح مباشرة
                </button>
            </div>
        </div>
    </div>

    <!-- Loading -->
    <div id="loading" class="loading">
        <div class="loading-content">
            <div class="spinner"></div>
            <div>جاري إنشاء PDF...</div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Templates
        const templates = {
            invoice: `<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Arial', sans-serif; padding: 30px; }
        .header { border-bottom: 3px solid #3498db; padding-bottom: 20px; margin-bottom: 30px; }
        h1 { color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background: #3498db; color: white; padding: 10px; }
        td { padding: 10px; border-bottom: 1px solid #ddd; }
        .total { font-size: 24px; color: #3498db; text-align: left; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>فاتورة مبيعات</h1>
        <p>رقم الفاتورة: #2024-001</p>
        <p>التاريخ: ${new Date().toLocaleDateString('ar-SA')}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>المنتج</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>المجموع</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>منتج أ</td>
                <td>2</td>
                <td>500 ريال</td>
                <td>1000 ريال</td>
            </tr>
            <tr>
                <td>منتج ب</td>
                <td>1</td>
                <td>1500 ريال</td>
                <td>1500 ريال</td>
            </tr>
        </tbody>
    </table>
    <div class="total">المجموع الكلي: 2500 ريال</div>
</body>
</html>`,

            report: `<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Arial', sans-serif; padding: 40px; line-height: 1.8; }
        h1 { color: #2c3e50; text-align: center; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        h2 { color: #34495e; margin-top: 30px; }
        p { text-align: justify; color: #555; }
        .highlight { background: #f1c40f; padding: 2px 5px; }
    </style>
</head>
<body>
    <h1>تقرير شهري</h1>
    <h2>الملخص التنفيذي</h2>
    <p>هذا التقرير يلخص أداء الشركة خلال الشهر الماضي. لقد حققنا <span class="highlight">نمواً بنسبة 25%</span> في المبيعات.</p>
    <h2>التفاصيل</h2>
    <p>تم إنجاز جميع المشاريع في الوقت المحدد مع الحفاظ على معايير الجودة العالية.</p>
    <h2>التوصيات</h2>
    <p>نوصي بزيادة الاستثمار في قسم التسويق لتحقيق نمو أكبر في الربع القادم.</p>
</body>
</html>`,

            cv: `<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Arial', sans-serif; padding: 40px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 10px; margin-bottom: 30px; }
        h1 { margin: 0; }
        .section { margin: 30px 0; }
        .section h2 { color: #667eea; border-bottom: 2px solid #667eea; padding-bottom: 5px; }
        .job { margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>أحمد محمد</h1>
        <p>مطور برمجيات</p>
        <p>📱 0501234567 | 📧 ahmad@email.com</p>
    </div>
    <div class="section">
        <h2>الخبرات</h2>
        <div class="job">
            <h3>مطور أول - شركة التقنية (2020-2024)</h3>
            <p>تطوير تطبيقات ويب باستخدام React و Node.js</p>
        </div>
    </div>
    <div class="section">
        <h2>التعليم</h2>
        <p>بكالوريوس علوم الحاسب - جامعة الملك سعود (2016-2020)</p>
    </div>
</body>
</html>`,

            certificate: `<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 60px;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .certificate {
            background: white;
            padding: 60px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 { color: #667eea; font-size: 48px; margin-bottom: 20px; }
        .recipient { font-size: 32px; color: #333; margin: 30px 0; }
        .description { font-size: 18px; color: #666; line-height: 1.8; }
        .signature { margin-top: 50px; border-top: 2px solid #333; width: 200px; margin: 50px auto 10px; }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>شهادة إنجاز</h1>
        <p>تشهد هذه الوثيقة بأن</p>
        <div class="recipient">محمد أحمد</div>
        <div class="description">
            قد أتم بنجاح دورة تطوير تطبيقات الويب المتقدمة
            <br>بتاريخ ${new Date().toLocaleDateString('ar-SA')}
        </div>
        <div class="signature"></div>
        <p>التوقيع</p>
    </div>
</body>
</html>`,

            book: `<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Georgia', serif;
            padding: 60px;
            line-height: 2;
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            font-size: 36px;
            color: #2c3e50;
            margin-bottom: 50px;
            border-bottom: 3px solid #3498db;
            padding-bottom: 20px;
        }
        .chapter {
            margin: 40px 0;
        }
        .chapter h2 {
            color: #34495e;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            text-align: justify;
            text-indent: 30px;
            margin-bottom: 15px;
        }
        .quote {
            background: #f8f9fa;
            padding: 20px;
            margin: 30px 0;
            border-right: 4px solid #3498db;
            font-style: italic;
        }
    </style>
</head>
<body>
    <h1>📚 دليل البرمجة الحديثة</h1>

    <div class="chapter">
        <h2>الفصل الأول: المقدمة</h2>
        <p>البرمجة هي فن وعلم في نفس الوقت. تتطلب الإبداع والمنطق معاً لحل المشكلات وبناء الحلول.</p>
        <div class="quote">
            "أفضل طريقة للتنبؤ بالمستقبل هي اختراعه" - آلان كاي
        </div>
        <p>في هذا الدليل، سنستكشف أساسيات البرمجة الحديثة وأفضل الممارسات في تطوير البرمجيات.</p>
    </div>

    <div class="chapter">
        <h2>الفصل الثاني: الأساسيات</h2>
        <p>لنبدأ رحلتنا بفهم المفاهيم الأساسية في البرمجة...</p>
    </div>
</body>
</html>`,

            simple: `<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 40px;
            line-height: 1.8;
        }
        h1 { color: #333; }
        p { color: #666; }
    </style>
</head>
<body>
    <h1>عنوان المستند</h1>
    <p>هذا نص بسيط يمكن تحويله إلى PDF.</p>
    <ul>
        <li>نقطة أولى</li>
        <li>نقطة ثانية</li>
        <li>نقطة ثالثة</li>
    </ul>
</body>
</html>`
        };

        // Load template
        function loadTemplate(templateName) {
            if (templates[templateName]) {
                document.getElementById('htmlInput').value = templates[templateName];
                updatePreview();
                showMessage('تم تحميل القالب', 'success');
            }
        }

        // Update preview
        function updatePreview() {
            const html = document.getElementById('htmlInput').value;
            const preview = document.getElementById('preview');
            preview.srcdoc = html;
        }

        // Handle margin selection
        document.getElementById('margins').addEventListener('change', function() {
            const customMarginsDiv = document.getElementById('customMargins');
            if (this.value === 'custom') {
                customMarginsDiv.style.display = 'block';
            } else {
                customMarginsDiv.style.display = 'none';
            }
        });

        // Generate PDF
        async function generatePDF() {
            const html = document.getElementById('htmlInput').value;
            if (!html.trim()) {
                showMessage('الرجاء إدخال كود HTML', 'error');
                return;
            }

            showLoading(true);

            // Get margins
            const marginSelect = document.getElementById('margins').value;
            let margins = {};

            if (marginSelect === 'custom') {
                margins = {
                    top: parseInt(document.getElementById('marginTop').value) || 15,
                    right: parseInt(document.getElementById('marginRight').value) || 15,
                    bottom: parseInt(document.getElementById('marginBottom').value) || 15,
                    left: parseInt(document.getElementById('marginLeft').value) || 15
                };
            } else {
                const marginValue = parseInt(marginSelect);
                margins = {
                    top: marginValue,
                    right: marginValue,
                    bottom: marginValue,
                    left: marginValue
                };
            }

            console.log('Margins being sent:', margins); // للتأكد من القيم

            try {
                const response = await fetch('/api/test9/generate-pdf', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        html: html,
                        engine: document.getElementById('engine').value,
                        deviceType: document.getElementById('deviceType').value,
                        pageSize: document.getElementById('pageSize').value,
                        orientation: document.getElementById('orientation').value,
                        pageMode: document.getElementById('pageMode').value,
                        margins: margins,
                        printBackground: document.getElementById('printBackground').checked,
                        displayHeader: document.getElementById('displayHeader').checked
                    })
                });

                if (!response.ok) throw new Error('فشل في إنشاء PDF');

                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `document-${Date.now()}.pdf`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);

                showMessage('تم إنشاء PDF بنجاح!', 'success');
            } catch (error) {
                showMessage('حدث خطأ: ' + error.message, 'error');
            } finally {
                showLoading(false);
            }
        }

        // Download and open
        async function downloadAndOpen() {
            await generatePDF();
        }

        // Show loading
        function showLoading(show) {
            document.getElementById('loading').classList.toggle('active', show);
        }

        // Show message
        function showMessage(message, type = 'info') {
            // Remove existing badges
            document.querySelectorAll('.info-badge').forEach(badge => badge.remove());

            const badge = document.createElement('div');
            badge.className = `info-badge ${type}`;
            badge.innerHTML = `
                <span>${type === 'success' ? '✅' : '⚠️'}</span>
                <span>${message}</span>
            `;
            document.body.appendChild(badge);

            setTimeout(() => {
                badge.remove();
            }, 3000);
        }

        // Auto update preview on input
        document.getElementById('htmlInput').addEventListener('input', function() {
            clearTimeout(this.updateTimer);
            this.updateTimer = setTimeout(updatePreview, 500);
        });

        // Initialize preview
        updatePreview();
    </script>
</body>
</html>