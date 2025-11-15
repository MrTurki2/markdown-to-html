<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;

class PublicController extends Controller
{
    /**
     * عرض الصفحة الرئيسية للمحول العام
     */
    public function index()
    {
        return view('public.index', [
            'sampleMarkdown' => $this->getSampleMarkdown()
        ]);
    }

    /**
     * تحويل Markdown إلى HTML
     */
    public function convert(Request $request)
    {
        $request->validate([
            'markdown' => 'required|string|max:1000000', // 1MB max
            'engine' => 'nullable|string|in:commonmark,marked',
        ]);

        $markdown = $request->input('markdown');
        $engine = $request->input('engine', 'commonmark');

        try {
            $startTime = microtime(true);

            if ($engine === 'commonmark') {
                $html = $this->convertWithCommonMark($markdown);
            } else {
                // Marked.js يتم تنفيذه في الـ Frontend
                return response()->json([
                    'success' => false,
                    'message' => 'Marked.js يعمل في المتصفح فقط'
                ]);
            }

            $conversionTime = (microtime(true) - $startTime) * 1000; // ms

            return response()->json([
                'success' => true,
                'html' => $html,
                'conversion_time' => round($conversionTime, 2),
                'engine' => $engine,
                'input_size' => strlen($markdown),
                'output_size' => strlen($html),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في التحويل: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تحويل باستخدام League CommonMark
     */
    private function convertWithCommonMark(string $markdown): string
    {
        $config = [
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
        ];

        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        $converter = new MarkdownConverter($environment);

        return $converter->convert($markdown)->getContent();
    }

    /**
     * نموذج Markdown للعرض
     */
    private function getSampleMarkdown(): string
    {
        return <<<'MARKDOWN'
# مرحباً بك! 👋

اكتب أو الصق نص **Markdown** هنا...

## المميزات:
- تحويل فوري
- معاينة مباشرة
- دعم كامل لـ RTL والعربية
- تصدير HTML

```javascript
console.log('مثال على الكود');
```

> نصيحة: جرب كتابة Markdown وشاهد النتيجة مباشرة!
MARKDOWN;
    }
}
