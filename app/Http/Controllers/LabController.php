<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;

class LabController extends Controller
{
    /**
     * عرض صفحة المختبر الرئيسية
     */
    public function index()
    {
        return view('lab.index');
    }

    /**
     * عرض صفحة التجارب
     */
    public function experiments()
    {
        return view('lab.experiments', [
            'engines' => $this->getAvailableEngines(),
            'themes' => $this->getAvailableThemes(),
        ]);
    }

    /**
     * اختبار محرك معين
     */
    public function testEngine(Request $request)
    {
        $request->validate([
            'markdown' => 'required|string|max:5000000', // 5MB للاختبارات
            'engine' => 'required|string',
            'options' => 'nullable|array',
        ]);

        $markdown = $request->input('markdown');
        $engine = $request->input('engine');
        $options = $request->input('options', []);

        try {
            $startTime = microtime(true);
            $memoryBefore = memory_get_usage();

            $result = $this->processWithEngine($markdown, $engine, $options);

            $memoryAfter = memory_get_usage();
            $conversionTime = (microtime(true) - $startTime) * 1000;
            $memoryUsed = $memoryAfter - $memoryBefore;

            return response()->json([
                'success' => true,
                'html' => $result['html'],
                'stats' => [
                    'conversion_time_ms' => round($conversionTime, 2),
                    'memory_used_bytes' => $memoryUsed,
                    'memory_used_mb' => round($memoryUsed / 1024 / 1024, 2),
                    'input_size' => strlen($markdown),
                    'output_size' => strlen($result['html']),
                    'compression_ratio' => round(strlen($result['html']) / strlen($markdown), 2),
                ],
                'engine' => [
                    'name' => $engine,
                    'version' => $result['version'] ?? 'unknown',
                    'options' => $options,
                ],
                'warnings' => $result['warnings'] ?? [],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في التحويل: ' . $e->getMessage(),
                'engine' => $engine,
            ], 500);
        }
    }

    /**
     * معالجة Markdown بالمحرك المحدد
     */
    private function processWithEngine(string $markdown, string $engine, array $options): array
    {
        $warnings = [];

        switch ($engine) {
            case 'commonmark':
                $html = $this->convertWithCommonMark($markdown, $options);
                $version = '2.7';
                break;

            case 'marked':
                $warnings[] = 'Marked.js يعمل في المتصفح فقط';
                $html = '<p>استخدم المتصفح لاختبار Marked.js</p>';
                $version = '15.0';
                break;

            case 'rust':
                $warnings[] = 'Rust engine قيد التطوير';
                $html = $this->simulateRustEngine($markdown);
                $version = 'experimental';
                break;

            case 'python':
                $warnings[] = 'Python engine قيد التطوير';
                $html = $this->simulatePythonEngine($markdown);
                $version = 'experimental';
                break;

            default:
                throw new \InvalidArgumentException("محرك غير معروف: {$engine}");
        }

        return [
            'html' => $html,
            'version' => $version,
            'warnings' => $warnings,
        ];
    }

    /**
     * تحويل باستخدام CommonMark
     */
    private function convertWithCommonMark(string $markdown, array $options): string
    {
        $config = array_merge([
            'html_input' => 'allow',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 100,
        ], $options);

        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        $converter = new MarkdownConverter($environment);

        return $converter->convert($markdown)->getContent();
    }

    /**
     * محاكاة Rust engine (للعرض التوضيحي)
     */
    private function simulateRustEngine(string $markdown): string
    {
        // هنا سيتم ربط Rust binary أو microservice
        return $this->convertWithCommonMark($markdown, []);
    }

    /**
     * محاكاة Python engine (للعرض التوضيحي)
     */
    private function simulatePythonEngine(string $markdown): string
    {
        // هنا سيتم ربط Python microservice
        return $this->convertWithCommonMark($markdown, []);
    }

    /**
     * قائمة المحركات المتاحة
     */
    private function getAvailableEngines(): array
    {
        return [
            [
                'id' => 'marked',
                'name' => 'Marked.js',
                'language' => 'JavaScript',
                'speed' => 5400,
                'speed_unit' => 'ops/sec',
                'status' => 'active',
                'features' => ['GFM', 'Fast', 'Browser'],
            ],
            [
                'id' => 'commonmark',
                'name' => 'League CommonMark',
                'language' => 'PHP',
                'speed' => 500,
                'speed_unit' => 'ops/sec',
                'status' => 'active',
                'features' => ['GFM', 'Extensible', 'Server-side'],
            ],
            [
                'id' => 'rust',
                'name' => 'Pulldown-cmark',
                'language' => 'Rust',
                'speed' => 100000,
                'speed_unit' => 'ops/sec',
                'status' => 'coming_soon',
                'features' => ['Ultra-fast', 'Safe', 'Large files'],
            ],
            [
                'id' => 'python',
                'name' => 'Python-Markdown',
                'language' => 'Python',
                'speed' => 2000,
                'speed_unit' => 'ops/sec',
                'status' => 'coming_soon',
                'features' => ['RTL', 'Arabic', '40+ Extensions'],
            ],
        ];
    }

    /**
     * قائمة الثيمات المتاحة
     */
    private function getAvailableThemes(): array
    {
        return [
            ['id' => 'github', 'name' => 'GitHub', 'status' => 'active'],
            ['id' => 'default', 'name' => 'Default', 'status' => 'active'],
            ['id' => 'dark', 'name' => 'Dark Mode', 'status' => 'coming_soon'],
            ['id' => 'ocean', 'name' => 'Ocean', 'status' => 'coming_soon'],
        ];
    }
}
