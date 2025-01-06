<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParentCategory;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    public function addPost(Request $request){
        $categories_html = '';
        $pcategories = ParentCategory::whereHas('children')->orderBy('name','asc')->get();
        $categories = Category::where('parent',0)->orderby('name','asc')->get();

        if( count($pcategories) > 0 ){
            foreach($pcategories as $item ){
                $categories_html.='<optgroup label="'.$item->name.'">';
                foreach ($item->children as $category) {
                    $categories_html.='<option value="'.$category->id.'">'.$category->name.'</option>';
                }
                $categories_html.='<optgroup>';
            }
        }

        if(count($categories) > 0){
            foreach($categories as $item ){
                $categories_html.='<option value="'.$item->id.'">'.$item->name.'</option>';
            }
        }

        $data = [
            'pageTitles' => 'Add new post',
            'categories_html' => $categories_html
        ];
        // dd($data);
        return view('back.pages.add_post',$data);
    }

    public function createPost(Request $request){
        // Validate the form
        $request->validate([
            'title' => 'required|unique:posts,title',
            'content' => 'required',
            'category' => 'required|exists:categories,id',
            'featured_image' => 'required|mimes:png,jpg, jpeg|max:1024'
        ]);

        // Create Post
        if( $request->hasFile('featured_image') ){
            $path = "images/posts/";
            $file = $request->file('featured_image');
            $filename = $file->getClientOriginalName();
            $new_filename = time().'_'.$filename;

            // upload image
            $upload = $file->move(public_path($path),$new_filename);

            if($upload){
                $post = new Post();
                $post->author_id = auth()->id();
                $post->category = $request->category;
                $post->title = $request->title;
                $post->content = $request->content;
                $post->featured_image = $request->featured_image;
                $post->tags = $request->tags;
                $post->meta_keywords = $request->meta_keywords;
                $post->meta_description = $request->meta_description;
                $post->visibility = $request->visibility;

                $saved = $post->save();
                if($saved){
                    return response()->json(['status'=>1, 'message'=>'New Post has been successfully created']);
                }else{
                    return response()->json(['status'=>0, 'message'=>'Something went wrong']);
                }
            }else{
                return response()->json(['status'=>0, 'message'=>'Something went wrong on uploading a featured image']);
            }
        }
    }
}
