# PageSeo - Управління SEO метаданими сторінок

Модель `PageSeo` дозволяє керувати SEO метаданими для статичних сторінок сайту, які не мають власних моделей (головна сторінка, сторінка блогу, контакти тощо).

## Модель PageSeo

### Поля

- `key` - унікальний ключ сторінки (наприклад: `home`, `blog`, `contact`)
- `title` - SEO заголовок сторінки
- `meta_description` - META опис для пошукових систем
- `keywords` - ключові слова через кому
- `noindex` - заборона індексації (boolean)
- `nofollow` - заборона переходу по посиланням (boolean)
- `additional_meta` - додаткові META теги у JSON форматі

### Методи

```php
// Отримати SEO дані за ключем
$seo = PageSeo::getByKey('home');

// Атрибути-хелпери
$seo->robots; // "index, follow" або "noindex, nofollow"
$seo->keywords_array; // масив ключових слів
```

## Хелпери

### page_seo($key)
Отримує модель PageSeo за ключем.

```php
$homeSeo = page_seo('home');
```

### page_title($key, $fallback = null)
Отримує заголовок сторінки з fallback.

```php
$title = page_title('home', 'Головна сторінка');
```

### page_description($key, $fallback = null)
Отримує опис сторінки з fallback.

```php
$description = page_description('home', 'Опис за замовчуванням');
```

### page_keywords($key)
Отримує ключові слова сторінки.

```php
$keywords = page_keywords('home');
```

### page_robots($key)
Отримує robots meta content.

```php
$robots = page_robots('home'); // "index, follow"
```

## Використання в Blade шаблонах

### Основний спосіб

```blade
<x-seo-meta page-key="home" />
```

### З перевизначенням

```blade
<x-seo-meta 
    page-key="blog" 
    title="Спеціальний заголовок"
    description="Спеціальний опис"
/>
```

### Ручне використання

```blade
<title>{{ page_title('home') }}</title>
<meta name="description" content="{{ page_description('home') }}">
<meta name="keywords" content="{{ page_keywords('home') }}">
<meta name="robots" content="{{ page_robots('home') }}">
```

## Управління через Filament

Перейдіть в адмін-панель Filament в розділ "Контент" → "SEO сторінок" для управління SEO даними.

### Створення нових записів

1. Натисніть "Створити"
2. Введіть унікальний ключ (наприклад: `about`, `services`)
3. Заповніть SEO дані
4. Збережіть

### Додаткові META теги

У полі "Додаткові META теги" можна вказати JSON з додатковими тегами:

```json
{
    "og:type": "website",
    "og:image": "/images/preview.jpg",
    "twitter:site": "@yoursite"
}
```

## Приклади використання

### Головна сторінка

```blade
{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('meta')
    <x-seo-meta page-key="home" />
@endsection

@section('content')
    <h1>{{ page_title('home') }}</h1>
    {{-- контент --}}
@endsection
```

### Сторінка блогу

```blade
{{-- resources/views/blog/index.blade.php --}}
@extends('layouts.app')

@section('meta')
    <x-seo-meta page-key="blog" />
@endsection

@section('content')
    <h1>{{ page_title('blog', 'Блог') }}</h1>
    {{-- список постів --}}
@endsection
```

### В контролері

```php
class HomeController extends Controller
{
    public function index()
    {
        $seo = page_seo('home');
        
        return view('home', compact('seo'));
    }
}
```

## Тестування

Запустіть тести:

```bash
./vendor/bin/sail artisan test --filter=PageSeoTest
```

## Сідер даних

Для автоматичного наповнення базових SEO даних використовуйте сідер:

```bash
# Запуск тільки PageSeo сідера
./vendor/bin/sail artisan db:seed --class=PageSeoSeeder

# Або весь набір сідерів (включає PageSeoSeeder)
./vendor/bin/sail artisan db:seed
```

### Дані, які створює сідер:

| Ключ     | Призначення                    | Індексується |
|----------|--------------------------------|--------------|
| `home`   | Головна сторінка              | ✅ Так       |
| `blog`   | Сторінка блогу                | ✅ Так       |
| `contact`| Сторінка контактів            | ✅ Так       |
| `about`  | Сторінка "Про нас"            | ✅ Так       |
| `terms`  | Правила та умови              | ❌ Ні        |
| `privacy`| Політика конфіденційності     | ❌ Ні        |

### Особливості сідера:

- **updateOrCreate()** - запобігає дублюванню при повторному запуску
- **Оптимальна довжина** мета-описів (до 160 символів)
- **Додаткові Open Graph теги** для соціальних мереж
- **Правильна індексація** - сервісні сторінки позначені як `noindex`