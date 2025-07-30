<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use App\Models\Site;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default user first
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gocms.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $sites = Site::all();

        foreach ($sites as $site) {
            $categories = Category::where('site_id', $site->id)->get();

            foreach ($categories as $category) {
                // Create 2-3 articles per category
                for ($i = 1; $i <= 3; $i++) {
                    $articles = $this->getArticlesBySiteAndCategory($site->name, $category->name, $i);
                    
                    foreach ($articles as $articleData) {
                        Article::create([
                            'site_id' => $site->id,
                            'category_id' => $category->id,
                            'user_id' => $user->id,
                            'title' => $articleData['title'],
                            'slug' => \Str::slug($articleData['title']),
                            'excerpt' => $articleData['excerpt'],
                            'content' => $articleData['content'],
                            'featured_image' => $articleData['featured_image'] ?? null,
                            'meta_title' => $articleData['title'],
                            'meta_description' => $articleData['excerpt'],
                            'status' => $articleData['status'] ?? 'published',
                            'is_featured' => $articleData['is_featured'] ?? false,
                            'published_at' => now()->subDays(rand(1, 30)),
                        ]);
                    }
                }
            }
        }
    }

    private function getArticlesBySiteAndCategory($siteName, $categoryName, $index)
    {
        $articles = [];

        if ($siteName === 'Corporate Website') {
            if ($categoryName === 'Services') {
                $articles[] = [
                    'title' => "Professional Web Development Services #{$index}",
                    'excerpt' => 'We provide comprehensive web development solutions for businesses of all sizes.',
                    'content' => '<p>Our team of experienced developers specializes in creating modern, responsive websites that drive business growth. We use the latest technologies and best practices to ensure your website performs optimally across all devices.</p><p>Our services include custom web development, e-commerce solutions, content management systems, and ongoing maintenance and support.</p>',
                    'is_featured' => $index === 1,
                    'status' => 'published'
                ];
            } elseif ($categoryName === 'About Us') {
                $articles[] = [
                    'title' => "Our Company History #{$index}",
                    'excerpt' => 'Learn about our journey from a small startup to a leading technology company.',
                    'content' => '<p>Founded in 2015, our company has grown from a small team of passionate developers to a full-service technology consultancy. We have helped hundreds of businesses transform their digital presence and achieve their goals.</p><p>Our mission is to provide innovative solutions that drive business success while maintaining the highest standards of quality and customer service.</p>',
                    'status' => 'published'
                ];
            } else { // News
                $articles[] = [
                    'title' => "Company Announcement #{$index}",
                    'excerpt' => 'Important updates and news from our company.',
                    'content' => '<p>We are excited to announce our latest developments and achievements. This quarter has been particularly successful with several new client partnerships and product launches.</p><p>Stay tuned for more exciting news and updates from our team.</p>',
                    'status' => $index > 2 ? 'draft' : 'published'
                ];
            }
        } elseif ($siteName === 'Tech Blog') {
            if ($categoryName === 'Technology') {
                $articles[] = [
                    'title' => "The Future of Technology #{$index}",
                    'excerpt' => 'Exploring emerging technologies that will shape our future.',
                    'content' => '<p>Technology continues to evolve at an unprecedented pace. From artificial intelligence to quantum computing, we are witnessing revolutionary changes that will transform how we live and work.</p><p>In this article, we explore the key technological trends that will define the next decade and their potential impact on various industries.</p>',
                    'is_featured' => $index === 1,
                    'status' => 'published'
                ];
            } elseif ($categoryName === 'Programming') {
                $articles[] = [
                    'title' => "Modern Programming Best Practices #{$index}",
                    'excerpt' => 'Essential programming practices every developer should know.',
                    'content' => '<p>Writing clean, maintainable code is crucial for successful software development. In this comprehensive guide, we cover the fundamental principles and best practices that every programmer should follow.</p><p>Topics include code organization, testing strategies, version control, and collaboration techniques.</p>',
                    'status' => 'published'
                ];
            } elseif ($categoryName === 'AI & Machine Learning') {
                $articles[] = [
                    'title' => "Machine Learning in Practice #{$index}",
                    'excerpt' => 'Real-world applications of machine learning technologies.',
                    'content' => '<p>Machine learning is transforming industries from healthcare to finance. In this article, we examine practical applications of ML algorithms and their impact on business operations.</p><p>We also discuss implementation strategies and common challenges faced when deploying ML solutions in production environments.</p>',
                    'status' => 'published'
                ];
            } else { // Web Development
                $articles[] = [
                    'title' => "Web Development Trends #{$index}",
                    'excerpt' => 'Latest trends and technologies in web development.',
                    'content' => '<p>The web development landscape is constantly evolving with new frameworks, tools, and methodologies. This article explores the current trends that are shaping modern web development.</p><p>From progressive web apps to serverless architecture, discover the technologies that are driving innovation in web development.</p>',
                    'status' => 'published'
                ];
            }
        } else { // E-Commerce Store
            $articles[] = [
                'title' => "Product Spotlight: {$categoryName} #{$index}",
                'excerpt' => "Discover our latest {$categoryName} products and special offers.",
                'content' => "<p>We are excited to showcase our latest {$categoryName} collection featuring high-quality products at competitive prices.</p><p>Our carefully curated selection ensures that you get the best value for your money while enjoying exceptional quality and service.</p>",
                'status' => 'published'
            ];
        }

        return $articles;
    }
}
