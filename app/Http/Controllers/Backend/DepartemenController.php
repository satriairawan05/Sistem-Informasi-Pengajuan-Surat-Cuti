<?php

namespace App\Http\Controllers\Backend;

use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartemenController extends Controller
{
    /**
     * Constructor for Controller.
     */
    public function __construct(private $name = 'Departemen', public $create = 0, public $read = 0, public $update = 0, public $delete = 0)
    {
        //
    }

    /**
     * Generate Access for Controller.
     */
    public function get_access_page()
    {
        $userRole = $this->get_access($this->name, auth()->user()->group_id);

        foreach ($userRole as $r) {
            if ($r->page_name == $this->name) {
                if ($r->action == 'Create') {
                    $this->create = $r->access;
                }

                if ($r->action == 'Read') {
                    $this->read = $r->access;
                }

                if ($r->action == 'Update') {
                    $this->update = $r->access;
                }

                if ($r->action == 'Delete') {
                    $this->delete = $r->access;
                }
            }
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->get_access_page();
        if ($this->read == 1) {
            try {
                return view('backend.setting.departemen.index',[
                    'name' => $this->name,
                    'departemen' => Departemen::paginate(10),
                    'pages' => $this->get_access($this->name, auth()->user()->group_id)
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('failed', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->get_access_page();
        if ($this->create == 1) {
            try {
                return view('backend.setting.departemen.create',[
                    'name' => $this->name
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('failed', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->get_access_page();
        if ($this->create == 1) {
            try {
                $validated = \Illuminate\Support\Facades\Validator::make($request->all(),[
                    'departemen_name' => ['required'],
                    'departemen_alias' => ['required'],
                ]);

                if(!$validated->fails()){
                    Departemen::creeate([
                        'departemen_name' => $request->input('departemen_name'),
                        'departemen_alias' => $request->input('departemen_alias'),
                    ]);

                    return redirect()->to(route('departemen.index'))->with('success','Data Saved!');
                } else {
                    return redirect()->bak()->with('failed', $validated->getMessageBag());
                }
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('failed', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Departemen $departemen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departemen $departemen)
    {
        $this->get_access_page();
        if ($this->update == 1) {
            try {
                return view('backend.setting.departemen.edit',[
                    'name' => $this->name,
                    'departemen' => $departemen->find(request()->segment(2))
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('failed', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departemen $departemen)
    {
        $this->get_access_page();
        if ($this->update == 1) {
            try {
                $validated = \Illuminate\Support\Facades\Validator::make($request->all(),[
                    'departemen_name' => ['required'],
                    'departemen_alias' => ['required'],
                ]);

                if(!$validated->fails()){
                    $data = $departemen->find(request()->segment(2));
                    Departemen::where('departemen_id', $data->departemen_id)->update([
                        'departemen_name' => $request->input('departemen_name'),
                        'departemen_alias' => $request->input('departemen_alias'),
                    ]);

                    return redirect()->to(route('departemen.index'))->with('success','Data Updated!');
                } else {
                    return redirect()->back()->with('failed', $validated->getMessageBag());
                }

            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('failed', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departemen $departemen)
    {
        $this->get_access_page();
        if ($this->delete == 1) {
            try {
                $data = $departemen->find(request()->segment(2));
                Departemen::destroy($data->departemen_id);

                return redirect()->back()->with('success','Data Deleted!');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('failed', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }
}
