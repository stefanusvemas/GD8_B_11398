<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    /**
     * index
     *
     * @return void
     */

    public function index()
    {
        $movie = Movie::latest()->paginate(5);
        return view('movie.index', compact('movie'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('movie.create');
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'director' => 'required',
            'duration' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('public/images'), $imageName);
            $imagePath = 'public/images/' . $imageName;


            Movie::create([
                'title' => $request->title,
                'director' => $request->director,
                'duration' => $request->duration,
                'image' => $imagePath,
            ]);
        }
        try {
            return redirect()->route('movie.index');
        } catch (Exception $e) {
            return redirect()->route('movie.index');
        }
    }

    /**
     * edit
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        $movie = Movie::find($id);
        return view('movie.edit', compact('movie'));
    }
    /**
     * update
     *
     * @param mixed $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $movie = Movie::find($id);
        //validate form
        $this->validate($request, [
            'title' => 'required',
            'director' => 'required',
            'duration' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg'
        ]);

        if ($request->hasFile('image')) {
            // Store the new image and update the movie's image path
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('public/images'), $imageName);
            $imagePath = 'public/images/' . $imageName;


            $movie->update([
                'title' => $request->title,
                'director' => $request->director,
                'duration' => $request->duration,
                'image' => $imagePath,
            ]);
        } else {
            $movie->update([
                'title' => $request->title,
                'director' => $request->director,
                'duration' => $request->duration,
            ]);
        }


        return redirect()->route('movie.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * destroy
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);
        $movie->delete();
        return redirect()->route('movie.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
