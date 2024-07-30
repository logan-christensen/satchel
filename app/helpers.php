<?php

use Illuminate\Support\Facades\File;

if (!function_exists('get_prompt')) {
    function get_prompt(string $promptName, array $data): string
    {
        $prompt = File::get(resource_path("prompts/$promptName.txt"));
        foreach ($data as $key => $value) {
            $prompt = str_replace("{{{$key}}}", $value, $prompt);
        }
        return $prompt;
    }
}
