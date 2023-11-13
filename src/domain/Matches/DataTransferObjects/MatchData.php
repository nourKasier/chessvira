<?php

namespace Domain\Matches\DataTransferObjects;

use Illuminate\Http\UploadedFile;

use Spatie\LaravelData\Data;

class MatchData extends Data
{
    public function __construct(
        public ?int $id,
        public ?int $user_id,
        public string $title,
        public string $content,
        public UploadedFile $picture,
    ) {
    }

    public static function make($matchData)
    {
        $user_id = $matchData->user()->id;
        $matchData = $matchData->validated();
        $matchData['user_id'] = $user_id;
        // $matchData['picture'] = uniqueNameAndMove($matchData['picture'], 'my_posts/images');
        return $matchData;
    }

    public static function update($matchData)
    {
        $matchData = $matchData->validated();
        if (array_key_exists("picture", $matchData)) {
            // $matchData['picture'] = uniqueNameAndMove($matchData['picture'], 'my_posts/images');
        }
        return $matchData;
    }
}
