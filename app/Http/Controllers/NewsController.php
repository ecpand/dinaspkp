<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request) {
        $posts = Post::query()
            ->when($request->filled('cari'), fn ($query) => $query->where(function ($items) use ($request) { $items->where('title', 'like', '%'.$request->input('cari').'%')->orWhere('excerpt', 'like', '%'.$request->input('cari').'%'); }))
            ->when($request->filled('kategori'), fn ($query) => $query->where('category', $request->input('kategori')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')))
            ->latest('published_at')->latest()
            ->paginate(10)
            ->withQueryString();

        return view('console.news', ['posts'=>$posts, 'categories'=>Post::whereNotNull('category')->where('category', '!=', '')->distinct()->orderBy('category')->pluck('category')]);
    }
    private function data(Request $request, ?Post $post = null): array
    {
        $data=$request->validate(['title'=>'required|max:255','category'=>'nullable|max:100','excerpt'=>'nullable','content'=>'required','status'=>'required|in:draft,published','published_at'=>'nullable|date','cover'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:5120']);
        $slug=Str::slug($data['title']); $base=$slug; $number=2; while(Post::where('slug',$slug)->when($post,fn($q)=>$q->whereKeyNot($post->id))->exists()) $slug=$base.'-'.$number++;
        $data['slug']=$slug; $data['author_id']=$request->session()->get('console_user'); if($request->hasFile('cover')) $data['cover_image']=$request->file('cover')->store('posts','public'); unset($data['cover']); if($data['status']==='published' && blank($data['published_at'])) $data['published_at']=now(); return $data;
    }
    public function store(Request $request) { Post::create($this->data($request)); return back()->with('success','Berita ditambahkan.'); }
    public function update(Request $request, Post $post) { $post->update($this->data($request,$post)); return back()->with('success','Berita diperbarui.'); }
    public function destroy(Post $post) { $post->delete(); return back()->with('success','Berita dihapus.'); }
}
