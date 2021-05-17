<?php
//避免在post方法中渲染模板，而是在get方法中使用！运用redirect重定向来完成
//post传值使用{{}},get则使用session
namespace App\Http\Controllers;  //命名区域

use Illuminate\Http\Request;  //request路径

use App\Models\User;  //模型路径
use App\Models\Bento;
use App\Models\BentoImage;

use Illuminate\Support\Facades\Auth;  //确定auth使用路径，认证登录
use Illuminate\Support\Facades\Hash;  //hash路径，密码加密
use Illuminate\Support\Facades\Storage;  //图片存储路径



class TopController extends Controller
{

    public function top(Request $request)     //页面展示
    {

        /** if (Auth::check()) {           //进入session验证是否有登录信息,是进入主页，不是进入登录画面
        $user = Auth::user();         //config文件夹下的auth.php文件进行配置
        $user_id = Auth::id();        //验证的是加密密码->Hash
        $bentos = Bento::all();       //已经在routes里添加了中间件检查是否登录：middleware
         */

        $word = $request->query('word');        //首页检索栏显示内容接收
        $price_l = $request->query('price_l');  //使用get方法，因为需要在这个函数内渲染模板
        $price_h = $request->query('price_h');

        //$headPortrait =$request->query('headPortrait_url');  //显示用户头像
        if(Auth::user() != null){           //判定用户是否登录
            $headPortrait = Auth::user()->get_user_headPortrait_url();
        }else{
            $headPortrait = '';    //避免找不到变量报错
        }

        $bento_query = Bento::query();

        /**    return view('top', [
        'bentos' => $bentos,
        'word' => $word
        ]);
        } else {
        return redirect('/login'); //重定向页面(跳转)  */

        if ($word != null) {
            $bento_query->where('bento_name', 'like', '%'.$word.'%');

        }

        if ($price_l != null) {
            $bento_query->where('price', '>=', $price_l);
        }

        if ($price_h != null) {
            $bento_query->where('price', '<=', $price_h);
        }

        $bentos = $bento_query->paginate(4);   //laravel分页，每页4项->top.blade进行详细处理
        //$bentos = $bento_query->get();

        return view('top', [
            'bentos' => $bentos,
            'word' => $word,
            'price_l' => $price_l,
            'price_h' => $price_h,
            'headPortrait_url' => $headPortrait,
        ]);
    }

    public function register(Request $request)    //注册页面
    {
        $error_message = $request->session()->get('error_message');
        $data = $request->session()->get('data');

        if ($error_message == null) {
            $error_message = [
                'email' => null,
                'password' => null,
                'password_confirm' => null,
                'postcode' => null,
                'prefecture' => null,
                'city' => null,
                'address' => null,
                'tel' => null,
                'name' => null,
            ];
        }

        if ($data == null) {
            $data = [
                'email' => '',
                'password' => '',
                'password_confirm' => '',
                'postcode' => '',
                'prefecture' => '',
                'city' => '',
                'address' => '',
                'tel' => '',
                'name' => '',
                'headPortrait_url' => '',
            ];
        }

        return view('register', [
            'error_message' => $error_message,
            'data' => $data
        ]);
    }

    public function registerUser(Request $request)
    {
        $email = $request->post('email');
        $password = $request->post('password');
        $password_confirm = $request->post('password_confirm');
        $postcode = $request->post('postcode');
        $prefecture = $request->post('prefecture');
        $city = $request->post('city');
        $address = $request->post('address');
        $tel = $request->post('tel');
        $name = $request->post('name');

        //获取用户上传头像
        $headPortrait = $request->file('headPortrait_url');

        $data = [                          //保留未出错信息
            'email' => $email,
            'password' => $password,
            'password_confirm' => $password_confirm,
            'postcode' => $postcode,
            'prefecture' => $prefecture,
            'city' => $city,
            'address' => $address,
            'tel' => $tel,
            'name' => $name,
            'headPortrait_url' => $headPortrait,
        ];

        $has_error = false;

        $error_message = [
            'email' => null,
            'password' => null,
            'password_confirm' => null,
            'postcode' => null,
            'prefecture' => null,
            'city' => null,
            'address' => null,
            'tel' => null,
            'name' => null,
        ];

        if ($email == "") {
            $error_message['email']  = '请输入邮箱';
            $has_error = true;
        }

        if ($password == "") {
            $error_message['password']  = '请输入密码';
            $has_error = true;
        }

        if ($password != $password_confirm) {
            $error_message['password_confirm']  = '两次输入的密码不一致';
            $has_error = true;
        }

        if ($name == "") {
            $error_message['name']  = '请输入姓名';
            $has_error = true;
        }

        if ($postcode == "" || strlen($postcode) != 8) {
            $error_message['postcode']  = '请输入邮编';
            $has_error = true;
        }

        if ($prefecture == "") {
            $error_message['prefecture']  = '都道府県を入力してください';
            $has_error = true;
        }

        if ($city == "") {
            $error_message['city']  = '市区町村を入力してください';
            $has_error = true;
        }

        if ($address == "") {
            $error_message['address']  = '住所を入力してください';
            $has_error = true;
        }

        if ($tel == "" || strlen($tel) != 11) {


            $error_message['tel']  = '正しい電話番号を入力してください';
            $has_error = true;
        }

        if ($has_error) {
            $request->session()->put('error_message', $error_message);  //存在(服务器)，REDIS里，携带数据
            $request->session()->put('data', $data);

            return redirect('/register');  //重定向
        }

        /**
        public function userList(Request $request){
        $users = User::all();
        foreach($users as $u){
        echo $u->name;
        echo '<br>';
        echo $u->id;
        //find方法查询  $users = find(2);
        //get方法查询  $users = User::where('postcode','1234567')->get();
        //first方法与get类似  $users = User::where('postcode','1234567')->first();
        //修改: 查询  $users = User::find(4);
        //     修改  $users->postcode = '1234567';
        //   保存数据 $user -> save();
        //插入    $user = new User();
        //       $user->email = 'test6@test.com';
        //       $user->password = '1234';
        //       $user->name = 'test6';
        //       $user->save();
        //删除    $users = find(4);
        //       $users->delete();
        }
         */
        // 将输入的数据存入数据库
        $user = new User();
        $user->email = $email;
        $hashed_password = Hash::make($password);  //密码加密->Auth验证的是加密密码
        $user->password = $hashed_password;
        $user->name = $name;
        $user->postcode = $postcode;
        $user->prefecture = $prefecture;
        $user->city = $city;
        $user->address = $address;
        $user->tel = $tel;

        //将上传头像存储至服务器：存储头像名->创建头像存储文件夹
        $headPortrait_name = $user->email.'.'.$headPortrait->extension();  //用户邮箱(唯一).文件扩展名extension

        //将头像存入数据库
        $user->head_portrait_url = null;   //存入变量值，save之后再一次赋值

        $user->save();    //保存新实例

        $user->head_portrait_url = 'user_headPortrait/'.$user->id.'/'.$headPortrait_name;  //头像url命名
        $user->save();

        $headPortrait->storeAs('public/user_headPortrait/'.$user->id,$headPortrait_name);  //创建存储头像的文件夹

        $request->session()->flash('registed_user', $user);  //闪存，只存活一个请求

        return redirect('/register-success');     //重定向
    }

    public function registerSuccess(Request $request)
    {
        $user = $request->session()->get('registed_user'); //接收上一个flash

        $request->session()->keep('registed_user');  //或者reflash二次闪存所有信息

        return view('register_success', [
            'email' => $user->email,
            'name' => $user->name,
            'postcode' => $user->postcode,
            'prefecture' => $user->prefecture,
            'city' => $user->city,
            'address' => $user->address,
            'tel' => $user->tel,
            'headPortrait_url' => Storage::url($user->head_portrait_url),  //storeAs保存；Storage查询
        ]);

    }

    public function login(Request $request)
    {
        if ($request->method() == 'POST') {
            $email = $request->post('email');
            $password = $request->post('password');

            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                //默认是hash加密后的密码，MD5，在register注册逻辑内编写
                // ログイン成功
                return redirect('/');
            }
            else{
                // ログイン失敗
                $request->session()->put('login_failed', true);

                return redirect('/login');
            }

            /**
            $user = User::where('email', $email)->first();
            if ($password == $user->password) {
            // ログイン成功
            return redirect('/');
            } else {
            // ログイン失敗
            $request->session()->put('login_failed', true);//保存以及修改put('名字‘,值)
            //flash闪存
            return redirect('/login');
            }
             */
        }

        $login_failed = $request->session()->get('login_failed');//取值get
        $request->session()->forget('login_failed');//删除forget

        return view('login', [
            'login_failed' => $login_failed
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();    //退出登录

        return redirect('/login');
    }
}
