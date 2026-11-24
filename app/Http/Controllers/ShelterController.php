<?php

namespace App\Http\Controllers;

use App\Models\AdoptionRequest;
use App\Models\CareRecord;
use App\Models\Cat;
use App\Models\Dog;
use App\Models\Donation;
use App\Models\Need;
use App\Models\VolunteerApplication;
use App\Services\ShelterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ShelterController extends Controller
{
    public function home(Request $r)
    {
        $dogs = Dog::where('is_published', true)->when($r->filled('size'), fn ($q) => $q->where('size', $r->string('size')))->latest()->paginate(9);
        $cats = Cat::where('is_published', true)->latest()->get();
        $dogPhotos = ['Luna' => 'images/dogs/luna.jpg', 'Bruno' => 'images/dogs/bruno.jpg', 'Mila' => 'images/dogs/mila.jpg', 'Bella' => 'images/dogs/bella.jpg', 'Roky' => 'images/dogs/roky.jpg', 'Rambo' => 'images/dogs/rambo.jpg', 'Hércules' => 'images/dogs/hercules.jpg'];
        $needs = Need::where('status', 'activa')->latest()->get();
        $lostAnimals = [
            ['name' => 'Max', 'status' => 'Perdido', 'detail' => 'Husky siberiano, 2 años. Se busca en José Luis Bustamante y Rivero.', 'image' => 'images/community/max-perdido.jpg'],
            ['name' => 'Pedrito', 'status' => 'Perdido', 'detail' => 'Llevaba pechera naranja. Si lo ves, reténlo y avisa a su familia.', 'image' => 'images/community/pedrito-perdido.jpg'],
            ['name' => 'Sola', 'status' => 'Encontrada', 'detail' => 'Perrita encontrada en la zona de Cerro Colorado. Ayúdanos a ubicar a su familia.', 'image' => 'images/community/sola-encontrada.jpg'],
            ['name' => 'Lizzie', 'status' => 'Perdida', 'detail' => 'Pequeña a mediana, esterilizada y dócil. Se perdió por Paucarpata.', 'image' => 'images/community/lizzie-perdida.jpg'],
            ['name' => 'Drago', 'status' => 'Perdido', 'detail' => 'Braco alemán negro, grande, con una cicatriz en la pata delantera.', 'image' => 'images/community/drago-perdido.jpg'],
        ];
        $campaigns = [
            ['title' => 'Adobada solidaria', 'detail' => 'Cada adobada ayuda a cubrir alimento y cuidados veterinarios.', 'image' => 'images/community/adobada.jpg'],
            ['title' => 'Pollada solidaria', 'detail' => 'Campaña para recaudar fondos destinados a los albergues.', 'image' => 'images/community/pollada-1.jpg'],
            ['title' => 'Gran rifa navideña', 'detail' => 'Participa y apoya una causa que transforma vidas.', 'image' => 'images/community/rifa-navidad.jpg'],
            ['title' => 'Adobitos para ayudar', 'detail' => 'Tu compra se convierte en alimento y atención para los animales.', 'image' => 'images/community/adobitos.jpg'],
        ];
        $gallery = collect(File::files(public_path('images/gallery')))
            ->map(fn ($file) => 'images/gallery/'.$file->getFilename())
            ->values();

        return view('home', compact('dogs', 'cats', 'needs', 'lostAnimals', 'campaigns', 'gallery', 'dogPhotos'));
    }

    public function panel(Request $r)
    {
        $u = $r->user();
        $adoptions = AdoptionRequest::with('dog')->where('user_id', $u->id)->latest()->get();
        $donations = Donation::where('user_id', $u->id)->latest()->get();
        $volunteers = VolunteerApplication::where('user_id', $u->id)->latest()->get();
        $dogs = Dog::where('is_published', true)->where('adoption_status', 'disponible')->get();
        $needs = Need::where('status', 'activa')->get();

        return view('panel', compact('adoptions', 'donations', 'volunteers', 'dogs', 'needs'));
    }

    public function adopt(Request $r, ShelterService $s)
    {
        $d = $r->validate(['dog_id' => 'required|exists:dogs,id', 'housing_type' => 'required|string|max:120', 'experience' => 'required|string|min:10|max:2000', 'consent' => 'accepted']);
        unset($d['consent']);
        $s->adopt($r->user(), $d);

        return back()->with('success', 'Solicitud enviada. El albergue revisará tu información.');
    }

    public function donate(Request $r)
    {
        $d = $r->validate(['need_id' => 'nullable|exists:needs,id', 'type' => 'required|in:dinero,bienes', 'amount' => 'nullable|required_if:type,dinero|numeric|min:1|max:100000', 'description' => 'required|string|max:2000']);
        Donation::create($d + ['user_id' => $r->user()->id]);

        return back()->with('success', 'Intención registrada. No se ha realizado ningún cobro.');
    }

    public function volunteer(Request $r)
    {
        $d = $r->validate(['skills' => 'required|string|min:5|max:2000', 'availability' => 'required|string|max:200']);
        if (VolunteerApplication::where('user_id', $r->user()->id)->whereIn('status', ['pendiente', 'aprobada'])->exists()) {
            return back()->withErrors(['skills' => 'Ya tienes una postulación activa.']);
        }VolunteerApplication::create($d + ['user_id' => $r->user()->id]);

        return back()->with('success', 'Postulación enviada.');
    }

    public function care(Request $r)
    {
        $d = $r->validate(['dog_id' => 'required|exists:dogs,id', 'care_type' => 'required|in:alimentación,paseo,higiene,observación', 'description' => 'required|string|max:2000', 'recorded_at' => 'required|date|before_or_equal:today']);
        CareRecord::create($d + ['user_id' => $r->user()->id]);

        return back()->with('success', 'Cuidado registrado.');
    }

    public function careIndex()
    {
        return view('care', ['dogs' => Dog::all(), 'records' => CareRecord::with(['dog', 'user'])->latest()->paginate(20)]);
    }
}
