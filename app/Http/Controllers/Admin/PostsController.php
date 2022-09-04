<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index()
    {
        $userId =  Auth::user()->id;
        $listPosts =  Posts::orderBy('created_at', 'desc')->where('user_id', $userId)->get();
        return view('admin.posts.lists', compact('listPosts'));
    }
    public function add()
    {
        return view('admin.posts.add');
    }

    public function postAdd(Request $request, Posts $post)
    {
        $request->validate(
            [
                'title' => 'required',
                'content'=> 'required',
            ],
            [
                'title.required' => 'Nhập tiêu đề bài viết',
                'content.required' => 'Nhập nội dung bài viết',
            ]
        );

        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id =  Auth::user()->id;
        $post->save();

        return redirect()->route('admin.posts.index')->with('msg', 'Thêm bài viết thành công.');
    }

    public function edit(Posts $post)
    {
        $this->authorize('update', $post);
        return view('admin.posts.edit', compact('post'));
    }

    public function postEdit(Request $request, Posts $post)
    {
        $this->authorize('update', $post);
        $request->validate(
            [
                'title' => 'required',
                'content'=> 'required',
            ],
            [
                'title.required' => 'Nhập tiêu đề bài viết',
                'content.required' => 'Nhập nội dung bài viết',
            ]
        );

        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();
        return redirect()->route('admin.posts.index')->with('msg', 'Sửa bài viết thành công.');
    }

    public function delete(Posts $post)
    {
        $this->authorize('delete', $post);
        $status = Posts::destroy($post->id);
        if($status){
            return redirect()->route('admin.posts.index')->with('msg', 'Xoá bài viết thành công.');
        }
        return redirect()->route('admin.posts.index')->with('msg', 'Bạn không thể bài này.');
    }
}
