<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

use Illuminate\Http\Request;

use CMS\Http\Controllers\Controller;
use JornSchalkwijk\LaravelCMS\Models\Folder;
use JornSchalkwijk\LaravelCMS\Models\Upload;
use JornSchalkwijk\LaravelCMS\Models\Gallery;

class FileManagerController extends Controller
{

    protected $model = Folder::class;

//    public function index(Request $r)
//    {
//        $galleries = Gallery::all();
//        $folders = Folder::where('parent_id',0)->get();
//        $html =  view('JornSchalkwijk\LaravelCMS::admin.uploads.file-manager.index')->with(['galleries' => $galleries,'folders' => $folders,'template'=>$this->adminTemplate()]);
////        return response()->json(['success' => true,'html' => $html]);
//        return $html;
//    }

    public function folders()
    {
        $folders = Folder::where('parent_id',0)->get();
        $html = view('JornSchalkwijk\LaravelCMS::admin.uploads.file-manager.folders')->with(['template' => $this->adminTemplate(), 'folders' => $folders])->renderSections()['content'];
//        $html = require_once resource_path('/views/admin/uploads/file-manager/folders.blade.php');
        return response()->json(['success' => true,'html' => $html]);
    }
    public function foldersWithUploads(Folder $folder)
    {
        $folders = Folder::all()->where('parent_id',$folder->folder_id);
        $files = $folder->files;
        $back = '/admin/folders/'.$folder->parent_id;
        $html = view('JornSchalkwijk\LaravelCMS::admin.uploads.file-manager.show')->with(['template' => $this->adminTemplate(), 'folder' => $folder,'folders' => $folders, 'uploads' => $files,'back' => $back])->renderSections()['content'];
        return response()->json(['success' => true,'html' => $html]);
    }

    public function search(Request $r)
    {
        $uploads = Upload::search($r['search'])->get();

        $returnHTML = view('JornSchalkwijk\LaravelCMS::admin.uploads.file-manager.search-results')->with(['uploads' => $uploads])->renderSections()['content'];

        return response()->json(array('success' => true,'html' => $returnHTML));
    }

    public function gallery($id)
    {
        $gallery = Gallery::find($id);
        $returnHTML = view('JornSchalkwijk\LaravelCMS::admin.uploads.file-manager.selected-gallery')->with(['gallery'=>$gallery,'uploads' =>$gallery->uploads])->renderSections()['content'];
        return response()->json(array('success' => true, 'html' => $returnHTML));

    }

    public function createGallery(Request $r)
    {
        $gallery = new Gallery($r->all());
        if($gallery->save()){
            return response()->json(array('success' => true,'gallery' => $gallery));
        } else {
            return response()->json(array('success' => false));
        }
    }

    public function addToGallery(Request $r)
    {
        $gallery = Gallery::find($r['gallery_id']);
        $gallery->uploads()->syncWithoutDetaching($r['images']);

        return response()->json(['success' => true]);
    }

    public function removeFromGallery(Request $r)
    {
        $gallery = Gallery::find($r['gallery_id']);
        $gallery->uploads()->detach($r['images']);

        return response()->json(['success' => true]);
    }

    public function addGalleryToEditor(Request $r){

        $gallery = Gallery::find($r['gallery']);
        $returnHTML = view('JornSchalkwijk\LaravelCMS::admin.uploads.file-manager.gallery')->with(['gallery'=>$gallery,'uploads' =>$gallery->uploads])->renderSections()['content'];

        return response()->json(array('success' => true,'html' => $returnHTML));
    }
}
