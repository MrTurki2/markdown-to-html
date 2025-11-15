<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\Table\TableExtension;
use App\Models\MarkdownFile;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;
use OpenAI;
use Spatie\Browsershot\Browsershot;

/**
 * MarkdownController - وحدة التحكم الرئيسية لتحويل Markdown
 *
 * يحتوي على جميع الطرق المطلوبة للتجارب الخمسة:
 * Test 1: المحول الأساسي
 * Test 2: المحول المتقدم مع الحفظ
 * Test 3: المحرر البسيط
 * Test 4: محرر WYSIWYG
 * Test 5: محول PDF مع دعم العربية
 */
class MarkdownController extends Controller
{
    private $converter;

    /**
     * إعداد محرك تحويل Markdown مع الإضافات المطلوبة
     */
    public function __construct()
    {
        // إعداد بيئة Markdown مع الخيارات الآمنة
        $environment = new Environment([
            'html_input' => 'allow',           // السماح بـ HTML في المدخلات
            'allow_unsafe_links' => false,    // منع الروابط غير الآمنة
        ]);

        // إضافة الإضافات المطلوبة
        $environment->addExtension(new CommonMarkCoreExtension());        // الإضافة الأساسية
        $environment->addExtension(new GithubFlavoredMarkdownExtension()); // إضافة GitHub
        $environment->addExtension(new TableExtension());                  // إضافة الجداول

        // إنشاء محرك التحويل
        $this->converter = new CommonMarkConverter([], $environment);
    }

    /**
     * Test 1: عرض صفحة المحول الأساسي
     */
    public function index()
    {
        return view('home');
    }

    /**
     * API: تحويل Markdown إلى HTML
     * يستخدم في جميع التجارب لتحويل النص
     */
    public function convert(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([
            'markdown' => 'required|string'
        ]);

        $markdown = $request->input('markdown');
        $html = $this->converter->convert($markdown)->getContent();

        return response()->json([
            'html' => $html
        ]);
    }

    /**
     * Test 2: عرض صفحة المحول المتقدم مع الحفظ
     */
    public function test2()
    {
        return view('test2');
    }

    /**
     * Test 2: حفظ الملف في قاعدة البيانات
     * يحفظ كل من Markdown و HTML معاً
     */
    public function saveFile(Request $request)
    {
        $request->validate([
            'filename' => 'required|string',
            'markdown' => 'required|string',
            'html' => 'required|string'
        ]);

        $file = MarkdownFile::create([
            'filename' => $request->filename,
            'markdown' => $request->markdown,
            'html' => $request->html
        ]);

        return response()->json([
            'success' => true,
            'file' => $file
        ]);
    }

    /**
     * Test 2: جلب قائمة جميع الملفات المحفوظة
     */
    public function getFiles()
    {
        $files = MarkdownFile::orderBy('created_at', 'desc')->get();

        return response()->json([
            'files' => $files
        ]);
    }

    /**
     * Test 2: جلب ملف محدد بواسطة ID
     */
    public function getFile($id)
    {
        $file = MarkdownFile::findOrFail($id);

        return response()->json([
            'file' => $file
        ]);
    }

    /**
     * Test 3: عرض صفحة المحرر البسيط
     */
    public function test3()
    {
        return view('test3');
    }

    /**
     * Test 3: حفظ الملف كنص عادي في التخزين المحلي
     */
    public function saveTextFile(Request $request)
    {
        $request->validate([
            'filename' => 'required|string',
            'content' => 'required|string'
        ]);

        $filename = $request->filename;
        $content = $request->content;

        // التأكد من وجود امتداد .txt أو .md
        if (!str_ends_with($filename, '.txt') && !str_ends_with($filename, '.md')) {
            $filename .= '.md';
        }

        // حفظ في مجلد storage/app/markdown-files
        $path = 'markdown-files/' . $filename;
        Storage::put($path, $content);

        return response()->json([
            'success' => true,
            'path' => $path,
            'message' => 'File saved successfully'
        ]);
    }

    /**
     * Test 5: عرض صفحة محول PDF
     */
    public function test5()
    {
        return view('test5');
    }

    /**
     * Test 5: تحويل HTML إلى PDF مع دعم كامل للعربية
     * يستخدم مكتبة mPDF لضمان دعم أفضل للغة العربية وRTL
     */
    public function generatePDF(Request $request)
    {
        $request->validate([
            'html' => 'required|string',
            'filename' => 'required|string'
        ]);

        $html = $request->html;
        $filename = $request->filename;
        $options = $request->options ?? [];

        // إنشاء mPDF مع إعدادات خاصة للعربية
        $mpdf = new Mpdf([
            'mode' => 'utf-8',                              // ترميز UTF-8 للعربية
            'format' => $options['pageSize'] ?? 'A4',      // حجم الصفحة
            'default_font_size' => 12,                     // حجم الخط الافتراضي
            'default_font' => 'dejavusans',                // خط يدعم العربية
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 16,
            'margin_bottom' => 16,
            'margin_header' => 9,
            'margin_footer' => 9,
            'orientation' => 'P',                          // اتجاه الصفحة عمودي
            'tempDir' => storage_path('app/temp'),         // مجلد مؤقت
            'autoLangToFont' => true,                      // تحديد الخط تلقائياً حسب اللغة
            'autoScriptToLang' => true,                    // تحديد اللغة تلقائياً
        ]);

        // تفعيل دعم العربية و RTL
        $mpdf->SetDirectionality('rtl');                   // تعيين الاتجاه من اليمين للشمال
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;

        // Create HTML template with proper Arabic support
        $pdfHTML = '<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: dejavusans;
            direction: rtl;
            text-align: right;
            line-height: 1.8;
            padding: 20px;
        }
        h1 {
            color: #1a202c;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
            margin: 20px 0;
            direction: rtl;
        }
        h2 {
            color: #2d3748;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 8px;
            margin: 18px 0;
            direction: rtl;
        }
        h3 {
            color: #2d3748;
            margin: 15px 0;
            direction: rtl;
        }
        p {
            margin: 15px 0;
            direction: rtl;
        }
        blockquote {
            border-right: 4px solid #667eea;
            padding: 15px 20px;
            margin: 20px 0;
            background: #f7fafc;
            color: #4a5568;
            direction: rtl;
        }
        code {
            background: #edf2f7;
            color: #2d3748;
            padding: 2px 5px;
            border-radius: 3px;
            font-family: monospace;
        }
        pre {
            background: #2d3748;
            color: #68d391;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            margin: 20px 0;
            direction: ltr;
            text-align: left;
            font-family: monospace;
        }
        pre code {
            background: none;
            color: #68d391;
            padding: 0;
        }
        ul, ol {
            padding-right: 30px;
            margin: 15px 0;
            direction: rtl;
        }
        li {
            margin: 8px 0;
            direction: rtl;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            direction: rtl;
        }
        table th, table td {
            border: 1px solid #cbd5e0;
            padding: 10px;
            text-align: right;
            direction: rtl;
        }
        table th {
            background: #667eea;
            color: white;
        }
        table tr:nth-child(even) {
            background: #f7fafc;
        }
        hr {
            border: none;
            border-top: 2px solid #e2e8f0;
            margin: 20px 0;
        }
    </style>
</head>
<body>
' . $html . '
</body>
</html>';

        // Write HTML to PDF
        $mpdf->WriteHTML($pdfHTML);

        // Output the PDF
        return $mpdf->Output($filename . '.pdf', 'D');
    }

    /**
     * Test 6: عرض صفحة مولد المحتوى بالذكاء الاصطناعي
     */
    public function test6()
    {
        return view('test6');
    }

    /**
     * Test 6: توليد محتوى جديد باستخدام OpenAI
     */
    public function generateContent(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:200',
            'paragraphs' => 'integer|min:1|max:10',
            'tone' => 'string|in:formal,casual,technical,creative',
            'language' => 'string|in:arabic,english'
        ]);

        try {
            $client = OpenAI::client(config('app.openai_api_key', env('OPENAI_API_KEY')));

            $topic = $request->topic;
            $paragraphs = $request->paragraphs ?? 3;
            $tone = $request->tone ?? 'formal';
            $language = $request->language ?? 'arabic';

            // بناء الطلب حسب اللغة المطلوبة
            if ($language === 'arabic') {
                $prompt = "اكتب تقريراً شاملاً باللغة العربية حول موضوع: {$topic}

المتطلبات:
- عدد الفقرات: {$paragraphs}
- النبرة: " . $this->getToneInArabic($tone) . "
- استخدم تنسيق Markdown مع العناوين والقوائم
- اجعل المحتوى مفيداً ومنظماً
- ابدأ بعنوان رئيسي ثم مقدمة
- قسم المحتوى إلى أقسام واضحة
- اختتم بخلاصة أو استنتاج

اكتب التقرير بصيغة Markdown:";
            } else {
                $prompt = "Write a comprehensive report in English about: {$topic}

Requirements:
- Number of paragraphs: {$paragraphs}
- Tone: {$tone}
- Use Markdown formatting with headers and lists
- Make the content useful and well-organized
- Start with a main title and introduction
- Divide content into clear sections
- End with a summary or conclusion

Write the report in Markdown format:";
            }

            $response = $client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 2000,
                'temperature' => 0.7
            ]);

            $content = $response->choices[0]->message->content;

            return response()->json([
                'success' => true,
                'content' => $content,
                'topic' => $topic,
                'settings' => [
                    'paragraphs' => $paragraphs,
                    'tone' => $tone,
                    'language' => $language
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ في توليد المحتوى: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test 6: تعديل المحتوى الحالي باستخدام OpenAI
     */
    public function editContent(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'instruction' => 'required|string|max:500'
        ]);

        try {
            $client = OpenAI::client(config('app.openai_api_key', env('OPENAI_API_KEY')));

            $content = $request->content;
            $instruction = $request->instruction;

            $prompt = "لديك المحتوى التالي بصيغة Markdown:

{$content}

تعليمات التعديل: {$instruction}

قم بتطبيق التعديل المطلوب واحتفظ بتنسيق Markdown. أعد كتابة المحتوى كاملاً مع التحسينات:";

            $response = $client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'max_tokens' => 2500,
                'temperature' => 0.5
            ]);

            $editedContent = $response->choices[0]->message->content;

            return response()->json([
                'success' => true,
                'content' => $editedContent,
                'instruction' => $instruction
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ في تعديل المحتوى: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ترجمة نبرة الكتابة للعربية
     */
    private function getToneInArabic($tone)
    {
        $tones = [
            'formal' => 'رسمية ومهنية',
            'casual' => 'ودية وغير رسمية',
            'technical' => 'تقنية ومتخصصة',
            'creative' => 'إبداعية وجذابة'
        ];

        return $tones[$tone] ?? 'رسمية ومهنية';
    }

    /**
     * Test 8: عرض صفحة محول HTML to PDF
     */
    public function test8()
    {
        return view('test8');
    }

    /**
     * Test 8: أخذ screenshot لصفحة HTML
     */
    public function takeScreenshot(Request $request)
    {
        $request->validate([
            'type' => 'required|in:html,url',
            'content' => 'required'
        ]);

        try {
            $filename = 'screenshot_' . time() . '.png';
            $path = storage_path('app/public/screenshots/' . $filename);

            // إنشاء المجلد إذا لم يكن موجوداً
            if (!file_exists(storage_path('app/public/screenshots'))) {
                mkdir(storage_path('app/public/screenshots'), 0777, true);
            }

            // استخدام Chrome Beta
            $chromePath = '/Applications/Google Chrome Beta.app/Contents/MacOS/Google Chrome Beta';

            if ($request->type === 'html') {
                $browsershot = Browsershot::html($request->content)
                    ->setChromePath($chromePath)
                    ->noSandbox()
                    ->windowSize(1920, 1080)
                    ->deviceScaleFactor(2)     // دقة عالية للصور
                    ->emulateMedia('screen')   // عرض CSS كما في المتصفح
                    ->waitUntilNetworkIdle()
                    ->fullPage()
                    ->userAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                    ->ignoreHttpsErrors()
                    ->setOption('args', [
                        '--disable-web-security',
                        '--font-render-hinting=none',
                        '--enable-font-antialiasing'
                    ]);
            } else {
                $browsershot = Browsershot::url($request->content)
                    ->setChromePath($chromePath)
                    ->noSandbox()
                    ->windowSize(1920, 1080)
                    ->deviceScaleFactor(2)     // دقة عالية للصور
                    ->emulateMedia('screen')   // عرض CSS كما في المتصفح
                    ->waitUntilNetworkIdle()
                    ->fullPage()
                    ->userAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                    ->ignoreHttpsErrors()
                    ->setOption('args', [
                        '--disable-web-security',
                        '--font-render-hinting=none',
                        '--enable-font-antialiasing'
                    ]);
            }

            $browsershot->save($path);

            return response()->json([
                'success' => true,
                'download_url' => '/storage/screenshots/' . $filename,
                'preview_url' => '/storage/screenshots/' . $filename,
                'message' => 'تم أخذ لقطة الشاشة بنجاح'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test 8: تحويل HTML إلى PDF
     */
    public function convertToPdf(Request $request)
    {
        $request->validate([
            'type' => 'required|in:html,url',
            'content' => 'required',
            'options' => 'array'
        ]);

        try {
            $filename = 'document_' . time() . '.pdf';
            $path = storage_path('app/public/pdfs/' . $filename);

            // إنشاء المجلد إذا لم يكن موجوداً
            if (!file_exists(storage_path('app/public/pdfs'))) {
                mkdir(storage_path('app/public/pdfs'), 0777, true);
            }

            $format = $request->input('options.format', 'A4');
            $orientation = $request->input('options.orientation', 'portrait');
            $margin = $request->input('options.margin', 10);

            // استخدام Chrome Beta
            $chromePath = '/Applications/Google Chrome Beta.app/Contents/MacOS/Google Chrome Beta';

            if ($request->type === 'html') {
                $browsershot = Browsershot::html($request->content)
                    ->setChromePath($chromePath)
                    ->noSandbox()
                    ->format($format)
                    ->margins($margin, $margin, $margin, $margin, 'mm')
                    ->emulateMedia('screen')  // مهم جداً لعرض CSS بشكل صحيح
                    ->showBackground()         // عرض الخلفيات
                    ->setOption('printBackground', true)  // طباعة الخلفيات
                    ->waitUntilNetworkIdle()
                    ->timeout(120)             // وقت انتظار أطول
                    ->deviceScaleFactor(2)     // دقة عالية
                    ->userAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                    ->ignoreHttpsErrors()
                    ->setOption('args', [
                        '--disable-web-security',
                        '--font-render-hinting=none',
                        '--enable-font-antialiasing',
                        '--disable-gpu'
                    ]);
            } else {
                $browsershot = Browsershot::url($request->content)
                    ->setChromePath($chromePath)
                    ->noSandbox()
                    ->format($format)
                    ->margins($margin, $margin, $margin, $margin, 'mm')
                    ->emulateMedia('screen')  // مهم جداً لعرض CSS بشكل صحيح
                    ->showBackground()         // عرض الخلفيات
                    ->setOption('printBackground', true)  // طباعة الخلفيات
                    ->waitUntilNetworkIdle()
                    ->timeout(120)             // وقت انتظار أطول
                    ->deviceScaleFactor(2)     // دقة عالية
                    ->userAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36')
                    ->ignoreHttpsErrors()
                    ->setOption('args', [
                        '--disable-web-security',
                        '--font-render-hinting=none',
                        '--enable-font-antialiasing',
                        '--disable-gpu'
                    ]);
            }

            if ($orientation === 'landscape') {
                $browsershot->landscape();
            }

            $browsershot->savePdf($path);

            return response()->json([
                'success' => true,
                'download_url' => '/storage/pdfs/' . $filename,
                'message' => 'تم إنشاء ملف PDF بنجاح'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    // Test 9
    public function test9()
    {
        return view('test9');
    }

    public function test9GeneratePdf(Request $request)
    {
        $request->validate([
            'html' => 'required|string',
            'engine' => 'string|in:auto,chrome,firefox',
            'deviceType' => 'string|in:desktop,mobile,tablet',
            'pageSize' => 'string|in:A4,A3,Letter,Legal',
            'orientation' => 'string|in:portrait,landscape',
            'pageMode' => 'string|in:paged,continuous',
            'margins' => 'array',
            'margins.top' => 'integer|min:0|max:50',
            'margins.right' => 'integer|min:0|max:50',
            'margins.bottom' => 'integer|min:0|max:50',
            'margins.left' => 'integer|min:0|max:50',
            'printBackground' => 'boolean',
            'displayHeader' => 'boolean'
        ]);

        try {
            $html = $request->html;
            $engine = $request->engine ?? 'auto';
            $deviceType = $request->deviceType ?? 'desktop';
            $pageSize = $request->pageSize ?? 'A4';
            $orientation = $request->orientation ?? 'portrait';
            $pageMode = $request->pageMode ?? 'paged';
            $margins = $request->margins ?? ['top' => 15, 'right' => 15, 'bottom' => 15, 'left' => 15];
            $printBackground = $request->printBackground ?? true;
            $displayHeader = $request->displayHeader ?? false;

            // Log settings for debugging
            \Log::info('PDF Settings:', [
                'device' => $deviceType,
                'margins' => $margins
            ]);

            // Auto detect engine based on content
            if ($engine === 'auto') {
                $engine = $this->detectBestEngine($html);
            }

            // Set Chrome path
            $chromePath = '/Applications/Google Chrome Beta.app/Contents/MacOS/Google Chrome Beta';
            if (!file_exists($chromePath)) {
                $chromePath = '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
            }

            // Set viewport and page size based on device type
            $deviceScale = 1;
            $customPageSize = null;

            // For continuous mode, we need to capture full height
            $isContinuous = ($pageMode === 'continuous');

            switch ($deviceType) {
                case 'mobile':
                    // iPhone 14 Pro Max dimensions
                    $viewportWidth = 430;
                    $viewportHeight = 932;
                    $deviceScale = 2;

                    // Add mobile viewport meta tag and responsive CSS
                    // Check if user wants margins
                    $hasPadding = !($margins['top'] === 0 && $margins['right'] === 0 &&
                                   $margins['bottom'] === 0 && $margins['left'] === 0);

                    $paddingValue = $hasPadding ? '15px' : '0';

                    $mobileCSS = '<style>
                        body {
                            max-width: 430px !important;
                            margin: 0 !important;
                            padding: ' . $paddingValue . ' !important;
                            width: 100% !important;
                            box-sizing: border-box !important;
                        }
                        * {
                            max-width: 100% !important;
                            word-wrap: break-word !important;
                        }
                    </style>';

                    if (strpos($html, '<head>') !== false) {
                        $html = str_replace('<head>', '<head><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">' . $mobileCSS, $html);
                    } else {
                        $html = '<head><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">' . $mobileCSS . '</head>' . $html;
                    }

                    // Custom page size for mobile (in mm)
                    if (!$isContinuous) {
                        $customPageSize = '114mm 247mm';
                    }
                    break;

                case 'tablet':
                    // iPad Pro 11" dimensions
                    $viewportWidth = 834;
                    $viewportHeight = 1194;
                    $deviceScale = 2;

                    // Custom page size for tablet (in mm)
                    if (!$isContinuous) {
                        $customPageSize = '221mm 316mm';
                    }
                    break;

                default: // desktop
                    // Standard desktop viewport
                    $viewportWidth = 1920;
                    $viewportHeight = 1080;
                    $deviceScale = 1;

                    // No custom size needed for desktop in continuous mode
                    break;
            }

            // Create Browsershot instance with appropriate settings
            $browsershot = Browsershot::html($html)
                ->setChromePath($chromePath)
                ->showBackground($printBackground)
                ->emulateMedia('screen')
                ->waitUntilNetworkIdle()
                ->windowSize($viewportWidth, $viewportHeight)
                ->deviceScaleFactor($deviceScale);

            // For continuous mode, use fullPage to capture all content
            if ($isContinuous) {
                // For continuous mode, we still need to set appropriate width based on device
                if ($deviceType === 'mobile') {
                    // Set mobile width for continuous mode
                    $browsershot->paperSize(114, 2000); // 114mm width (mobile), 2000mm max height
                } elseif ($deviceType === 'tablet') {
                    // Set tablet width for continuous mode
                    $browsershot->paperSize(221, 2000); // 221mm width (tablet), 2000mm max height
                } else {
                    // Desktop width for continuous mode
                    $browsershot->paperSize(210, 2000); // 210mm width (A4), 2000mm max height
                }
                $browsershot->fullPage();
            } else {
                // For paged mode, set page format
                if ($customPageSize) {
                    // For mobile/tablet, use custom page size
                    // Split the custom size to width and height
                    $sizeParts = explode(' ', $customPageSize);
                    $width = floatval($sizeParts[0]);
                    $height = floatval($sizeParts[1]);
                    $browsershot->paperSize($width, $height);
                } else {
                    // For standard desktop paged mode
                    $browsershot->format($pageSize);
                }
            }

            // Set orientation
            if ($orientation === 'landscape') {
                $browsershot->landscape();
            }

            // Set margins from request FIRST (before header/footer)
            // For mobile in continuous mode with no margins selected, force 0
            if ($isContinuous && $deviceType === 'mobile' &&
                $margins['top'] === 0 && $margins['right'] === 0 &&
                $margins['bottom'] === 0 && $margins['left'] === 0) {
                $browsershot->margins(0, 0, 0, 0, 'mm');
            } else {
                $browsershot->margins(
                    $margins['top'] ?? 15,
                    $margins['right'] ?? 15,
                    $margins['bottom'] ?? 15,
                    $margins['left'] ?? 15,
                    'mm'
                );
            }

            // Add header/footer if requested (AFTER margins)
            if ($displayHeader) {
                // When using header/footer, we need some margin
                $minMargin = 10;
                if ($margins['top'] < $minMargin || $margins['bottom'] < $minMargin) {
                    $browsershot->margins(
                        max($margins['top'], $minMargin),
                        $margins['right'],
                        max($margins['bottom'], $minMargin),
                        $margins['left'],
                        'mm'
                    );
                }

                $browsershot->showBrowserHeaderAndFooter()
                    ->headerHtml('<div style="font-size: 10px; text-align: center; width: 100%;">
                        <span>Generated PDF - Page <span class="pageNumber"></span> of <span class="totalPages"></span></span>
                    </div>')
                    ->footerHtml('<div style="font-size: 10px; text-align: center; width: 100%; color: #666;">
                        <span>' . date('Y-m-d H:i') . '</span>
                    </div>');
            }

            // Add Chrome flags for better rendering
            $browsershot->setOption('args', [
                '--disable-web-security',
                '--disable-gpu',
                '--no-sandbox'
            ]);

            // Generate PDF
            $pdf = $browsershot->pdf();

            return response($pdf, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="document-' . time() . '.pdf"');

        } catch (\Exception $e) {
            \Log::error('Test9 PDF Generation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'فشل في إنشاء PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    private function detectBestEngine($html)
    {
        // Check for complex CSS features
        $hasTextShadow = stripos($html, 'text-shadow') !== false;
        $hasGradients = stripos($html, 'gradient') !== false;
        $hasComplexCSS = stripos($html, 'backdrop-filter') !== false ||
                         stripos($html, 'filter:') !== false;

        // If has complex CSS, use Firefox (when implemented)
        // For now, always use Chrome
        if ($hasTextShadow || $hasGradients || $hasComplexCSS) {
            // In future: return 'firefox';
            return 'chrome';
        }

        return 'chrome';
    }
}
