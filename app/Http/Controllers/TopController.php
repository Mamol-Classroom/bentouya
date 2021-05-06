<?php
namespace App\Http\Controllers;

use App\Models\Bento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class TopController extends Controller
{
    public function top(Request $request){
        if(Auth::check()){
            $user=Auth::user();
            $bentos=Bento::all();

            return view('top',[
                'name'=>$user->name,
                'bentos'=>$bentos,
            ]);
        }else{
            return redirect('/login');
        }
    }


    public function register(Request $request){
        $error_message=$request->session()->get('error_message');

        return view('register',[
            'error_message'=>$error_message
        ]);

    }

    public function registerUser(Request $request){
        $email = $request->post('email');
        $password = $request->post('password');
        $password_confirm= $request->post('password_confirm');
        $telephone=$request->post('telephone');
        $postcode=$request->post('postcode');
        $prefecture=$request->post('prefecture');
        $city=$request->post('city');
        $address=$request->post('address');
        $name=$request->post('name');

        $has_error=false;
        $error_message=[
            'email' => null,
            'password' => null,
            'password_confirm'=>null,
            'telephone'=> null,
            'postcode'=>null,
            'prefecture'=>null,
            'city'=>null,
            'address'=>null,
            'name'=>null
        ];

        if ($email==''){
            $error_message['email']='メールアドレスの入力が必要です。';
            $has_error=true;
        }
        if ($password==''){
            $error_message['password']='パスワードの入力が必要です。';
            $has_error=true;
        }
        if ($password=='' or $password_confirm!=$password){
            $error_message['password_confirm']='パスワードが不一致です。';
            $has_error=true;
        }
        if ($telephone==''){
            $error_message['telephone']='電話番号の入力が必要です。';
            $has_error=true;
        }
        if ($postcode==''){
            $error_message['postcode']='郵便番号の入力が必要です。';
            $has_error=true;
        }
        if ($prefecture==''){
            $error_message['prefecture']='都道府県の入力が必要です。';
            $has_error=true;
        }
        if ($city==''){
            $error_message['city']='市区町村の入力が必要です。';
            $has_error=true;
        }
        if ($address==''){
            $error_message['address']='住所の入力が必要です。';
            $has_error=true;
        }
        if ($name==''){
            $error_message['name']='名前の入力が必要です。';
            $has_error=true;
        }
        $request->flash();
        if($has_error){
            $request->session()->flash('error_message',$error_message);
            return redirect('/register');
        }

        $user= New User;
        $user->email= $email;
        $hashed_password= hash::make($password);
        $user->password= $hashed_password;
        $user->postcode=$postcode;
        $user->prefecture=$prefecture;
        $user->city=$city;
        $user->tel=$telephone;
        $user->name=$name;
        $user->address=$address;
        $user->save();

        $request->session()->put('register-user',$user);
        return redirect('/register-success');


}

public function registerSuccess(Request $request){
        $user=$request->session()->get('register-user');

        return view('register_success', [
                'email'=>$user->email,
                'password'=>$user->password,
                'postcode'=>$user->postcode,
                'prefecture'=>$user->prefecture,
                'city'=>$user->city,
                'telephone'=>$user->tel,
                'name'=>$user->name,
                'address'=>$user->address,








            ]






        );

    }

public function login(Request $request){
        if ($request->method()=='POST'){
            $email=$request->post('email');
            $password=$request->post('password');
            if(Auth::attempt(['email'=>$email,'password'=>$password])){
                return redirect('/top');

            }else{
                $request->session()->put('error_message',true);
                return redirect('/login');
            }


//            $user= User::where('email', $email)->first();
//            if (isset($user) && $user->password==$password){
//                return redirect('/top');
//            }else{
//                $request->session()->put('error_message',true);
//                return redirect('/login');
//            }
        }

        $error_message=$request->session()->get('error_message');
        $request->session()->forget('error_message');

        return view('login',[
            'error_message'=>$error_message
        ]);

    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/login');

    }

    public function userUpdate(Request $request){
        if(Auth::check()){
            $user=Auth::user();


            return view('user_update',[
                'email'=>$user->email,
                'password'=>$user->password,
                'postcode'=>$user->postcode,
                'prefecture'=>$user->prefecture,
                'city'=>$user->city,
                'tel'=>$user->tel,
                'name'=>$user->name,
                'address'=>$user->address,
                'id'=>$user->id,

            ]);
        }else{
            return redirect('/login');
        }
    }

    public function emailUpdate(Request $request){
        if($request->isMethod('POST')){
            $request->validate(['email'=>'required|unique:users,email']);
            $new_email=$request->post('email');
            $user=Auth::user();
//            $old_email=$user->email;
            $id=Auth::id();
//            $has_error=false;
//            $email_db=User::all(["email"]);



//            if($new_email==null) {
//                $error_msg = 'メールアドレスを入力してください。';
//                return view('update.email_update', ['error_msg' => $error_msg]);
//
//
//            } elseif($new_email==$old_email){
//                $error_msg='異なるメールアドレスを入力してください。';
//                return view('update.email_update', ['error_msg' => $error_msg]);
//
//
//            }
//
//            else{

                //DB::table('users')->where('id',$id)->update(['email'=>$new_email]);

            $user = User::find($id);
            $user->email = $new_email;
            $user->save();

                $error_msg='＊メールアドレスの変更が成功しました！';
                return view('update.email_update',['error_msg'=>$error_msg]);
//            }
        }


        return view('update.email_update');

    }



    public function passwordUpdate(Request $request){
        if($request->isMethod('POST')){
            $request->validate(['password'=>'required']);
            $new_password=$request->post('password');
            $id=Auth::id();
            DB::table('users')->where('id',$id)->update(['password'=>hash::make($new_password)]);
            $error_msg='＊パスワードの変更が成功しました！';
            return view('update.password_update',['error_msg'=>$error_msg]);
        }
        return view('update.password_update');

    }

    public function postcodeUpdate(Request $request){
        if($request->isMethod('POST')){
            $request->validate(['postcode'=>'required']);
            $new_postcode=$request->post('postcode');
            $id=Auth::id();
            DB::table('users')->where('id',$id)->update(['postcode'=>$new_postcode]);
            $error_msg='＊郵便番号の変更が成功しました！';
            return view('update.postcode_update',['error_msg'=>$error_msg]);
        }
        return view('update.postcode_update');

    }

    public function prefectureUpdate(Request $request){
        if($request->isMethod('POST')){
            $request->validate(['prefecture'=>'required']);
            $new_prefecture=$request->post('prefecture');
            $id=Auth::id();
            DB::table('users')->where('id',$id)->update(['prefecture'=>$new_prefecture]);
            $error_msg='＊都道府県の変更が成功しました！';
            return view('update.prefecture_update',['error_msg'=>$error_msg]);
        }
        return view('update.prefecture_update');


    }

    public function cityUpdate(Request $request){
        if($request->isMethod('POST')){
            $request->validate(['city'=>'required']);
            $new_city=$request->post('city');
            $id=Auth::id();
            DB::table('users')->where('id',$id)->update(['city'=>$new_city]);
            $error_msg='＊市区町村の変更が成功しました！';
            return view('update.city_update',['error_msg'=>$error_msg]);
        }
        return view('update.city_update');

    }

    public function telUpdate(Request $request){
        if($request->isMethod('POST')){
            $request->validate(['tel'=>'required']);
            $new_tel=$request->post('tel');
            $id=Auth::id();
            DB::table('users')->where('id',$id)->update(['tel'=>$new_tel]);
            $error_msg='＊電話番号の変更が成功しました！';
            return view('update.tel_update',['error_msg'=>$error_msg]);
        }
        return view('update.tel_update');

    }

    public function nameUpdate(Request $request){
        if($request->isMethod('POST')){
            $request->validate(['name'=>'required']);
            $new_name=$request->post('name');
            $id=Auth::id();
            DB::table('users')->where('id',$id)->update(['name'=>$new_name]);
            $error_msg='＊名前の変更が成功しました！';
            return view('update.name_update',['error_msg'=>$error_msg]);
        }
        return view('update.name_update');

    }

    public function addressUpdate(Request $request){
        if($request->isMethod('POST')){
            $request->validate(['address'=>'required']);
            $new_address=$request->post('address');
            $id=Auth::id();
            DB::table('users')->where('id',$id)->update(['address'=>$new_address]);
            $error_msg='＊住所の変更が成功しました！';
            return view('update.address_update',['error_msg'=>$error_msg]);
        }
        return view('update.address_update');

    }








public function userList(Request $request){

//        查询所有数据
//        $user=User::all();
//        foreach($user as $u){
//            echo  $u->name;
//            echo '<br>';
//            echo  $u->email;
//            echo '<br>';
//        }
//    增加一条新数据
    $user=new User;
    $user->email='555@qq.com';
    $user->name='555';
    $user->password='111';
    $user->save();

}

public function bentoManage(Request $request){
        $id=Auth::id();
        $bentos=DB::table('bentos')->where('user_id',$id)->get();

        return view('bento_manage',[
            'bentos'=>$bentos
        ]);



}

public function bentoAdd(Request $request){
        $user_ids=DB::table('users')->pluck('id');

        return view('bento.bento_add',[
            'user_ids'=>$user_ids,
        ]);
}

public function bentoAddSuccess(Request $request){
    $request->validate(['bento_name'=>'required','price'=>'required',
        'bento_code'=>'required|unique:bentos,bento_code','guarantee_period'=>
            'required','stock'=>'required','user_id'=>'required']);
    $bento_name=$request->post('bento_name');
    $price=$request->post('price');
    $bento_code=$request->post('bento_code');
    $description=$request->post('description');
    $guarantee_period=$request->post('guarantee_period');
    $stock=$request->post('stock');
    $user_id=$request->post('user_id');
    //dd($guarantee_period);
    DB::table('bentos')->insert(['bento_name'=>$bento_name,'price'=>$price,'bento_code'=>$bento_code,
        'description'=>$description,'guarantee_period'=>$guarantee_period,'stock'=>$stock,'user_id'=>$user_id,]);

    return view('bento.bento_add_success',
        ['bento_name'=>$bento_name,
        'price'=>$price,
        'bento_code'=>$bento_code,
        'description'=>$description,
        'guarantee_period'=>$guarantee_period,
        'stock'=>$stock,
        'user_id'=>$user_id]);
}

public function bentoUpdate(Request $request){
        $user_ids=DB::table('users')->pluck('id');
        $bento_id=$request->post('id');
        $bento_name=$request->post('bento_name');
        $price=$request->post('price');
        $bento_code=$request->post('bento_code');
        $description=$request->post('description');
        $guarantee_period=$request->post('guarantee_period');
        $stock=$request->post('stock');
        $user_id=$request->post('user_id');
        return view('bento.bento_update',
            ['bento_id'=>$bento_id,
                'bento_name'=>$bento_name,
                'price'=>$price,
                'bento_code'=>$bento_code,
                'description'=>$description,
                'guarantee_period'=>$guarantee_period,
                'stock'=>$stock,
                'user_id'=>$user_id,
                'user_ids'=>$user_ids,

            ]);
}

public function bentoUpdateSuccess(Request $request){
    $request->validate(['bento_code'=>'unique:bentos,bento_code']);
    $bento_id=$request->post('id');
    $bento_name=$request->post('bento_name');
    $price=$request->post('price');
    $bento_code=$request->post('bento_code');
    $description=$request->post('description');
    $guarantee_period=$request->post('guarantee_period');
    $stock=$request->post('stock');
    $user_id=$request->post('user_id');
    $bento=DB::table('bentos')->where('id',$bento_id)->first();

    if($bento_name==null){
        $bento_name=$bento->bento_name;
    }
    if($price==null){
        $price=$bento->price;
    }
    if($bento_code==null){
        $bento_code=$bento->bento_code;
    }
    if($description==null){
        $description=$bento->description;
    }
    if($guarantee_period==null){
        $guarantee_period=$bento->guarantee_period;
    }
    if($stock==null){
        $stock=$bento->stock;
    }
    if($user_id==null){
        $user_id=$bento->user_id;
    }
    DB::table('bentos')->where('id',$bento_id)->update(['bento_name'=>$bento_name,'price'=>$price,'bento_code'=>$bento_code,
        'description'=>$description,'guarantee_period'=>$guarantee_period,'stock'=>$stock,'user_id'=>$user_id,]);

        return view('bento.bento_update_success',[
            'bento_name'=>$bento_name,
            'price'=>$price,
            'bento_code'=>$bento_code,
            'description'=>$description,
            'guarantee_period'=>$guarantee_period,
            'stock'=>$stock,
            'user_id'=>$user_id]);
}

public function bentoDelete(Request $request){
        $bento_id=$request->post('id');
        DB::table('bentos')->where('id',$bento_id)->delete();
        return view('bento.bento_delete');
}

public function usersDelete(Request $request){
    $user_ids=DB::table('users')->pluck('id');
    $error_message=null;
    return view('users-delete',[
        'user_ids'=>$user_ids,
        'error_message'=>$error_message,
        ]
    );
}

public function usersDeleteAction(Request $request){
        $user_id=$request->post('id');
        //$user=DB::table('users')->where('id',$user_id)->first();
        $user = User::find($user_id);
        if($user->postcode==null){
            $postcode='無';
        }else{
            $postcode=$user->postcode;
        }
        if($user->prefecture==null){
            $prefecture='無';
        }else{
            $prefecture=$user->prefecture;
        }
        if($user->city==null){
            $city='無';
        }else{
            $city=$user->city;
        }
        if($user->tel==null){
            $tel='無';
        }else{
            $tel=$user->tel;
        }
        if($user->address==null){
            $address='無';
        }else{
            $address=$user->address;

        }
        $email=$user->email;
        $password=$user->password;
        $name=$user->name;


        return view('users_delete_action',[
            'id'=>$user_id,
            'email'=>$email,
            'password'=>$password,
            'postcode'=>$postcode,
            'prefecture'=>$prefecture,
            'city'=>$city,
            'tel'=>$tel,
            'name'=>$name,
            'address'=>$address

        ]);
}

public function usersDeleteSuccess(Request $request){
        /**
        $user_ids=DB::table('bentos')->pluck('user_id');
        foreach($user_ids as $user_id){
            if($user_id==$request->post('id')){
                return view('users_delete_fail');

            }
        }
         */

        /**
        $bento = Bento::where('user_id', $request->post('id'))->first();
        if ($bento != null) {
            return view('users_delete_fail');
        }
         */
    $bento = Bento::where('user_id', $request->post('id'))->get();
    $bento = $bento->toArray();
    if (count($bento) > 0) {
        return view('users_delete_fail');
    }

        DB::table('users')->where('id',$request->post('id'))->delete();
        return view('users_delete_success');
}

public function bentoBuyTop(Request $request){
        $user_id=Auth::id();
        $bentos=DB::table('bentos')->whereNotIn('user_id',[$user_id])->get();

        return view ('bento_buy.bento_buy_top',[
            'bentos'=>$bentos
        ]);
}

public function bentoBuyConfirm(Request $request){
        $quantity=$request->post('quantity');
        $bento_id=$request->post('bento_id');
        $bento=DB::table('bentos')->where('id',$bento_id)->first();
        return view('bento_buy.bento_buy_confirm',[
            'quantity'=>$quantity,
            'bento'=>$bento,
            ]);
}

public function bentoBuySuccess(Request $request){
        $quantity=$request->post('quantity');
        $bento_id=$request->post('bento_id');
        $stock=$request->post('stock');
        DB::table('bentos')->where('id',$bento_id)->update(['stock'=>$stock-$quantity]);
        return view('bento_buy.bento_buy_success');
}




}
