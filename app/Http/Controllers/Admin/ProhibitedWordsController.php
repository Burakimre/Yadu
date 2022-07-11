<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\CreateProhibitedWordRequest;
use App\Http\Requests\DestroyProhibitedWordRequest;
use App\Http\Requests\UpdateProhibitedWordRequest;
use App\ProhibitedWord;
use App\Http\Controllers\ProhibitedWordController;
use Validator;
use Auth;

class ProhibitedWordsController extends Controller
{
    public function index()
    {
        $prohibitedWords = ProhibitedWord::orderBy('word', 'asc')->get();
        return view('admin.swearWords.index', compact(['prohibitedWords']));
    }

    public function destroy(DestroyProhibitedWordRequest $request)
    {
        ProhibitedWord::where('word', $request['prohibitedWordToDelete'])->delete();
        return redirect('admin/prohibitedWords');
    }

    public function update(UpdateProhibitedWordRequest $request)
    {
        $oldWord = $request['originalProhibitedWord'];
        $newWord = $request['updatedProhibitedWord'];

        ProhibitedWord::where('word', $oldWord)->update(['word' => $newWord]);
        return redirect('admin/prohibitedWords');
    }

    public function create(CreateProhibitedWordRequest $request)
    {
        $prohibitedWord = new prohibitedWord();
        $prohibitedWord->word = $request['newProhibitedWord'];
        $prohibitedWord->save();

        return redirect('admin/prohibitedWords');
    }
}
