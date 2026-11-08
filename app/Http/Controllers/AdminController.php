<?php
namespace App\Http\Controllers;
use App\Models\{Dog,Need,Donation,AdoptionRequest,VolunteerApplication};
use App\Services\ShelterService;
use Illuminate\Http\Request;
class AdminController extends Controller {
 public static function definitions(): array {return [
 'perros'=>[Dog::class,'Perros',['name'=>'Nombre','age_text'=>'Edad aproximada','sex'=>'Sexo','size'=>'Tamaño','description'=>'Descripción','adoption_status'=>'Estado de adopción','is_published'=>'Publicación'],['name'=>'required|string|max:100','age_text'=>'required|string|max:80','sex'=>'required|in:hembra,macho','size'=>'required|in:pequeño,mediano,grande','description'=>'required|string|max:3000','adoption_status'=>'required|in:disponible,en evaluación,adoptado','is_published'=>'required|boolean']],
 'necesidades'=>[Need::class,'Necesidades',['title'=>'Título','description'=>'Descripción','quantity'=>'Cantidad requerida','priority'=>'Prioridad','status'=>'Estado'],['title'=>'required|string|max:150','description'=>'required|string|max:2000','quantity'=>'required|integer|min:1|max:100000','priority'=>'required|in:alta,media,baja','status'=>'required|in:activa,cubierta']],
 'aportes'=>[Donation::class,'Aportes',['need_id'=>'Necesidad (ID opcional)','type'=>'Tipo','amount'=>'Monto en soles (solo dinero)','description'=>'Descripción','status'=>'Estado'],['need_id'=>'nullable|exists:needs,id','type'=>'required|in:dinero,bienes','amount'=>'nullable|required_if:type,dinero|numeric|min:1|max:100000','description'=>'required|string|max:2000','status'=>'required|in:pendiente,recibida,cancelada']]];}
 private function definition($kind) {return self::definitions()[$kind] ?? abort(404);}
 public function index($kind) {$def=$this->definition($kind);return view('admin',['kind'=>$kind,'def'=>$def,'items'=>$def[0]::latest()->paginate(15),'editing'=>null]);}
 public function edit($kind,$id) {$def=$this->definition($kind);return view('admin',['kind'=>$kind,'def'=>$def,'items'=>$def[0]::latest()->paginate(15),'editing'=>$def[0]::findOrFail($id)]);}
 public function save(Request $r,$kind,$id=null) {$def=$this->definition($kind);$d=$r->validate($def[3]);if($id){$def[0]::findOrFail($id)->update($d);}else{$def[0]::create($d);}return redirect('/admin/'.$kind)->with('success','Registro guardado correctamente.');}
 public function delete($kind,$id) {$def=$this->definition($kind);$item=$def[0]::findOrFail($id);if($kind==='perros' && (AdoptionRequest::where('dog_id',$id)->exists() || \App\Models\CareRecord::where('dog_id',$id)->exists()))return back()->withErrors(['delete'=>'Conserva el historial: este perro tiene solicitudes o cuidados. Puedes ocultar su publicación.']);$item->delete();return redirect('/admin/'.$kind)->with('success','Registro eliminado.');}
 public function requests() {return view('requests',['adoptions'=>AdoptionRequest::with(['dog','user'])->latest()->get(),'volunteers'=>VolunteerApplication::with('user')->latest()->get()]);}
 public function review(Request $r,$type,$id,ShelterService $s) {$d=$r->validate(['status'=>'required|in:pendiente,en revisión,aprobada,rechazada','admin_notes'=>'nullable|string|max:2000']);if($type==='adopcion'){$s->reviewAdoption(AdoptionRequest::findOrFail($id),$d);}elseif($type==='voluntariado'){$v=VolunteerApplication::findOrFail($id);$v->update(['status'=>$d['status']]);if($d['status']==='aprobada' && $v->user->role==='supporter'){$v->user->forceFill(['role'=>'volunteer'])->save();}}else abort(404);return back()->with('success','Evaluación guardada.');}
}
