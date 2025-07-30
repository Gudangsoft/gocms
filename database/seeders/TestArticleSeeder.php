<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Site;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class TestArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create test data
        $site = Site::first();
        $category = Category::first();
        $user = User::first();

        if (!$site || !$category || !$user) {
            $this->command->info('Please run the main seeders first (sites, categories, users)');
            return;
        }

        // Create test articles with published status
        $articles = [
            [
                'title' => 'Panduan Lengkap Laravel 12 untuk Pemula',
                'content' => '<p>Laravel 12 adalah framework PHP yang powerful dan mudah digunakan untuk pengembangan aplikasi web modern. Framework ini menyediakan berbagai fitur canggih yang memudahkan developer dalam membangun aplikasi web yang robust dan scalable.</p>

<h2>Fitur Unggulan Laravel 12</h2>
<p>Beberapa fitur unggulan yang ada di Laravel 12 antara lain:</p>
<ul>
<li>Eloquent ORM yang powerful</li>
<li>Blade templating engine</li>
<li>Artisan command line interface</li>
<li>Built-in authentication system</li>
<li>Database migration dan seeding</li>
</ul>

<h2>Instalasi Laravel 12</h2>
<p>Untuk menginstall Laravel 12, Anda dapat menggunakan Composer dengan perintah berikut:</p>
<pre><code>composer create-project laravel/laravel project-name</code></pre>

<p>Setelah instalasi selesai, Anda dapat menjalankan aplikasi dengan perintah php artisan serve.</p>',
                'excerpt' => 'Laravel 12 adalah framework PHP yang powerful dan mudah digunakan untuk pengembangan aplikasi web modern. Pelajari fitur-fitur unggulannya dalam artikel ini.',
                'views_count' => rand(100, 500),
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 30)),
            ],
            [
                'title' => 'Tips Optimasi Database MySQL untuk Performa Maksimal',
                'content' => '<p>Performa database adalah salah satu faktor kunci dalam kesuksesan aplikasi web. MySQL sebagai salah satu database management system yang paling populer memerlukan optimasi yang tepat untuk memberikan performa terbaik.</p>

<h2>Index Database</h2>
<p>Penggunaan index yang tepat dapat meningkatkan performa query secara signifikan. Pastikan untuk membuat index pada kolom yang sering digunakan dalam WHERE clause, JOIN, dan ORDER BY.</p>

<h2>Query Optimization</h2>
<p>Beberapa tips untuk mengoptimasi query MySQL:</p>
<ul>
<li>Gunakan EXPLAIN untuk menganalisis query</li>
<li>Hindari SELECT * jika tidak diperlukan</li>
<li>Gunakan LIMIT untuk membatasi hasil</li>
<li>Optimasi JOIN operation</li>
</ul>

<p>Dengan menerapkan tips-tips ini, performa database MySQL Anda akan meningkat drastis.</p>',
                'excerpt' => 'Pelajari berbagai teknik optimasi database MySQL untuk meningkatkan performa aplikasi web Anda secara signifikan.',
                'views_count' => rand(150, 400),
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 25)),
            ],
            [
                'title' => 'Membangun API RESTful dengan Laravel 12',
                'content' => '<p>API RESTful adalah standar komunikasi antara aplikasi yang paling populer saat ini. Laravel 12 menyediakan tools yang sangat baik untuk membangun API yang robust dan scalable.</p>

<h2>Routing untuk API</h2>
<p>Laravel menyediakan file routes/api.php khusus untuk mendefinisikan route API. Semua route di file ini secara otomatis memiliki prefix /api.</p>

<h2>Resource Controllers</h2>
<p>Gunakan Resource Controllers untuk mengikuti konvensi RESTful:</p>
<ul>
<li>GET /api/posts - Index (list all)</li>
<li>GET /api/posts/{id} - Show (show specific)</li>
<li>POST /api/posts - Store (create new)</li>
<li>PUT /api/posts/{id} - Update</li>
<li>DELETE /api/posts/{id} - Destroy</li>
</ul>

<h2>API Resources</h2>
<p>Laravel API Resources memungkinkan Anda untuk mentransform model dan collection menjadi JSON response yang konsisten.</p>',
                'excerpt' => 'Panduan lengkap membangun API RESTful menggunakan Laravel 12 dengan berbagai fitur canggih dan best practices.',
                'views_count' => rand(200, 600),
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 20)),
            ],
            [
                'title' => 'Keamanan Web: Mencegah Serangan XSS dan CSRF',
                'content' => '<p>Keamanan aplikasi web adalah hal yang sangat penting dan harus diperhatikan sejak awal pengembangan. Dua jenis serangan yang paling umum adalah Cross-Site Scripting (XSS) dan Cross-Site Request Forgery (CSRF).</p>

<h2>Cross-Site Scripting (XSS)</h2>
<p>XSS adalah serangan dimana attacker menyisipkan script berbahaya ke dalam halaman web. Untuk mencegahnya:</p>
<ul>
<li>Selalu validasi dan sanitize user input</li>
<li>Gunakan htmlspecialchars() untuk output</li>
<li>Implementasi Content Security Policy (CSP)</li>
<li>Validasi di sisi server, bukan hanya client</li>
</ul>

<h2>Cross-Site Request Forgery (CSRF)</h2>
<p>CSRF adalah serangan dimana user yang sudah login dipaksa melakukan aksi tanpa sepengetahuannya. Laravel menyediakan CSRF protection secara built-in.</p>

<p>Selalu gunakan @csrf directive dalam form dan verifikasi token di server.</p>',
                'excerpt' => 'Pelajari cara melindungi aplikasi web dari serangan XSS dan CSRF dengan implementasi security best practices.',
                'views_count' => rand(300, 800),
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 15)),
            ],
            [
                'title' => 'Docker untuk Developer: Containerization Made Easy',
                'content' => '<p>Docker telah merevolusi cara developer bekerja dengan aplikasi. Dengan containerization, kita dapat memastikan aplikasi berjalan konsisten di berbagai environment.</p>

<h2>Apa itu Docker?</h2>
<p>Docker adalah platform containerization yang memungkinkan kita untuk package aplikasi beserta dependenciesnya ke dalam container yang lightweight dan portable.</p>

<h2>Keuntungan Menggunakan Docker</h2>
<ul>
<li>Konsistensi environment development dan production</li>
<li>Isolasi aplikasi dan dependencies</li>
<li>Scaling yang mudah</li>
<li>Deployment yang cepat</li>
</ul>

<h2>Docker untuk Laravel</h2>
<p>Membuat Docker container untuk aplikasi Laravel sangat mudah dengan Docker Compose. Anda dapat mendefinisikan services untuk web server, database, dan cache dalam satu file.</p>

<p>Dengan Docker, development environment yang konsisten bukan lagi mimpi!</p>',
                'excerpt' => 'Panduan praktis menggunakan Docker untuk containerization aplikasi web dengan fokus pada Laravel development.',
                'views_count' => rand(250, 700),
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 10)),
            ],
            [
                'title' => 'JavaScript Modern: ES6+ Features yang Wajib Dikuasai',
                'content' => '<p>JavaScript terus berkembang dengan fitur-fitur baru yang membuatnya semakin powerful dan mudah digunakan. ES6 dan versi-versi selanjutnya membawa banyak improvement yang signifikan.</p>

<h2>Arrow Functions</h2>
<p>Arrow functions memberikan syntax yang lebih ringkas untuk menulis function:</p>
<pre><code>// Traditional function
function add(a, b) {
    return a + b;
}

// Arrow function
const add = (a, b) => a + b;</code></pre>

<h2>Destructuring</h2>
<p>Destructuring memungkinkan kita untuk extract values dari array atau object dengan mudah:</p>
<pre><code>const user = { name: "John", age: 30 };
const { name, age } = user;</code></pre>

<h2>Template Literals</h2>
<p>Template literals memudahkan string interpolation dan multi-line strings.</p>

<p>Kuasai fitur-fitur modern ini untuk menjadi JavaScript developer yang lebih produktif!</p>',
                'excerpt' => 'Eksplorasi fitur-fitur JavaScript modern ES6+ yang akan meningkatkan produktivitas dan kualitas code Anda.',
                'views_count' => rand(180, 550),
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 7)),
            ],
            [
                'title' => 'React Hook: Cara Modern Mengelola State dan Side Effects',
                'content' => '<p>React Hooks telah mengubah cara kita membangun komponen React. Dengan hooks, kita dapat menggunakan state dan fitur React lainnya tanpa perlu class components.</p>

<h2>useState Hook</h2>
<p>useState adalah hook yang paling dasar untuk mengelola state dalam functional component:</p>
<pre><code>const [count, setCount] = useState(0);</code></pre>

<h2>useEffect Hook</h2>
<p>useEffect menggantikan lifecycle methods dalam class components:</p>
<pre><code>useEffect(() => {
    document.title = `Count: ${count}`;
}, [count]);</code></pre>

<h2>Custom Hooks</h2>
<p>Anda dapat membuat custom hooks untuk mengencapsulate logic yang dapat digunakan kembali.</p>

<p>Hooks memberikan cara yang lebih clean dan mudah dipahami untuk mengelola state dan side effects dalam React aplikasi.</p>',
                'excerpt' => 'Pelajari React Hooks sebagai cara modern untuk mengelola state dan side effects dalam aplikasi React Anda.',
                'views_count' => rand(220, 650),
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 5)),
            ],
            [
                'title' => 'Vue.js 3 Composition API: Revolutionary Way to Build Components',
                'content' => '<p>Vue.js 3 memperkenalkan Composition API yang memberikan cara baru untuk mengorganisir dan menggunakan kembali logic dalam komponen Vue.</p>

<h2>Setup Function</h2>
<p>Composition API menggunakan setup function sebagai entry point:</p>
<pre><code>export default {
  setup() {
    const count = ref(0);
    const increment = () => count.value++;
    
    return { count, increment };
  }
}</code></pre>

<h2>Reactive References</h2>
<p>ref() dan reactive() digunakan untuk membuat reactive data:</p>
<ul>
<li>ref() untuk primitive values</li>
<li>reactive() untuk objects</li>
</ul>

<h2>Computed Properties</h2>
<p>computed() function untuk membuat computed properties yang reactive.</p>

<p>Composition API memberikan fleksibilitas yang lebih besar dalam mengorganisir kode komponen.</p>',
                'excerpt' => 'Eksplorasi Vue.js 3 Composition API yang revolusioner untuk membangun komponen yang lebih terorganisir dan reusable.',
                'views_count' => rand(190, 480),
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 3)),
            ],
        ];

        foreach ($articles as $articleData) {
            $articleData['site_id'] = $site->id;
            $articleData['category_id'] = $category->id;
            $articleData['user_id'] = $user->id;
            $articleData['slug'] = Str::slug($articleData['title']);
            
            Article::create($articleData);
        }

        $this->command->info('Test articles created successfully!');
    }
}
