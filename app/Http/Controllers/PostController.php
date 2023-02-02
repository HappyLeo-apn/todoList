<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function create(){
         $posts = Post::when(request('searchKey'), function($query){
                $key = request('searchKey');
                $query->orWhere('title', 'like', '%'.$key.'%')
                      ->orWhere('description', 'like', '%'.$key.'%');
         })
                ->orderBy('created_at', 'desc')
                ->paginate(4);


        // $posts = Post::when(request('key'), function($p){
        //     $searchKey = request('key');
        //     $p->where('title', 'like', '%'.$searchKey.'%');
        // })->paginate(4);


        return view('create', compact('posts'));
    }

    //Post Create
    public function postCreate(Request $request){
    $data = $this->getPostData($request);
    if($request->hasFile('postImage')){
            $fileName = uniqid() . "_HappyLeo_". $request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeAs('public', $fileName);
             $data['image'] = $fileName;
        }
        
    $this->postValidation($request);
    
    
      

    Post::create($data);
    // return back();
    // return redirect('testing'); url
    //return redirect()->route('test'); //name
    return redirect()->route('post#createPage')->with(['insertSuccess' => 'Post ဖန်တီးခြင်း အောင်မြင်ပါသည်']);
    }

    //post delete
    public function postDelete($id){
        Post::where('id', $id)->delete(); //first Way
        //Second Way
        //Post::find($id)->delete();
        //return redirect()->route('post#createPage');
        return back();
    }

    //update page
    public function updatePage($id){
        $post = Post::where('id', $id)->get();
        return view('update', compact('post'));
}

    //edit Page
    public function editPage($id){
        $post = Post::where('id', $id)->first()->toArray();
        return view('edit', compact('post'));
    }
    //update Post
    public function update(Request $request){
        $this->postValidation($request);
        $id = $request->postId;
        
       $updateData = $this->getPostData($request);
       if($request->hasFile('postImage')){
        $oldImageName = Post::select('image')->where('id', $request->postId)->first()->toArray();
        $oldImageName = $oldImageName['image'];
        if($oldImageName !== null){
            Storage::delete('public/' . $oldImageName);
        }
        

        $fileName = uniqid() . "_HappyLeo_". $request->file('postImage')->getClientOriginalName();
        $request->file('postImage')->storeAs('public', $fileName);
         $updateData['image'] = $fileName;
    }
       Post::where('id', $id)->update($updateData); //$updateData must be in array format
       return redirect()->route('post#createPage')->with(['updateSuccess' => 'update လုပ်ခြင်း အောင်မြင်ပါသည်']);

    }

    //get update data
    // private function getUpdateData($request){

    // }

    //get post data
    private function getPostData($request){
         $data = [
            'title' => $request->postTitle,
            'description' => $request->postDescription,
        ];
        $data['price'] = $request->postFee == null ? 2000 : $request->postFee ;
        $data['address'] = $request->postAddress == null ? "Katha" : $request->postAddress ;
        $data['rating'] = $request->postRating == null ? 5 : $request->postRating;
        
        return $data;
        

    }

    private function postValidation($request){
        $validationRules = [
            'postTitle' => 'required|min:5|unique:posts,title,'.$request->postId,
            'postDescription' => 'required|min:10',
            // 'postFee' => 'required',
            // 'postAddress' => 'required',
            // 'postRating' => 'required',
            // 'postImage' => 'mimes:jpg,bmp,png'
        ];
        $validationMessages = [
            'postTitle.required' => 'Post ခေါင်းစဉ်ဖြည့်ရန်လိုအပ်ပါသည်',
            'postTitle.min' => 'Post ခေါင်းစဉ်တွင် အနည်းဆုံးစကားလုံး (၅) လုံံး ဖြည့်သွင်းပါ',
            'postTitle.unique' => 'Post ခေါင်းစဉ်မှာ ရှိပြီးသား ခေါင်းစဉ်ဖြစ်နေသည်',
            'postDescription.required' => 'Post အကြောင်းအရာဖြည့်ရန်လိုအပ်ပါသည်',
            'postDescription.min' => 'Post အကြောင်းအရာ တွင် အနည်းဆုံး စကားလုံး (၁၀) လုံး ဖြည့်ရန်လိုအပ်ပါသည်',
            //'postDescription.unique' => 'Post အကြောင်းအရာဖြည့်ရန်လိုအပ်ပါသည်',
            'postFee.required' => 'Fee ဖြည့်သွင်းပါ',
            'postAddress.required' => 'နေရပ်လိပ်စာ ဖြည့်သွင်းပါ',
            'postRating.required' => 'Rating သတ်မှတ်ပါ',
            'postImage.mimes' => 'Jpg, Bmp, Png format only'

        ];
        Validator::make($request->all(), $validationRules, $validationMessages)->validate();
    }

}
