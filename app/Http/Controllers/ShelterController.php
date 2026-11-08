<?php
namespace App\Http\Controllers;
use App\Models\{Dog,Need,Donation,AdoptionRequest,VolunteerApplication,CareRecord};
use App\Services\ShelterService;
use Illuminate\Http\Request;
class ShelterController extends Controller {
 public function home(Request $r) {$dogs=Dog::where('is_published',true)->when($r->filled('size'),fn($q)=>$q->where('size',$r->string('size')))->latest()->paginate(9);$needs=Need::where('status','activa')->latest()->get();return view('home',compact('dogs','needs'));}
 public function panel(Request $r) {$u=$r->user();$adoptions=AdoptionRequest::with('dog')->where('user_id',$u->id)->latest()->get();$donations=Donation::where('user_id',$u->id)->latest()->get();$volunteers=VolunteerApplication::where('user_id',$u->id)->latest()->get();$dogs=Dog::where('is_published',true)->where('adoption_status','disponible')->get();$needs=Need::where('status','activa')->get();return view('panel',compact('adoptions','donations','volunteers','dogs','needs'));}
 public function adopt(Request $r,ShelterService $s) {$d=$r->validate(['dog_id'=>'required|exists:dogs,id','housing_type'=>'required|string|max:120','experience'=>'required|string|min:10|max:2000','consent'=>'accepted']);unset($d['consent']);$s->adopt($r->user(),$d);return back()->with('success','Solicitud enviada. El albergue revisará tu información.');}
 public function donate(Request $r) {$d=$r->validate(['need_id'=>'nullable|exists:needs,id','type'=>'required|in:dinero,bienes','amount'=>'nullable|required_if:type,dinero|numeric|min:1|max:100000','description'=>'required|string|max:2000']);Donation::create($d+['user_id'=>$r->user()->id]);return back()->with('success','Intención registrada. No se ha realizado ningún cobro.');}
 public function volunteer(Request $r) {$d=$r->validate(['skills'=>'required|string|min:5|max:2000','availability'=>'required|string|max:200']);if(VolunteerApplication::where('user_id',$r->user()->id)->whereIn('status',['pendiente','aprobada'])->exists())return back()->withErrors(['skills'=>'Ya tienes una postulación activa.']);VolunteerApplication::create($d+['user_id'=>$r->user()->id]);return back()->with('success','Postulación enviada.');}
 public function care(Request $r) {$d=$r->validate(['dog_id'=>'required|exists:dogs,id','care_type'=>'required|in:alimentación,paseo,higiene,observación','description'=>'required|string|max:2000','recorded_at'=>'required|date|before_or_equal:today']);CareRecord::create($d+['user_id'=>$r->user()->id]);return back()->with('success','Cuidado registrado.');}
 public function careIndex() {return view('care',['dogs'=>Dog::all(),'records'=>CareRecord::with(['dog','user'])->latest()->paginate(20)]);}
}
