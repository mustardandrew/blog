<?php

namespace Database\Seeders;

use App\Models\PageSeo;
use Illuminate\Database\Seeder;

class PageSeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // SEO для головної сторінки
        PageSeo::updateOrCreate(
            ['key' => 'home'],
            [
                'title' => 'LitBlog - Книжкові враження та літературні рецензії',
                'meta_description' => 'Вітаємо на LitBlog! Тут ви знайдете захоплюючі рецензії на книги, літературні аналізи та особисті враження від прочитаного. Діліться думками про улюблені твори.',
                'keywords' => 'книги, література, рецензії, враження, блог, читання, книжковий блог',
                'noindex' => false,
                'nofollow' => false,
                'additional_meta' => [
                    'og:type' => 'website',
                    'og:image' => '/images/litblog-home.jpg',
                    'og:locale' => 'uk_UA',
                    'twitter:card' => 'summary_large_image',
                    'twitter:creator' => '@litblog_ua',
                ],
            ]
        );

        // SEO для сторінки блогу
        PageSeo::updateOrCreate(
            ['key' => 'blog'],
            [
                'title' => 'Блог - Останні рецензії та літературні статті | LitBlog',
                'meta_description' => 'Перегляньте найновіші рецензії на книги, літературні аналізи та статті про сучасну та класичну літературу. Знайдіть свою наступну улюблену книгу.',
                'keywords' => 'рецензії книг, літературний блог, аналіз літератури, книжкові огляди, новинки літератури',
                'noindex' => false,
                'nofollow' => false,
                'additional_meta' => [
                    'og:type' => 'blog',
                    'og:image' => '/images/litblog-articles.jpg',
                    'robots' => 'index, follow, max-snippet:-1, max-image-preview:large',
                ],
            ]
        );

        // SEO для сторінки контактів
        PageSeo::updateOrCreate(
            ['key' => 'contact'],
            [
                'title' => 'Контакти - Зв\'яжіться з нами | LitBlog',
                'meta_description' => 'Маєте питання, пропозиції або хочете поділитися враженнями від книг? Зв\'яжіться з командою LitBlog через контактну форму.',
                'keywords' => 'контакти, зв\'язок, літературний блог, співпраця, пропозиції',
                'noindex' => false,
                'nofollow' => false,
                'additional_meta' => [
                    'og:type' => 'website',
                    'og:image' => '/images/litblog-contact.jpg',
                ],
            ]
        );

        // Додаткові сторінки (для майбутнього розширення)
        PageSeo::updateOrCreate(
            ['key' => 'about'],
            [
                'title' => 'Про нас - Історія LitBlog та наша місія',
                'meta_description' => 'Дізнайтеся більше про LitBlog, нашу команду та місію популяризації читання української та світової літератури.',
                'keywords' => 'про нас, команда, місія, літературний блог, популяризація читання',
                'noindex' => false,
                'nofollow' => false,
            ]
        );

        // Сторінка правил та умов
        PageSeo::updateOrCreate(
            ['key' => 'terms'],
            [
                'title' => 'Правила та умови використання | LitBlog',
                'meta_description' => 'Ознайомтеся з правилами та умовами використання сайту LitBlog, політикою конфіденційності та правилами коментування.',
                'keywords' => 'правила, умови використання, політика конфіденційності',
                'noindex' => true,
                'nofollow' => true,
            ]
        );

        // Сторінка політики конфіденційності
        PageSeo::updateOrCreate(
            ['key' => 'privacy'],
            [
                'title' => 'Політика конфіденційності | LitBlog',
                'meta_description' => 'Дізнайтеся, як ми збираємо, використовуємо та захищаємо ваші особисті дані на сайті LitBlog.',
                'keywords' => 'політика конфіденційності, захист даних, персональні дані',
                'noindex' => true,
                'nofollow' => true,
            ]
        );

        $this->command->info('PageSeo records created successfully!');
        $this->command->table(
            ['Key', 'Title', 'Meta Description Length', 'Indexed'],
            PageSeo::all()->map(fn ($seo) => [
                $seo->key,
                mb_substr($seo->title, 0, 50).(mb_strlen($seo->title) > 50 ? '...' : ''),
                mb_strlen($seo->meta_description ?? '').' chars',
                $seo->noindex ? 'No' : 'Yes',
            ])->toArray()
        );
    }
}
