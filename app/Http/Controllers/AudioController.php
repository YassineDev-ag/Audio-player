<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
    // Display audio files
    public function index()
    {
        $audios = Audio::all();
        return view('audios.index', compact('audios'));
    }

    // Upload and store audio file
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'audio' => 'required|mimes:mp3,m4a,wav,ogg,aac,flac,webm|max:10240',
        ]);

        $file = $request->file('audio');

        // Save file in storage/app/public/audios
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('storage/audios'), $filename);

        // Record file data in database
        Audio::create([
            'title' => $request->title,
            'filename' => $filename,
        ]);

        return redirect()->back()->with('success', 'Audio file uploaded successfully!');
    }

    // Delete audio file
    public function destroy($id)
    {
        $audio = Audio::findOrFail($id);

        // Delete file from storage
        Storage::delete('public/audios/' . $audio->filename);

        // Delete record from database
        $audio->delete();

        return redirect()->back()->with('success', 'Audio file deleted successfully!');
    }
}
