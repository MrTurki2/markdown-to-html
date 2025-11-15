@extends('layouts.app')

@section('title', 'التجارب - Markdown Lab')

@push('styles')
<style>
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .float-animation {
        animation: float 3s ease-in-out infinite;
    }
    .gradient-text {
        background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endpush

@section('content')
<div class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Hero Section -->
        <div class="text-center mb-12">
            <div class="inline-block mb-4">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center text-white font-bold text-3xl float-animation mx-auto shadow-lg">
                    🧪
                </div>
            </div>
            <h1 class="text-5xl font-bold mb-4">
                <span class="gradient-text">مختبر التجارب</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                مجموعة شاملة من التجارب المتقدمة لتحويل Markdown مع مميزات مختلفة
            </p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
            <div class="bg-white rounded-xl p-4 text-center shadow-md">
                <div class="text-3xl font-bold text-purple-600">8</div>
                <div class="text-sm text-gray-600">تجارب متاحة</div>
            </div>
            <div class="bg-white rounded-xl p-4 text-center shadow-md">
                <div class="text-3xl font-bold text-blue-600">3</div>
                <div class="text-sm text-gray-600">أنواع التصدير</div>
            </div>
            <div class="bg-white rounded-xl p-4 text-center shadow-md">
                <div class="text-3xl font-bold text-green-600">5</div>
                <div class="text-sm text-gray-600">محررات مختلفة</div>
            </div>
            <div class="bg-white rounded-xl p-4 text-center shadow-md">
                <div class="text-3xl font-bold text-orange-600">∞</div>
                <div class="text-sm text-gray-600">إمكانيات</div>
            </div>
        </div>

        <!-- Experiments Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Test 2: Save Files -->
            <a href="{{ route('lab.test2') }}" class="block bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-green-500 to-emerald-500 p-6">
                    <div class="text-white text-4xl mb-2">💾</div>
                    <h3 class="text-white text-xl font-bold">Test 2</h3>
                </div>
                <div class="p-6">
                    <h4 class="font-bold text-lg mb-2 text-gray-800">حفظ وإدارة الملفات</h4>
                    <p class="text-gray-600 text-sm mb-4">
                        محول Markdown مع إمكانية حفظ الملفات، تحميل HTML/MD، وإدارة الملفات المحفوظة
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">حفظ</span>
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">تحميل</span>
                        <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full">إدارة</span>
                    </div>
                </div>
            </a>

            <!-- Test 3: Text Files -->
            <a href="{{ route('lab.test3') }}" class="block bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-6">
                    <div class="text-white text-4xl mb-2">📝</div>
                    <h3 class="text-white text-xl font-bold">Test 3</h3>
                </div>
                <div class="p-6">
                    <h4 class="font-bold text-lg mb-2 text-gray-800">حفظ ملفات نصية</h4>
                    <p class="text-gray-600 text-sm mb-4">
                        تحويل Markdown مع حفظ الملفات النصية وتحميلها بصيغ مختلفة
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">نصوص</span>
                        <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs rounded-full">ملفات</span>
                    </div>
                </div>
            </a>

            <!-- Test 4: Quill Editor -->
            <a href="{{ route('lab.test4') }}" class="block bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-6">
                    <div class="text-white text-4xl mb-2">✏️</div>
                    <h3 class="text-white text-xl font-bold">Test 4</h3>
                </div>
                <div class="p-6">
                    <h4 class="font-bold text-lg mb-2 text-gray-800">محرر Quill</h4>
                    <p class="text-gray-600 text-sm mb-4">
                        محرر نصوص غني (WYSIWYG) مع Quill.js لتحرير المحتوى بشكل مرئي
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full">Quill</span>
                        <span class="px-2 py-1 bg-pink-100 text-pink-700 text-xs rounded-full">WYSIWYG</span>
                    </div>
                </div>
            </a>

            <!-- Test 5: PDF Generation -->
            <a href="{{ route('lab.test5') }}" class="block bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-red-500 to-orange-500 p-6">
                    <div class="text-white text-4xl mb-2">📄</div>
                    <h3 class="text-white text-xl font-bold">Test 5</h3>
                </div>
                <div class="p-6">
                    <h4 class="font-bold text-lg mb-2 text-gray-800">توليد PDF</h4>
                    <p class="text-gray-600 text-sm mb-4">
                        تحويل Markdown إلى PDF مباشرة مع تنسيق احترافي
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">PDF</span>
                        <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs rounded-full">تصدير</span>
                    </div>
                </div>
            </a>

            <!-- Test 6: Content Generation -->
            <a href="{{ route('lab.test6') }}" class="block bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-cyan-500 to-blue-500 p-6">
                    <div class="text-white text-4xl mb-2">🤖</div>
                    <h3 class="text-white text-xl font-bold">Test 6</h3>
                </div>
                <div class="p-6">
                    <h4 class="font-bold text-lg mb-2 text-gray-800">توليد المحتوى</h4>
                    <p class="text-gray-600 text-sm mb-4">
                        توليد وتحرير محتوى Markdown تلقائياً مع مميزات ذكية
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2 py-1 bg-cyan-100 text-cyan-700 text-xs rounded-full">AI</span>
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">توليد</span>
                    </div>
                </div>
            </a>

            <!-- Test 8: Screenshot & PDF -->
            <a href="{{ route('lab.test8') }}" class="block bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-yellow-500 to-amber-500 p-6">
                    <div class="text-white text-4xl mb-2">📸</div>
                    <h3 class="text-white text-xl font-bold">Test 8</h3>
                </div>
                <div class="p-6">
                    <h4 class="font-bold text-lg mb-2 text-gray-800">لقطات شاشة و PDF</h4>
                    <p class="text-gray-600 text-sm mb-4">
                        التقاط screenshots وتحويل الصفحات إلى PDF باستخدام Puppeteer
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Screenshot</span>
                        <span class="px-2 py-1 bg-amber-100 text-amber-700 text-xs rounded-full">Puppeteer</span>
                    </div>
                </div>
            </a>

            <!-- Test 9: Advanced PDF -->
            <a href="{{ route('lab.test9') }}" class="block bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-violet-500 to-purple-500 p-6">
                    <div class="text-white text-4xl mb-2">📚</div>
                    <h3 class="text-white text-xl font-bold">Test 9</h3>
                </div>
                <div class="p-6">
                    <h4 class="font-bold text-lg mb-2 text-gray-800">PDF متقدم</h4>
                    <p class="text-gray-600 text-sm mb-4">
                        توليد PDF احترافي مع تنسيقات متقدمة وخيارات تخصيص شاملة
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2 py-1 bg-violet-100 text-violet-700 text-xs rounded-full">Advanced</span>
                        <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full">Pro</span>
                    </div>
                </div>
            </a>

            <!-- Coming Soon Card -->
            <div class="bg-gray-100 rounded-xl shadow-lg overflow-hidden opacity-60">
                <div class="bg-gradient-to-r from-gray-400 to-gray-500 p-6">
                    <div class="text-white text-4xl mb-2">🔜</div>
                    <h3 class="text-white text-xl font-bold">قريباً</h3>
                </div>
                <div class="p-6">
                    <h4 class="font-bold text-lg mb-2 text-gray-800">تجارب جديدة</h4>
                    <p class="text-gray-600 text-sm mb-4">
                        المزيد من التجارب والمميزات قيد التطوير...
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2 py-1 bg-gray-200 text-gray-700 text-xs rounded-full">قريباً</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Info Section -->
        <div class="mt-12 bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">💡 نصائح للاستخدام</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-bold text-lg mb-2 text-purple-600">اختر التجربة المناسبة</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>• <strong>Test 2:</strong> إذا كنت تريد حفظ عملك</li>
                        <li>• <strong>Test 4:</strong> للتحرير المرئي السهل</li>
                        <li>• <strong>Test 5/8/9:</strong> لتصدير PDF</li>
                        <li>• <strong>Test 6:</strong> للمحتوى التلقائي</li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-2 text-blue-600">المميزات المشتركة</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>• معاينة مباشرة للـ HTML</li>
                        <li>• دعم كامل للعربية والـ RTL</li>
                        <li>• تنسيقات Markdown متقدمة</li>
                        <li>• واجهات سهلة الاستخدام</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Back to Lab -->
        <div class="mt-8 text-center">
            <a href="{{ route('lab.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة للمختبر الرئيسي
            </a>
        </div>

    </div>
</div>
@endsection
