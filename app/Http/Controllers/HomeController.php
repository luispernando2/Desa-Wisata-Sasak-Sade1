<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Contact;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\HeroImage;
use App\Models\HomepageContent;
use App\Models\PackageTour;
use App\Models\Product;
use App\Models\Review;
use App\Models\TourGuide;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    private function homepageContentData(): array
    {
        if (! Schema::hasTable('homepage_contents')) {
            return [collect(), collect()];
        }

        $contents = HomepageContent::active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return [
            $contents->keyBy('key'),
            $contents->groupBy('group'),
        ];
    }

    private function heroSlides(): array
    {
        if (Schema::hasTable('hero_images')) {
            $slides = HeroImage::where('is_active', true)
                ->orderBy('sort_order')
                ->orderByDesc('created_at')
                ->get()
                ->map(fn (HeroImage $image) => [
                    'src' => $image->image_src,
                    'title' => $image->title,
                    'subtitle' => $image->subtitle,
                ])
                ->values()
                ->all();

            if ($slides) {
                return $slides;
            }
        }

        return collect(['sade3.png', 'sade2.png', 'sade4.png', 'sade1.png', 'sade5.jpeg', 'sade6.jpeg'])
            ->map(fn (string $image) => [
                'src' => asset('images/' . $image),
                'title' => 'Desa Sasak Sade',
                'subtitle' => null,
            ])
            ->all();
    }

    private function baseData(): array
    {
        [$homepageByKey, $homepageGroups] = $this->homepageContentData();
        $aboutContent = $homepageByKey->get('about.main');
        $aboutHighlights = $homepageGroups->get('about_highlight', collect());
        $contact = Contact::orderBy('created_at', 'desc')->first();
        $authUser = session('auth_user');
        $canWriteReview = false;

        if ($authUser && isset($authUser['id'])) {
            $canWriteReview = Booking::where('user_id', $authUser['id'])
                ->where('status', Booking::STATUS_COMPLETED)
                ->exists();
        }

        return [
            'village' => [
                'name' => data_get($aboutContent?->meta, 'card_title', 'Desa Sasak Sade'),
                'tagline' => $aboutContent?->subtitle ?: 'Budaya, adat, dan rumah tradisional Sasak di Lombok.',
                'description' => $aboutContent?->body ?: 'Desa Wisata Sasak Sade memperlihatkan kehidupan masyarakat Sasak yang kaya adat, rumah tradisional, tenun, dan pertunjukan budaya. Kunjungi desa ini untuk merasakan pengalaman wisata budaya yang otentik dan mendalam.',
                'highlights' => $aboutHighlights->pluck('title')->filter()->values()->all() ?: [
                    'Sejarah desa adat Sasak yang masih terjaga.',
                    'Pertunjukan tari tradisional dan musik Sasak.',
                    'Kerajinan tenun, kain songket, serta produk lokal khas Lombok.',
                    'Galeri foto dan video yang menampilkan suasana desa.',
                ],
            ],
            'events' => Event::with(['tourGuide', 'reviews'])->orderBy('date')->paginate(10),
            'galleries' => Gallery::orderBy('uploaded_at', 'desc')->paginate(10),
            'packages' => PackageTour::orderBy('price')->paginate(10),
            'guides' => TourGuide::orderBy('name')->get(),
            'products' => Product::where('stock', '>', 0)->paginate(10),
            'reviews' => Review::orderBy('created_at', 'desc')->paginate(10),
            'contact' => $contact ? $contact->toArray() : [
                'phone' => '+6287865936972',
                'email' => 'info@sasaksade.id',
                'address' => 'Desa Sasak Sade, Pujut, Lombok Tengah, Nusa Tenggara Barat',
                'whatsapp' => '6287865936972',
                'map_embed' => 'https://www.google.com/maps?q=Desa+Wisata+Sade+Lombok&output=embed',
            ],
            'homepageByKey' => $homepageByKey,
            'homepageGroups' => $homepageGroups,
            'heroSlides' => $this->heroSlides(),
            'authUser' => $authUser,
            'canWriteReview' => $canWriteReview,
        ];
    }

    public function index()
    {
        return view('home', array_merge($this->baseData(), ['active_section' => null]));
    }

    // Multi-page routes from navbar
    public function about()
    {
        return view('home', array_merge($this->baseData(), ['active_section' => 'about']));
    }

    public function packages()
    {
        return view('home', array_merge($this->baseData(), ['active_section' => 'packages']));
    }

    public function events()
    {
        return view('home', array_merge($this->baseData(), ['active_section' => 'events']));
    }

    public function market()
    {
        return view('home', array_merge($this->baseData(), ['active_section' => 'market']));
    }

    public function gallery()
    {
        return view('home', array_merge($this->baseData(), ['active_section' => 'gallery']));
    }

    public function reviews()
    {
        return view('home', array_merge($this->baseData(), ['active_section' => 'reviews']));
    }

    public function booking()
    {
        $selectedPackageId = request()->query('package_id');

        return view('home', array_merge($this->baseData(), [
            'active_section' => 'booking',
            'selectedPackageId' => $selectedPackageId,
        ]));
    }


    public function contact()
    {
        return view('home', array_merge($this->baseData(), ['active_section' => 'contact']));
    }
}
