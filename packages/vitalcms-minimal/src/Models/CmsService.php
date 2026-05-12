<?php

namespace VitalSaaS\VitalCMSMinimal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class CmsService extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        "title",
        "slug", 
        "description",
        "short_description",
        "price",
        "price_description",
        "icon",
        "image",
        "images_gallery",
        "category",
        "featured",
        "is_active",
        "sort_order",
        "meta_data",
    ];

    protected $casts = [
        "featured" => "boolean",
        "is_active" => "boolean",
        "sort_order" => "integer",
        "meta_data" => "array",
        "images_gallery" => "array",
    ];

    public function getTable(): string
    {
        return config("vitalcms.table_prefix", "cms_") . "services";
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom("title")
            ->saveSlugsTo("slug")
            ->doNotGenerateSlugsOnUpdate();
    }

    public function scopeActive($query)
    {
        return $query->where("is_active", true);
    }

    public function scopeFeatured($query)
    {
        return $query->where("featured", true);
    }

    public function scopeCategory($query, string $category)
    {
        return $query->where("category", $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy("sort_order")->orderBy("title");
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }
        return asset("storage/" . config("vitalcms.services.default_image_path", "services") . "/" . $this->image);
    }

    public function getImagesGalleryUrlsAttribute(): array
    {
        if (!$this->images_gallery || !is_array($this->images_gallery)) {
            return [];
        }

        return array_map(function ($image) {
            // Remove double directory prefix if exists
            $imagePath = str_replace("services/", "", $image);
            return asset("storage/" . config("vitalcms.services.default_image_path", "services") . "/" . $imagePath);
        }, $this->images_gallery);
    }

    public function getAllImagesAttribute(): array
    {
        $images = [];
        
        // Add main image if exists
        if ($this->image_url) {
            $images[] = $this->image_url;
        }
        
        // Add gallery images
        return array_merge($images, $this->images_gallery_urls);
    }

    public function getFormattedPriceAttribute(): string
    {
        if (!$this->price) {
            return "Consultar";
        }

        if (str_starts_with($this->price, "Desde")) {
            return $this->price;
        }

        if (is_numeric($this->price)) {
            return "Desde $" . number_format($this->price);
        }

        return $this->price;
    }

    public function getIconDisplayAttribute(): string
    {
        return $this->icon ?? "🌿";
    }

    /**
     * Get all unique categories for filter options.
     */
    public static function getCategories(): array
    {
        return static::whereNotNull("category")
            ->where("category", "!=", "")
            ->distinct()
            ->pluck("category")
            ->mapWithKeys(function ($category) {
                return [$category => ucfirst($category)];
            })
            ->toArray();
    }
}
