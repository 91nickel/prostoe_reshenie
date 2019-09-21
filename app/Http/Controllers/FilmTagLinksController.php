<?php

namespace App\Http\Controllers;

use App\FilmTagLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilmTagLinksController extends Controller
{
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
            'film_id' => 'required',
            'tag_id' => 'required',
        ]);
        FilmTagLink::create($request->all());
        return redirect()->route('films.edit',$request->film_id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::table('film_tag_links')
            ->where('id', $request->id)
            ->delete();
        return redirect()->route('films.edit', $request->film_id);
    }
}
