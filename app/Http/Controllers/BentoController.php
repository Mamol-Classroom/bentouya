<?php

namespace App\Http\Controllers;

use App\Models\Bento;
use App\Models\Favourite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BentoController extends Controller
{
    public function index(Request $request)
    {
        //通过laravel中的中间件->middleware('auth')来挡住未登录时的页面跳转
        //if(!Auth::check()){
         //   return redirect('login');
         //}

        //找回软删除信息用withoutTrashed()
        //$bento = Bento::withoutTrashed()->find(bento_id);
        //$bento->restore();

        $user = Auth::user();
        $user_id = Auth::id();
        $bentos = Bento::where('user_id', $user_id)->get();


        return view('bento.index',['bentos' => $bentos]);

    }

    public function detail(Request $request,$bento_id)
    {
       //直接通过路由传参数
       // $bento_id = $request->query('id');
        $bento = Bento::find($bento_id);

        return view('bento.detail',[
        'bento_name' => $bento->bento_name,
        'price' => $bento->price,
        'bento_code' => $bento->bento_code,
        'guarantee_period' => $bento->guarantee_period,
        'description' => $bento->description,
            ]);
    }
//return redirect('/bento/detail?bento_id='.$bento_id);





    public function add(Request $request)
    {
        if($request->method() ==='POST')
        {
            $bento_name = $request->post('bento_name');
            $price = $request->post('price');
            $description = $request->post('description');
            $guarantee_period = $request->post('guarantee_period');
            $stock = $request->post('stock');

            //出现错误信息保留正确信息用

            $data = [
                'bento_name' => $bento_name,
                'price' => $price,
                'description' => $description,
                'guarantee_period' => $guarantee_period,
                'stock' => $stock,

            ];


            $has_error = false;
           //装错误信息
            $error_message = [
                'bento_name' => null,
                'price' => null,
                'description' => null,
                'guarantee_period' => null,
                'stock' => null,

            ];

            $label_name =[
                'bento_name' => '弁当名',
                'price' => '価格',
                'description' => '説明',
                'guarantee_period' =>'賞味期限',
                'stock' => '在庫数',
            ];

            foreach($data as $key =>$value )
            {
                if($value ==''){
                    $error_message[$key] =$label_name[$key].'を入力してください';
                    $has_error = true;
                }
            }

            if ($has_error) {
                $request->session()->put('bento.error_message', $error_message);
                $request->session()->put('bento.data', $data);

                return redirect('/bento/add');
            }
            $bento= new Bento();
            $bento->bento_name = $bento_name;
            $bento->price = $price;
            $bento->description = $description;
            $bento->guarantee_period = $guarantee_period;
            $bento->stock = $stock;

            $bento_code_data = $this->generateBentoCode($guarantee_period);
            $bento_code = $bento_code_data['bento_code'];
            $exist_bento = $bento_code_data['exist_bento'];

            while ($exist_bento != null) {
                $bento_code_data = $this->generateBentoCode($guarantee_period);
                $bento_code = $bento_code_data['bento_code'];
                $exist_bento = $bento_code_data['exist_bento'];
            }
            $bento->bento_code = $bento_code;

            $bento->user_id = Auth::id();

            $bento->save();

            $request->session()->flash('bento.add',$bento);


            return redirect('/bento/add/complete');



        }

        $error_message = $request->session()->get('bento.error_message');
        $data = $request->session()->get('bento.data');

        $request->session()->forget('bento.error_message');
        $request->session()->forget('bento.data');

        if ($error_message == null) {
            $error_message = [
                'bento_name' => null,
                'price' => null,
                'description' => null,
                'guarantee_period' => null,
                'stock' => null,
            ];
        }

        if ($data == null) {
            $data = [
                'bento_name' => null,
                'price' => null,
                'description' => null,
                'guarantee_period' => null,
                'stock' => null,
            ];
        }

        return view('bento.add', [
            'error_message' => $error_message,
            'data' => $data
        ]);
    }


    public function addComplete(Request $request)
    {
        $request->session()->keep('bento.add');
        $bento = $request->session()->get('bento.add');

        if($bento == null)
        {
            throw new NotFoundHttpException();

        }

        return view('bento.add_complete',[
            'bento_name' => $bento->bento_name,
            'price' => $bento->price,
            'bento_code' => $bento->bento_code,
            'description' => $bento->description,
            'guarantee_period' => $bento->guarantee_period,
            'stock' => $bento->stock,
            ]);
    }

    public function delete(Request $request)
    {
        $bento_id = $request->post('bento_id');
        $bento = Bento::find($bento_id);

        if($bento ==null ||$bento->user_id != Auth::id())
        {
            throw new NotFoundHttpException();
        }

        $bento->delete();

        return redirect('/bentos');

    }



    protected function generateBentoCode($guarantee_period)
    {
        //找随机数
        $random_num = rand(0, 9999999999);
        //判断几位
        $random_num_length = strlen((string)$random_num);
        //补0
        $zero_count = 10 - $random_num_length;
        $zero_string = '';
        for ($i = 0; $i < $zero_count; $i++) {
            $zero_string = $zero_string.'0';
        }
        //随机数与0相连接
        $random_num = $zero_string.$random_num;
        // get random num end 格式
        $bento_code = 'B'.$random_num.'-'.Carbon::now()->format('Ymd').'-'.str_replace('-', '', $guarantee_period);
        //判断是否唯一
        $exist_bento = Bento::where('bento_code', $bento_code)->first();

        return [
            'bento_code' => $bento_code,
            'exist_bento' => $exist_bento
        ];
    }



    public function update(Request $request)
    {
        $bento_id = $request->query('bento_id');
        $bento = Bento::find($bento_id);

        if($bento ==null ||$bento->user_id != Auth::id())
        {
            throw new NotFoundHttpException();
        }

        $error_message = $request->session()->get('bento.update.error_message');
        $data = $request->session()->get('bento.update.data');

        $request->session()->forget('bento.update.error_message');
        $request->session()->forget('bento.update.data');

        if ($error_message == null) {
            $error_message = [
                'bento_name' => null,
                'price' => null,
                'description' => null,
                'guarantee_period' => null,
                'stock' => null,
            ];
        }

        if ($data == null) {
            $data = [
                'bento_name' => $bento->bento_name,
                'price' => $bento->price,
                'description' => $bento->description,
                'guarantee_period' => $bento->guarantee_period,
                'stock' => $bento->stock,

            ];
        }

        //装错误信息
        $has_error = false;

        if($request->method() ==='POST'){
            $bento_name = $request->post('bento_name');
            $price = $request->post('price');
            $description = $request->post('description');
            $guarantee_period = $request->post('guarantee_period');
            $stock = $request->post('stock');


            $data = [
                'bento_name' => $bento_name,
                'price' => $price,
                'description' => $description,
                'guarantee_period' => $guarantee_period,
                'stock' => $stock,
                ];


            $label_name =[
                'bento_name' => '弁当名',
                'price' => '価格',
                'description' => '説明',
                'guarantee_period' =>'賞味期限',
                'stock' => '在庫数',
            ];

            foreach($data as $key =>$value )
            {
                if($value ==''){
                    $error_message[$key] =$label_name[$key].'を入力してください';
                    $has_error = true;
                }
                if($key === 'price'){
                    if($value < 100){
                        $error_message[$key] = '入力する金額の最小限は100円となります。';
                        $has_error = true;
                    }
                    if($value > 3000){
                        $error_message[$key] = '入力する金額の最大限は3000円となります。';
                        $has_error = true;

                    }
                }
            }

            if ($has_error) {
                $request->session()->put('bento.update.error_message', $error_message);
                $request->session()->put('bento.update.data', $data);

                return redirect('/bento/update?bento_id='.$bento_id);
            }

            //将输入的信息修改数据库
            $bento->bento_name = $bento_name;
            $bento->price = $price;
            $bento->description = $description;
            $bento->guarantee_period = $guarantee_period;
            $bento->stock = $stock;

            $bento->save();



            return redirect('/bento/update?bento_id='.$bento_id);


        }

        return view('bento.update',[
            'bento_id' => $bento_id,
            'data' => $data,
            'error_message' => $error_message,
        ]);
    }



    public function addFavourite(Request $request)
    {
        $bento_id = $request->post('bento_id');
        $user_id = Auth::id();

        // 該当弁当が存在するかどうかを確認する
        $bento_exist = Bento::find($bento_id);
        if ($bento_exist == null) {
            // 报错
            return response()->json(['result' => 'fail']);
        }

        $favourite = Favourite::where('user_id', $user_id)
            ->where('bento_id', $bento_id)
            ->first();

        if ($favourite == null) {
            $favourite = new Favourite();
            $favourite->bento_id = $bento_id;
            $favourite->user_id = $user_id;
            $favourite->save();

            // 给前台反馈
            // 通过Ajax请求的路由，返回response()->json(PHP数组)
            return response()->json(['result' => 'add']);
        } else {
            $favourite->delete();

            // 给前台反馈
            // 通过Ajax请求的路由，返回response()->json(PHP数组)
            return response()->json(['result' => 'delete']);
        }
    }










}
