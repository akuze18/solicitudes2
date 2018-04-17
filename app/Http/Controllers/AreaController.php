<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Repositories\AllRepositories;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\AreaRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Ultraware\Roles\Models\Role;

class AreaController extends Controller
{
    protected $reps;

    public function __construct(AllRepositories $allRepositories){
        $this->middleware('auth');
        $this->reps = $allRepositories;
    }

    public function index(){
        $areas = $this->reps->area()->listArea();
        return view('app.area.list',compact('areas'));
    }

    public function create(){
        $roles = $this->reps->role()->allRole();
        return view('app.area.create',compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:100',
            'sname' => 'required|max:20',
            'area-rank1' => 'numeric',
            'area-rank2' => 'numeric',
            'area-rank3' => 'numeric',
        ]);
        $data = request()->all();
        $rolRank1 = $this->reps->role()->byId($data['area-rank1']);
        $rolRank2 = $this->reps->role()->byId($data['area-rank2']);
        $rolRank3 = $this->reps->role()->byId($data['area-rank3']);
        Area::create([
            'name' => $data['name'],
            'sname' => $data['sname'],
            'rank1' =>$rolRank1->slug,
            'rank2' =>$rolRank2->slug,
            'rank3' =>$rolRank3->slug,
        ]);
        return redirect()->route('areas');
    }

    public function show(Area $area){
        return view('app.area.detail',compact('area'));
    }
    public function edit(Area $area){
        $roles = $this->reps->role()->allRole();
        return view('app.area.edit',compact('area','roles'));
    }

    public function update(Request $request, Area $area)
    {
        $this->validate(request(),[
            'name' => 'required|max:100',
            'sname' => 'required|max:20',
            'area-rank1' => 'numeric',
            'area-rank2' => 'numeric',
            'area-rank3' => 'numeric',
        ]);
        $data = $request->all();
        $area->name = $data['name'];
        $area->sname = $data['sname'];
        $area->rank1 = $this->reps->role()->byId($data['area-rank1'])->slug;
        $area->rank2 = $this->reps->role()->byId($data['area-rank2'])->slug;
        $area->rank3 = $this->reps->role()->byId($data['area-rank3'])->slug;
        $area->save();
        return redirect()->route('areas');
    }
    public function destroy(Request $request)
    {
        $area = Area::where('id',$request->get('area_id'))->first();
        //$this->authorize('destroy',$area);
        //if (Gate::denies('destroy', $area)) {abort(403);}
        if ( $area->roles()->count() != 0) {
            return redirect()->route('areas')
                ->withErrors(['mensaje'=>$area->name.' no puede ser borrada mientras tenga roles asociados'])
                ->withInput();
        }
        else{
            $area->delete();
            return redirect()->route('areas');
        }
    }

    //para API
    public function getAreaSname(Request $request){
        $data = $request->all();
        $area_id = $data['area_id'];
        if(!is_null($area_id)){
            $area = $this->reps->area()->byId($area_id);
            if(!is_null($area)){
                echo $area->sname;
            }
        }
        echo '';
    }

}
