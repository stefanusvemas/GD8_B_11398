<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Ticket;
use App\Models\Movie;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get ticket
        $ticket = Ticket::latest()->paginate(5);
        //render view with posts
        return view('ticket.index', compact('ticket'));
    }

    public function create()
    {
        $movie = Movie::all();
        return view('ticket.create', compact('movie'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_movie' => 'required',
            'class' => 'required',
            'price' => 'required',
        ]);

        Ticket::create([
            'id_movie' => $request->id_movie,
            'class' => $request->class,
            'price' => $request->price,
        ]);
        try {
            return redirect()->route('ticket.index');
        } catch (Exception $e) {
            return redirect()->route('ticket.index');
        }
    }

    public function edit($id)
    {
        $movie = Movie::all();
        $ticket = Ticket::find($id);
        return view('ticket.edit', compact('ticket', 'movie'));
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        $this->validate($request, [
            'id_movie' => 'required',
            'class' => 'required',
            'price' => 'required',
        ]);

        $ticket->update([
            'id_movie' => $request->id_movie,
            'class' => $request->class,
            'price' => $request->price,
        ]);

        return redirect()->route('ticket.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();
        return redirect()->route('ticket.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
