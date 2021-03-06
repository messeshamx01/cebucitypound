<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pet;
use App\PetType;
use Validator;
use Auth;

class PetController extends Controller
{
    public function list()
    {
        $pets = Pet::all();

        return view('dashboard.admin.pets.list', compact('pets'));
    }

    public function show($id)
    {
        $pet = Pet::find($id);
        $types = PetType::all();
        
        return view('dashboard.admin.pets.details', compact('pet', 'types'));
    }

    public function create(Request $request)
    {
        $types = PetType::all();

        return view('dashboard.admin.pets.create', compact('types'));
    }

    public function store()
    {
        $params = $request->all();
        
        $validator = Validator::make($params, [
            'name' => 'required',
            'age' => 'required|numeric',
            'gender' => 'required',
            'breed' => 'required',
            'color' => 'required',
            // 'image' => 'required'
        ]);

        if($validator->fails()) {
            return redirect('/dashboard/admin/create')
                ->withErrors($validator)
                ->withInput();
        } else {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $destinationPath = public_path('images');
                if (!File::exists($destinationPath)) {
                    $fileDir = File::makeDirectory('images');
                }
                $image = $file->getClientOriginalName();
                $file->move($destinationPath, $image);
                $params['image'] = $image;
            }
            $params['pet_category_id'] = 1;
            $params['user_id'] = Auth::user()->id;
            $pet = Pet::create($params);
            if($pet) {
                session()->flash('message', 'Pet updated...');
                return redirect('/dashboard/admin/pets');
            } else {
                return redirect('/dashboard/admin/pets/create');
            }
        }

    }
    public function update(Request $request, $id)
    {
        $params = $request->all();
        
        $validator = Validator::make($params, [
            'name' => 'required',
            'age' => 'required|numeric',
            'gender' => 'required',
            'breed' => 'required',
            'color' => 'required',
            // 'image' => 'required'
        ]);

        if($validator->fails()) {
            return redirect('/dashboard/admin/pets/'.$id)
                ->withErrors($validator)
                ->withInput();
        } else {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $destinationPath = public_path('images');
                if (!File::exists($destinationPath)) {
                    $fileDir = File::makeDirectory('images');
                }
                $image = $file->getClientOriginalName();
                $file->move($destinationPath, $image);
                $params['image'] = $image;
            }
            $params['pet_category_id'] = 1;
            $params['user_id'] = Auth::user()->id;
            $pet = Pet::find($id)->update($params);
            if($pet) {
                session()->flash('message', 'Pet updated...');
                return redirect('/dashboard/admin/pets');
            } else {
                return redirect('/dashboard/admin/pets/' .$id);
            }
        }
    }
}
