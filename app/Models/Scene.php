<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class Scene extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'summary', 'order', 'content'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getImageAttribute()
    {
        $files = Storage::files("public/projects/{$this->project->id}/scenes/{$this->id}/draft/");
        if (count($files) > 0) {
            return Storage::url($files[0]);
        }
        return $this->createDefaultThumbnail();
    }

    public function createDefaultThumbnail()
    {
        $hue = rand(0, 360);
        $saturation = rand(0, 100);
        $lightness = rand(0, 100);
        $backgroundColor = "hsl($hue, $saturation%, $lightness%)";
        $image = (new ImageManager(Driver::class))->create(300, 300);
        $image->fill($backgroundColor);
        $sceneAbbreviation = collect(explode(" ", $this->name))->map(fn ($word) => $word[0])->join("");
        $image->text($sceneAbbreviation, 150, 150, function ($font) {
            $font->file(public_path("fonts/Montserrat/Montserrat-Bold.ttf"));
            $font->size(60);
            $font->color("#ffffff");
            $font->align("center");
            $font->valign("middle");
        });
        //Create directory if it doesn't exist
        Storage::makeDirectory("public/projects/{$this->project->id}/scenes/{$this->id}/draft/");
        $imagePath = storage_path("app/public/projects/{$this->project->id}/scenes/{$this->id}/draft/thumbnail.png");
        $image->toPng()->save($imagePath);
        return $imagePath;
    }

    public function getTextContent(): string
    {
        return strip_tags($this->content);
    }
}
