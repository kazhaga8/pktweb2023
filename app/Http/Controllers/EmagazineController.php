<?php

namespace App\Http\Controllers;

use App\Ebook;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmagazineController extends Controller
{
    function __construct()
    {
        //  $this->middleware('permission:e-magazine-list', ['only' => ['index','store']]);
        //  $this->middleware('permission:e-magazine-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:e-magazine-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:e-magazine-delete', ['only' => ['destroy']]);
    }


    public function json(){
        return DataTables::of(Ebook::where('type', '=', 'e-magazine')->orderBy('id','DESC'))->addIndexColumn()->make(true);
    }

    public function index(Request $request)
    {
        $page['page'] = 'e-magazine';
        $page['can'] = 'page';
        $page['title'] = 'E-Magazine Management';
        return view('webmin.e-magazine.index',compact('page'));
    }

    public function create()
    {
        $page['page'] = 'e-magazine';
        $page['title'] = 'E-Magazine Management';
        $page['method'] = 'POST';
        $page['action'] = route('e-magazine.store');
        return view('webmin.e-magazine.form',compact('page'));
    }

    public function store(Request $request)
    {
        $store  = $request->all();
        request()->validate([
            'title' => 'required',
            'file' => 'required',
            'image' => 'required',
        ]);
        $store['ref'] =  (Ebook::where('type', '=', 'e-magazine')->max('ref') || 0) + 1;
        foreach (config('app.locales') as $lang) {
            $reorder = Ebook::where('type', '=', 'e-magazine')->where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder || 0) + 1;
            Ebook::create($store);
        }

        return redirect()->route('e-magazine.index')
                        ->with('success','E-Magazine created successfully.');
    }

    public function edit(Ebook $ebook)
    {
        $page['page'] = 'e-magazine';
        $page['title'] = 'E-Magazine Management';
        $page['method'] = 'PUT';
        $page['action'] = route('e-magazine.update',$ebook->id);
        return view('webmin.e-magazine.form',compact('page','ebook'));
    }
    public function update(Request $request, Ebook $ebook)
    {
        request()->validate([
            'title' => 'required',
            'file' => 'required',
            'image' => 'required',
        ]);

        $store  = $request->all();
        $ebook->update($store);
        return redirect()->route('e-magazine.index')
                        ->with('success','E-Magazine updated successfully');
    }
    public function destroy(Ebook $ebook)
    {
        $ebook->delete();

        return redirect()->route('e-magazine.index')
                        ->with('success','E-Magazine deleted successfully');
    }
}
