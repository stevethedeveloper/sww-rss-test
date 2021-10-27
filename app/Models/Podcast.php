<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Define relation: Podcast has many Episodes
     *
     * @return Episodes
     */
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    /**
     * Store Podcast and child records Episodes, and soft delete any Episodes not present in new feed
     *
     * @return void
     */
    public static function store($url, $data) {
        $podcast = Self::updateOrCreate(                                                    // Update if exists, create if not
            // match on this
            ['feed_url' => $url],
            //update or create using these values
            ['title' => $data->channel->title,
            'artwork_url' => $data->channel->image,
            'description' => $data->channel->description,
            'language' => $data->channel->language,
            'website_url' => $data->channel->link]
        );

        $stored_episode_urls = [];
        foreach ($data->channel->item as $item) {
            $episode_url = (array) $item->enclosure['url'];
            $stored_episode_urls[] = $episode_url[0];
            $episode = $podcast->episodes()->updateOrCreate(                                // Update if exists, create if not
                // match on this
                ['audio_url' => $item->enclosure['url']],
                //update or create using these values
                ['title' => $item->title,
                'description' => $item->description,
                'episode_url' => $item->link]
            );
        }
        $podcast->episodes()->whereNotIn('audio_url', $stored_episode_urls)->delete();      // soft delete episodes not in feed
    }
}
