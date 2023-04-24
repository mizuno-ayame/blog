<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * アプリケーションの全ユーザーレコード一覧を表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //クエリビルダ
        //$posts = DB::table('posts')->get();
        //$post = DB::table('posts')->where('content', 'content1')->first();//1件だけ取得
        //$post = DB::table('posts')->find(1);//特定のデータ取得

        //クエリビルダ SELECT
        //$users = DB::table('users')->select('name', 'email as user_email')->get();
        //dd($users);

        //Eloquent
        $posts = Post::all();
        $getpost = Post::where('user_id', '1')->get();
        $firstpost = Post::where('user_id', '1')->first();
        dd($getpost, $firstpost);


        //return view('post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
        // DB::table('posts')->insert([
        //         'content' => $request->content,
        //         'user_id' => $request->user_id
        // ]);

        //Eloquent
        $post =new Post;//モデルからインスタント生成する
        $post->content = $request->content;
        $post->user_id = $request->user_id;
        $post->save();

        //Eloquent別パターン
        //モデルファイルの中に、fillableを設定しなければならない
        Post::create([
                    'content' => $request->content,
                    'user_id' => $request->user_id
        ]);

        //クロージャーを活用したトランザクション処理 use宣言忘れがち
        DB::transaction(function() use($request){
            Post::create([
                'content' => $request->content,
                'user_id' => $request->user_id
    ]);
        });

        DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
            report($e); //ログファイルにエラーの内容を書き出す
        }


        return redirect('/create');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
