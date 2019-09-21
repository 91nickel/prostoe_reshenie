<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Film;
use App\FilmTagLink;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;

class FilmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params['tags'] = DB::table('tags')->select('id', 'name')->orderBy('name')->get();
        $params['films'] = [];
        $params['filmsTags'] = [];
        $int = 0;
        foreach ($params['tags'] as $key => $tag) {
            $params['films'][$key]['tag'] = $tag->name;
            $params['films'][$key]['tag_id'] = $tag->id;
            $params['films'][$key]['children'] = DB::table('film_tag_links')
                ->where('tag_id', $tag->id)
                ->join('films', 'film_tag_links.film_id', '=', 'films.id')
                ->orderBy('films.name')
                ->get();
            $int = $key;
        }
        $int++;
        $params['films'][$int]['tag'] = 'Без тега';
        $params['films'][$int]['children'] = DB::table('films')
            ->whereNull('film_tag_links.film_id')
            ->leftJoin('film_tag_links', 'films.id', '=', 'film_tag_links.film_id')
            ->select('films.name', 'films.id', 'films.year')
            ->get();
        //dd($params['films'][$int]['children']);

        $films = Film::all();
        foreach ($films as $item) {
            $params['filmsTags'][$item->id]['id'] = $item->id;
            $params['filmsTags'][$item->id]['name'] = $item->name;
            $params['filmsTags'][$item->id]['tags'] = DB::table('film_tag_links')
                ->where('film_tag_links.film_id', $item->id)
                ->join('tags', 'tags.id', '=', 'film_tag_links.tag_id')
                ->select('tags.name')
                ->get();
        }

        return view('sections.films', $params);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'year' => 'required',
        ]);
        Film::create($request->all());
        return redirect()->route('films.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FilmTagLink $link
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FilmTagLink $link, $id)
    {
        $arResult['film'] = Film::where('id', $id)->first();
        $arResult['activeTags'] = $link->getActiveTags($id);
        $arResult['noActiveTags'] = $link->getNoActiveTags($id);
        return view('sections.filmEdit', $arResult);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Film $film
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Film $film)
    {
        $this->validate($request, [
            'name' => 'required',
            'year' => 'required',
        ]);
        $film->update($request->all());
        return redirect()->route('films.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Film $film
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Film $film)
    {
        $film->delete();

        DB::table('film_tag_links')
            ->where('film_id', $film->id)
            ->delete();

        return redirect()->route('films.index');
    }
}
