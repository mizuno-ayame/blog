<?php

namespace App\Http\Controllers;


use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        //dd($getpost, $firstpost);


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
        //         'user_id' => $request->user_id,
        //         'create_at' => Carbon::now() insertの場合はcreate_atが必要
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
    public function edit($id)
    {
        //return view('post.edit', ['post' => $post]);

        $post = Post::findOrFail($id);
        return view('post.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            DB::table('posts')
            ->where('id', $id)
            ->update([
                    'content' => $request->content,
                    'user_id' => $request->user_id,
                    'updated_at' => Carbon::now()
                ]);

            // Eloquent
            $post = Post::findOrFail($id);
            $post->content = $request->content;
            $post->user_id = $request->user_id;
            $post->save();

            // Eloquent別パターン
            Post::where('id', $id)->update([
                'content' => $request->content,
                'user_id' => $request->user_id
            ]);

             //クロージャーを活用したトランザクション処理 use宣言忘れがち
            DB::transaction(function() use($request, $id){//useの書き忘れが多い
                Post::where('id', $id)->update([
                    'content' => $request->content,
                    'user_id' => $request->user_id
            ]);
        });

            DB::commit();

        } catch(\Exception $e) {
            DB::rollBack();
            report($e);
            Log::info('更新時のエラー' . $e);//メッセージを自分で決めらるから重宝する　Logファイル見てidでエラー内容が確認できる
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //クエリビルダ
        DB::table('post')->where('id', $id)->delete();

        //Eloquent 3パターン存在
        Post::finf($id)->delete();
        //もしくは
        Post::destroy($id);
        //さらに
        Post::where('id', $id)->delete();
    }
}
