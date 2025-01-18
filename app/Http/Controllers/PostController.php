<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParentCategory;
use App\Models\Category;
use App\Models\Post;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

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
            'featured_image' => 'required|mimes:png,jpg,jpeg|max:1024'
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

                // **** image resize code **** 
                // Generate Resized Image and Thumbnail 
                $resized_path = $path.'resized/';
                if( !File::isDirectory($resized_path) ){
                    File::makeDirectory($resized_path, 0777, true, true);
                }

                // Thumbnail (Aspect ratio: 1)
                Image::make($path.$new_filename)
                    ->fit(250,250)
                    ->save($resized_path.'thumb_'.$new_filename);


                // Resized Image (Aspect ratio: 1.6)
                Image::make($path.$new_filename)
                    ->fit(512,320)
                    ->save($resized_path.'resized_'.$new_filename);
                // **** image resize code **** 
                
                $post = new Post();
                $post->author_id = auth()->id();
                $post->category = $request->category;
                $post->title = $request->title;
                $post->content = $request->content;
                $post->featured_image = $new_filename;
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

    public function allPosts(Request $request){
        $data = [
            'pageTitles' => 'Posts'
        ];
        return view('back.pages.posts',$data);
    }

    public function editPost(Request $request, $id = null){
        $post = Post::findOrFail($id);

        $categories_html = '';
        $pcategories = ParentCategory::whereHas('children')->orderBy('name','asc')->get();
        $categories = Category::where('parent',0)->orderBy('name','asc')->get();

        if(count($pcategories) > 0 ){
            foreach($pcategories as $item){
                $categories_html .= '<optgroup label="'.$iem->name.'">';
                foreach($item->children as $category){
                    $selected = $category->id == $post->category ? 'Selected' : '';
                    $categories_html .= '<option value="'.$category->id.'" '.$selected.'>'.$category->name.'</option>';
                }
                $categories_html .= '</optgroup>';
            }
        }

        if(count($categories) > 0 ){
            foreach($categories as $item){
                $selected = $item->id == $post->category ? 'selected' : '';
                $categories_html .='<option value="'.$item->id.'" '.$selected.'>'.$item->name.'</option>';
            }
        }

        $data = [
            'pageTitles' => 'Edit',
            'post' => $post,
            'categories_html' => $categories_html 
        ];
        return view('back.pages.edit_post',$data);
    }
}
