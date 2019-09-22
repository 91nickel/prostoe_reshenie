<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class FilmTagLink extends Model
{
    protected $fillable = [
        'film_id',
        'tag_id',
    ];
    public function getActiveTags($id)
    {
        $arResult['activeTags'] = DB::table('films')
            ->where('films.id', $id)
            ->join('film_tag_links', 'film_tag_links.film_id', '=', 'films.id')
            ->join('tags', 'film_tag_links.tag_id', '=', 'tags.id')
            ->select('film_tag_links.id as link_id', 'tags.name as tag_name', 'tags.id as tag_id')
            ->get();
        return $arResult['activeTags'];
    }

    public function getNoActiveTags($id)
    {
        $arResult['activeTags'] = $this->getActiveTags($id);
        $arResult['allTags'] = Tag::all();
        $arResult['noActiveTags'] = [];
        foreach ($arResult['allTags'] as $tag) {
            $isSearched = false;
            foreach ($arResult['activeTags'] as $activeTag) {
                if ($activeTag->tag_id == $tag->id) {
                    $isSearched = true;
                }
            }
            if(!$isSearched){
                $arResult['noActiveTags'][] = $tag;
            }
        }

        return $arResult['noActiveTags'];
    }
}
