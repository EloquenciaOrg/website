<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametre;
use App\Models\Blog;
use Illuminate\Support\Facades\Log;

class ParametreController extends Controller
{
    public function index()
    {
        $settings = Parametre::where('name', 'notifications')->get();
        $partenaires = Parametre::where('name', 'like','partenaire%')->where('state', 1)->get();
        $articles = Blog::where('featured', 1)->get();
        $blogs = Blog::where('featured', 0)->get();

        return view('admin.parametre', compact('settings','partenaires','articles','blogs'));
    }

    public function index_welcome()
    {
        $data = Parametre::where('name', 'notifications')->where('state', 1)->first();
        $partenaires = Parametre::where('name', 'like','partenaire%')->where('state', 1)->get();
        $articles = Blog::where('featured', 1)->get();
        if ($data)
        {
            $setting = json_decode($data->value);
            return view('welcome', compact('setting','partenaires','articles'));
        }
        else
        {
            $setting = null;
            return view('welcome', compact('setting','partenaires','articles'));
        }

    }

    public function desactiver(Request $request)
    {
        $id = $request->id;
        $notif = Parametre::find($id);
        $notif->state = 0;
        $notif->save();
        return back()->with('success', 'Notification désactivé');
    }

    public function activer(Request $request)
    {
        $id = $request->id;
        $notif = Parametre::find($id);
        $notif->state = 1;
        $notif->save();
        return back()->with('success', 'Notification activé');
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $notif = Parametre::find($id);
        $notif->value = json_encode([
            'content' => $request->value
        ]);

        $notif->save();
        return back()->with('success', 'Notification mis a jour');
    }

    public function partenaire_add(Request $request)
    {
        // Validation de base
        $request->validate([
            'nom' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'since' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $last = Parametre::where('name', 'like', 'partenaire_%')
            ->orderByRaw('CAST(SUBSTRING(name, 12) AS UNSIGNED) DESC')
            ->first();

        // Détermine le prochain numéro
        $nextId = 1;
        if ($last) {
            $parts = explode('_', $last->name);
            $lastNum = intval(end($parts));
            $nextId = $lastNum + 1;
        }

        // Nouveau nom basé sur l’ID suivant
        $name = 'partenaire_' . $nextId;
        $image = 'images/' . $request->image;


        Log::info('Nom du partenaire généré : ' . $name);

        $partner = new Parametre();
        $partner->name = $name;
        $partner->state = 1;
        $partner->value = json_encode([
            'nom' => $request->nom,
            'image' => $image,
            'description' => $request->description,
            'depuis' => $request->since,
            'link' => $request->link
        ]);

        $partner->save();

        return back()->with('success', 'Partenaire ajouté avec succès.');
    }

    public function partenaire_delete(Request $request)
    {
        $id = $request->name;
        $article = Parametre::find($id);

        $article->delete();
        return back()->with('success', 'c supprimé');
    }


}
