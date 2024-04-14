<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::query()
        ->where("user_id", request()->user()->id)
        ->orderBy("created_at", "DESC")->paginate(10);
        return view("blog.index", [
            "blogs" => $blogs
        ]); // index.blade.php
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("blog.create"); // create.blade.php
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => "required|string",
            "description" => "required|string",
            "status" => "required"
        ]);

        $data["user_id"] = request()->user()->id;

        // Banner Image
        $imageName = NULL;

        if($request->banner_image != NULL){

            $imageObject = $request->banner_image;

            // abc.png, abc.png

            $imageExtenion = $imageObject->getClientOriginalExtension();
            $newImageName = time().".".$imageExtenion; // 324324.png

            $imageObject->move(public_path("images"), $newImageName);

            $imageName = $newImageName;

        }

        $data["banner_image"] = $imageName;

        Blog::create($data);

        return to_route('blog.index')->with("success", "Successfully, blog was created");
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {

        if($blog->user_id != request()->user()->id){

            abort(403);
        }

        return view("blog.show", [
            "blog" => $blog
        ]); // show.blade.php
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view("blog.edit", [
            "blog" => $blog
        ]); // edit.blade.php
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            "title" => "required|string",
            "description" => "required|string",
            "status" => "required"
        ]);

        if($request->banner_image != NULL){

            $imageName = NULL;

            $imageObject = $request->banner_image;

            $imageExt = $imageObject->getClientOriginalExtension();

            $newImageName = time() .".".$imageExt;

            $imageObject->move(public_path('images'), $newImageName);

            $imageName = $newImageName;

            $data["banner_image"] = $imageName;
        }

        $blog->update($data);

        return to_route('blog.show', $blog)->with("success", "Successfully, blog was updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return to_route("blog.index")->with("success", "Successfully, blog was deleted");
    }
}
