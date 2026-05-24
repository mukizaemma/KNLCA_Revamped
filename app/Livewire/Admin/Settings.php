<?php

namespace App\Livewire\Admin;

use App\Models\PageHeader;
use App\Models\WebsiteSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class Settings extends Component
{
    use WithFileUploads;

    #[Url(as: 'tab', keep: true)]
    public string $activeTab = 'account';

    // Account tab
    public string $account_name = '';
    public string $account_email = '';
    public ?string $account_phone = null;
    public ?string $account_biography = null;
    public ?string $account_password = null;
    public ?string $account_password_confirmation = null;

    // Contacts tab (website_settings)
    public ?string $email = null;
    public ?string $phone_reception = null;
    public ?string $phone_urgency = null;
    public ?string $phone_whatsapp = null;
    public ?string $phone_billing = null;
    public ?string $phone_restaurant = null;
    public ?string $address = null;
    public ?string $map_embed_url = null;

    // School info tab (website_settings)
    public ?string $company_name = null;
    public ?string $home_background_text = null;
    public ?string $about_description = null;
    public ?string $about_heading = null;
    public ?string $about_values_subheading = null;
    public array $about_value_cards = [];
    public array $affiliate_schools = [];
    public ?string $mission = null;
    public ?string $vision = null;
    public ?string $core_values = null;
    public ?string $registration_academic_year = null;
    public ?string $registration_message = null;
    public ?string $site_font_family = null;
    public ?string $site_font_css_url = null;
    public ?string $facebook_url = null;
    public ?string $instagram_url = null;
    public ?string $linkedin_url = null;
    public ?string $youtube_url = null;
    public ?string $x_url = null;
    public ?string $threads_url = null;
    public ?string $logo_path = null;
    public ?string $home_background_image_path = null;
    public ?string $cta_background_image_path = null;
    public ?string $cta_title = null;
    public ?string $cta_description = null;
    public ?string $gallery_external_url = null;

    /**
     * Temporary uploaded files for logo, home background, and CTA background.
     */
    public $logo;
    public $home_background_image;
    public $cta_background_image;

    /**
     * Temporary uploaded header images indexed by headers array key.
     *
     * @var array<int, mixed>
     */
    public array $headerImages = [];

    /**
     * When true for an index, clear that header's image on save.
     *
     * @var array<int, bool>
     */
    public array $headerRemoveImage = [];

    // Page headers tab
    /**
     * @var array<int, array<string, mixed>>
     */
    public array $headers = [];

    /** Page headers for menu pages only (match top nav: About, Academics, Admissions, …) */
    protected array $headerPages = [
        ['key' => 'about', 'label' => 'About · Overview'],
        ['key' => 'about_mission', 'label' => 'About · Mission & Vision'],
        ['key' => 'about_values', 'label' => 'About · Core Values'],
        ['key' => 'about_staff', 'label' => 'About · Staff'],
        ['key' => 'about_history', 'label' => 'About · History'],
        ['key' => 'about_schools', 'label' => 'About · Our Schools'],
        ['key' => 'about_inquire', 'label' => 'About · Contact'],
        ['key' => 'departments', 'label' => 'Academics'],
        ['key' => 'admissions', 'label' => 'Admissions'],
        ['key' => 'register', 'label' => 'Register / Enrollment'],
        ['key' => 'visit_school', 'label' => 'Visit School'],
        ['key' => 'facilities', 'label' => 'Facilities'],
        ['key' => 'leadership', 'label' => 'Staff'],
        ['key' => 'school_activities', 'label' => 'School Activities'],
        ['key' => 'careers', 'label' => 'Careers'],
        ['key' => 'gallery', 'label' => 'Gallery'],
        ['key' => 'contact', 'label' => 'Contacts'],
        ['key' => 'feedback', 'label' => 'Feedback'],
    ];

    public function mount()
    {
        // Validate tab parameter
        $validTabs = ['account', 'contacts', 'info', 'headers'];
        if (!in_array($this->activeTab, $validTabs)) {
            $this->activeTab = 'account';
        }

        $this->loadAccount();
        $this->loadWebsiteSettings();
        $this->loadHeaders();
    }

    public function setTab(string $tab): void
    {
        $validTabs = ['account', 'contacts', 'info', 'headers'];
        if (in_array($tab, $validTabs)) {
            $this->activeTab = $tab;
        }
    }

    protected function loadAccount(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $this->account_name = $user->name;
        $this->account_email = $user->email;
        $this->account_phone = $user->phone ?? '';
        $this->account_biography = $user->biography ?? '';
    }

    protected function loadWebsiteSettings(): void
    {
        $settings = WebsiteSetting::first();

        if (!$settings) {
            $settings = WebsiteSetting::create([]);
        }

        // Contacts
        $this->email = $settings->email;
        $this->phone_reception = $settings->phone_reception;
        $this->phone_urgency = $settings->phone_urgency;
        $this->phone_whatsapp = $settings->phone_whatsapp;
        $this->phone_billing = $settings->phone_billing;
        $this->phone_restaurant = $settings->phone_restaurant;
        $this->address = $settings->address;
        $this->map_embed_url = $settings->map_embed_url;

        // School info
        $this->company_name = $settings->company_name;
        $this->home_background_text = $settings->home_background_text;
        $this->about_description = $settings->about_description;
        $this->about_heading = $settings->about_heading ?? 'Shaping Futures Through Quality Education';
        $this->about_values_subheading = $settings->about_values_subheading ?? 'A School With a Sincere Heart';
        $decoded = $settings->about_value_cards ? (is_string($settings->about_value_cards) ? json_decode($settings->about_value_cards, true) : $settings->about_value_cards) : [];
        $this->about_value_cards = is_array($decoded) ? $decoded : [];
        if (empty($this->about_value_cards)) {
            $this->about_value_cards = [
                ['name' => 'Integrity', 'description' => 'We are committed to honesty and strong moral principles in every aspect of school life.'],
                ['name' => 'Learning', 'description' => 'We foster a culture of continuous learning for both students and staff.'],
                ['name' => 'Community', 'description' => 'Families, staff, and students work together to build a caring school community.'],
                ['name' => 'Excellence', 'description' => 'We encourage every learner to reach their full potential in academics and character.'],
            ];
        }
        $affDecoded = $settings->affiliate_schools ? (is_string($settings->affiliate_schools) ? json_decode($settings->affiliate_schools, true) : $settings->affiliate_schools) : [];
        $this->affiliate_schools = is_array($affDecoded) ? $affDecoded : [];

        $this->mission = $settings->mission;
        $this->vision = $settings->vision;
        $this->core_values = $settings->core_values;
        $this->site_font_family = $settings->site_font_family;
        $this->site_font_css_url = $settings->site_font_css_url;
        $this->registration_academic_year = $settings->registration_academic_year;
        $this->registration_message = $settings->registration_message;
        $this->facebook_url = $settings->facebook_url;
        $this->instagram_url = $settings->instagram_url;
        $this->linkedin_url = $settings->linkedin_url;
        $this->youtube_url = $settings->youtube_url;
        $this->x_url = $settings->x_url;
        $this->threads_url = $settings->threads_url;
        $this->logo_path = $settings->logo_path;
        $this->home_background_image_path = $settings->home_background_image_path;
        $this->cta_background_image_path = $settings->cta_background_image_path;
        $this->cta_title = $settings->cta_title;
        $this->cta_description = $settings->cta_description;
        $this->gallery_external_url = $settings->gallery_external_url;
    }

    protected function loadHeaders(): void
    {
        $this->headers = [];
        $this->headerImages = [];
        $this->headerRemoveImage = [];

        foreach ($this->headerPages as $page) {
            $model = PageHeader::firstOrCreate(
                ['page_key' => $page['key']],
                [
                    'title' => $page['label'],
                    'caption' => null,
                    'image_path' => null,
                ]
            );

            $this->headers[] = [
                'id' => $model->id,
                'page_key' => $model->page_key,
                'label' => $page['label'],
                'title' => $model->title,
                'caption' => $model->caption,
                'image_path' => $model->image_path,
            ];
        }
    }

    public function saveAccount(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $this->validate([
            'account_name' => ['required', 'string', 'max:255'],
            'account_email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'account_phone' => ['nullable', 'string', 'max:50'],
            'account_biography' => ['nullable', 'string'],
            'account_password' => ['nullable', 'string', 'min:8', 'same:account_password_confirmation'],
        ]);

        $user->name = $validated['account_name'];
        $user->email = $validated['account_email'];
        $user->phone = $validated['account_phone'] ?? null;
        $user->biography = $validated['account_biography'] ?? null;

        if (!empty($validated['account_password'])) {
            $user->password = Hash::make($validated['account_password']);
        }

        $user->save();

        session()->flash('success', 'Account details updated successfully.');
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Account updated',
            'text' => 'Your admin account details have been saved.',
        ]);
    }

    public function saveContacts(): void
    {
        $validated = $this->validate([
            'email' => ['nullable', 'email', 'max:255'],
            'phone_reception' => ['nullable', 'string', 'max:50'],
            'phone_urgency' => ['nullable', 'string', 'max:50'],
            'phone_whatsapp' => ['nullable', 'string', 'max:50'],
            'phone_billing' => ['nullable', 'string', 'max:50'],
            'phone_restaurant' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'map_embed_url' => ['nullable', 'string'],
        ]);

        $settings = WebsiteSetting::first() ?? WebsiteSetting::create([]);
        $settings->update($validated);

        session()->flash('success', 'Contact details updated successfully.');
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Contacts updated',
            'text' => 'School contact details have been saved.',
        ]);
    }

    public function saveInfo(): void
    {
        $validated = $this->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
            'home_background_text' => ['nullable', 'string'],
            'about_description' => ['nullable', 'string'],
            'about_heading' => ['nullable', 'string', 'max:255'],
            'about_values_subheading' => ['nullable', 'string', 'max:255'],
            'about_value_cards' => ['nullable', 'array'],
            'about_value_cards.*.name' => ['nullable', 'string', 'max:100'],
            'about_value_cards.*.description' => ['nullable', 'string'],
            'affiliate_schools' => ['nullable', 'array'],
            'affiliate_schools.*.name' => ['nullable', 'string', 'max:150'],
            'affiliate_schools.*.location' => ['nullable', 'string', 'max:150'],
            'affiliate_schools.*.description' => ['nullable', 'string'],
            'affiliate_schools.*.url' => ['nullable', 'url', 'max:500'],
            'mission' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'core_values' => ['nullable', 'string'],
            'registration_academic_year' => ['nullable', 'string', 'max:60'],
            'registration_message' => ['nullable', 'string'],
            'site_font_family' => ['nullable', 'string', 'max:255'],
            'site_font_css_url' => ['nullable', 'string', 'max:500'],
            'facebook_url' => ['nullable', 'url'],
            'instagram_url' => ['nullable', 'url'],
            'linkedin_url' => ['nullable', 'url'],
            'youtube_url' => ['nullable', 'url'],
            'x_url' => ['nullable', 'url'],
            'threads_url' => ['nullable', 'url'],
            'logo' => ['nullable', 'image', 'max:2048'], // max 2MB
            'home_background_image' => ['nullable', 'image', 'max:4096'], // max 4MB
            'cta_background_image' => ['nullable', 'image', 'max:4096'], // max 4MB
            'cta_title' => ['nullable', 'string', 'max:255'],
            'cta_description' => ['nullable', 'string'],
            'gallery_external_url' => ['nullable', 'string', 'max:500'],
        ]);

        $settings = WebsiteSetting::first() ?? WebsiteSetting::create([]);

        // Fill simple text fields
        $settings->fill([
            'company_name' => $this->company_name,
            'home_background_text' => $this->home_background_text,
            'about_description' => $this->about_description,
            'about_heading' => $this->about_heading,
            'about_values_subheading' => $this->about_values_subheading,
            'about_value_cards' => !empty($this->about_value_cards) ? json_encode(array_values(array_filter($this->about_value_cards, fn($c) => !empty($c['name']) || !empty($c['description'])))) : null,
            'affiliate_schools' => !empty($this->affiliate_schools) ? array_values(array_filter($this->affiliate_schools, fn($s) => !empty($s['name']))) : null,
            'mission' => $this->mission,
            'vision' => $this->vision,
            'core_values' => $this->core_values,
            'registration_academic_year' => $this->registration_academic_year,
            'registration_message' => $this->registration_message,
            'site_font_family' => $this->site_font_family,
            'site_font_css_url' => $this->site_font_css_url,
            'facebook_url' => $this->facebook_url,
            'instagram_url' => $this->instagram_url,
            'linkedin_url' => $this->linkedin_url,
            'youtube_url' => $this->youtube_url,
            'x_url' => $this->x_url,
            'threads_url' => $this->threads_url,
            'gallery_external_url' => $this->gallery_external_url,
        ]);

        // Handle logo upload (if a new file was selected)
        if ($this->logo) {
            $path = $this->logo->store('logos', 'public');
            // Store path in a way that works with asset()
            $settings->logo_path = 'storage/' . $path;
            $this->logo_path = $settings->logo_path;
        }

        // Handle home background image upload (if a new file was selected)
        if ($this->home_background_image) {
            $bgPath = $this->home_background_image->store('hero', 'public');
            $settings->home_background_image_path = 'storage/' . $bgPath;
            $this->home_background_image_path = $settings->home_background_image_path;
        }

        // CTA section
        $settings->cta_title = $this->cta_title;
        $settings->cta_description = $this->cta_description;
        if ($this->cta_background_image) {
            $ctaPath = $this->cta_background_image->store('cta', 'public');
            $settings->cta_background_image_path = 'storage/' . $ctaPath;
            $this->cta_background_image_path = $settings->cta_background_image_path;
        }

        $settings->save();

        // Clear temporary uploads so the file inputs reset
        $this->logo = null;
        $this->home_background_image = null;
        $this->cta_background_image = null;

        session()->flash('success', 'School information updated successfully.');
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'School info updated',
            'text' => 'Public school information has been saved.',
        ]);
    }

    public function saveHeaders(): void
    {
        $this->validate([
            'headers.*.title' => ['nullable', 'string'],
            'headers.*.caption' => ['nullable', 'string'],
            'headerImages.*' => ['nullable', 'image', 'max:4096'],
        ]);

        foreach ($this->headers as $index => $header) {
            if (empty($header['id'])) {
                continue;
            }

            $model = PageHeader::find($header['id']);
            if (!$model) {
                continue;
            }

            $model->title = $header['title'] ?? null;
            $model->caption = $header['caption'] ?? null;

            // Remove image if requested
            if (!empty($this->headerRemoveImage[$index])) {
                $model->image_path = null;
                $this->headers[$index]['image_path'] = null;
            } elseif (isset($this->headerImages[$index]) && $this->headerImages[$index]) {
                // New image uploaded: store and set path
                $path = $this->headerImages[$index]->store('headers', 'public');
                $model->image_path = 'storage/' . $path;
                $this->headers[$index]['image_path'] = $model->image_path;
            } else {
                $model->image_path = $header['image_path'] ?? $model->image_path;
            }

            $model->save();
        }

        $this->headerImages = [];
        $this->headerRemoveImage = [];

        session()->flash('success', 'Page headers updated successfully.');
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Headers updated',
            'text' => 'Page headers have been saved.',
        ]);
    }

    public function addAboutValueCard(): void
    {
        $this->about_value_cards[] = ['name' => '', 'description' => ''];
    }

    public function removeAboutValueCard(int $index): void
    {
        $cards = $this->about_value_cards;
        array_splice($cards, $index, 1);
        $this->about_value_cards = array_values($cards);
    }

    public function addAffiliateSchool(): void
    {
        $this->affiliate_schools[] = ['name' => '', 'location' => '', 'description' => '', 'url' => ''];
    }

    public function removeAffiliateSchool(int $index): void
    {
        $schools = $this->affiliate_schools;
        array_splice($schools, $index, 1);
        $this->affiliate_schools = array_values($schools);
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
