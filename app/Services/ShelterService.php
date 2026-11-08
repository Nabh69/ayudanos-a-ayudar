<?php
namespace App\Services;
use App\Models\{Dog,AdoptionRequest,VolunteerApplication};
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class ShelterService {
 // Lock the animal to avoid accepting two adoptions concurrently.
 public function adopt($user,array $data) { return DB::transaction(function() use($user,$data){$dog=Dog::lockForUpdate()->findOrFail($data['dog_id']);if(!$dog->is_published || $dog->adoption_status!=='disponible') throw ValidationException::withMessages(['dog_id'=>'Este perro no está disponible para solicitudes.']);if(AdoptionRequest::where('user_id',$user->id)->where('dog_id',$dog->id)->whereIn('status',['pendiente','en revisión','aprobada'])->exists()) throw ValidationException::withMessages(['dog_id'=>'Ya tienes una solicitud activa para este perro.']);return AdoptionRequest::create($data+['user_id'=>$user->id]);}); }
 public function reviewAdoption(AdoptionRequest $item,array $data) {DB::transaction(function() use($item,$data){$dog=Dog::lockForUpdate()->findOrFail($item->dog_id);if($data['status']==='aprobada'){if(AdoptionRequest::where('dog_id',$dog->id)->where('id','!=',$item->id)->where('status','aprobada')->exists())throw ValidationException::withMessages(['status'=>'El perro ya tiene otra adopción aprobada.']);$dog->update(['adoption_status'=>'adoptado']);}elseif($item->status==='aprobada'){$dog->update(['adoption_status'=>'disponible']);}$item->update($data);});}
}
