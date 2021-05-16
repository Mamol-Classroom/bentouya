<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Bento;
use App\Models\BentoImage;
use App\Models\Favourite;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Carbon;  //laravel自带日期生成

use Illuminate\Support\Facades\Auth;  //认证

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;  //跳转到404不存在页面

class BentoController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::id();
        $bentos = Bento::where('user_id', $user_id)->get();

        //テスト:确认是否取值成功
        //$bento_id = $bentos[0]->id;
        //dump($bentos[0]->get_bento_image_url());exit;   在Bento的Model里书写

        return view('bento.index', ['bentos' => $bentos]); //跳转到的页面名而不是route
    }

    public function detail(Request $request, $bento_id)
    {
        //$bento_id = $request->query('id');
        $bento = Bento::find($bento_id);

        return view('bento.detail', [
            'bento_name' => $bento->bento_name,
            'price' => $bento->price,
            'bento_code' => $bento->bento_code,
            'guarantee_period' => $bento->guarantee_period,
            'description' => $bento->description,
        ]);
    }

    public function add(Request $request)
    {
        if ($request->method() === 'POST') {
            $bento_name = $request->post('bento_name');
            $price = $request->post('price');
            $description = $request->post('description');
            $stock = $request->post('stock');
            $guarantee_period = $request->post('guarantee_period');

            $bento_img = $request->file('bento_img');  //检索已上传文件使用file方法
            //dump($bento_img->extension());exit;

            $data = [
                'bento_name' => $bento_name,
                'price' => $price,
                'description' => $description,
                'stock' => $stock,
                'guarantee_period' => $guarantee_period,
            ];

            $has_error = false;
            $error_message = [
                'bento_name' => null,
                'price' => null,
                'description' => null,
                'stock' => null,
                'guarantee_period' => null,
            ];

            $label_name = [
                'bento_name' => '弁当名',
                'price' => '価格',
                'description' => '説明',
                'stock' => '在庫数',
                'guarantee_period' => '賞味期限',
            ];

            foreach ($data as $key => $value) {   //判断用户输入信息是否正确
                if ($value == '') {

                    $error_message[$key] = '请输入'.$label_name[$key];
                    $has_error = true;

                }

                if ($key === 'price') {            //设定便当价格区间
                    if ($value < 100) {
                        $error_message[$key] = '价格不能低于100';
                        $has_error = true;
                    }
                    if ($value > 2000) {
                        $error_message[$key] = '价格不能高于2000';
                        $has_error = true;
                    }
                }
            }

            if ($has_error) {
                $request->session()->put('bento.error_message', $error_message);
                $request->session()->put('bento.data', $data);

                return redirect('/bento/add');
            }

            // 将输入的数据存入数据库
            $bento = new Bento();
            $bento->bento_name = $bento_name;
            $bento->price = $price;
            $bento->description = $description;
            $bento->guarantee_period = $guarantee_period;
            $bento->stock = $stock;

            $bento_code_data = $this->generateBentoCode($guarantee_period);   //在自动生成便当code函数内提取
            $bento_code = $bento_code_data['bento_code'];                     //自动生成的便当code
            $exist_bento = $bento_code_data['exist_bento'];                   //确认是否存在（为了不重复）该便当code

            while ($exist_bento != null) {                                    //如果已经存在该便当code，则重新生成
                $bento_code_data = $this->generateBentoCode($guarantee_period);
                $bento_code = $bento_code_data['bento_code'];
                $exist_bento = $bento_code_data['exist_bento'];
            }
            $bento->bento_code = $bento_code;
            //$bento->deleted_flag = 0;    这部分改用为：deleted_at字段来判断/使用laravel自带的SoftDeletes->Bento的Models

            $bento->user_id = Auth::id();         //先找到登录者id再保存

            $bento->save();

            //将上传的便当图片存储至服务器；和bento数据分别存储(因为bento数据库内没有bento_image字段，而是重新建立一个bentos_images的数据库);并且在这里需要读取已经存储过的$bento->id
            $bento_img_name = $bento->bento_name.'.'.$bento_img->extension();  //便当名.文件扩展名extension
            //$bento_img->getClientOriginalName();  //取得上传文件原来的命名
            //$bento_img->extension();  //取得上传文件的扩展名
            //$bento_img->store('bento_imgs/'.$bento->id);  //随机生成文件名:此时是在默认的storage/app文件夹下生成
            $bento_img->storeAs('public/bento_imgs/'.$bento->id,$bento_img_name);  //在storage/app/public文件夹中建立bento_images文件夹再根据bento->id创建文件夹;由于框架设置了gitignore，会导致无法访问
            //将public/storage文件夹和storage/app/public做关联，使客户端可以识别：php artisan storage：link

            //将便当图片的数据存入数据库
            $bento_image = new BentoImage();
            $bento_image->bento_id = $bento->id;
            $bento_image->image_url = 'bento_imgs/'.$bento->id.'/'.$bento_img_name; //即图片保存路径
            $bento_image->save();

            $request->session()->flash('bento.add', $bento);    //闪存，只保存一次请求

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
        $bento = $request->session()->get('bento.add');    //接收上一个flash
        $request->session()->keep('bento.add');           //或者reflash二次闪存所有信息

        if ($bento == null) {
            // 跳转到404 Not Found
            throw new NotFoundHttpException();
        }

        return view('bento.add-complete', [
            'bento_name' => $bento->bento_name,
            'price' => $bento->price,
            'bento_code' => $bento->bento_code,
            'description' => $bento->description,
            'guarantee_period' => $bento->guarantee_period,
            'stock' => $bento->stock,
        ]);
    }

    public function delete(Request $request)   //取值的方法取决于传值的形式
    {
        $bento_id = $request->post('bento_id');
        $bento = Bento::find($bento_id);

        if ($bento == null || $bento->user_id != Auth::id()) {
            throw new NotFoundHttpException();
        }

        $bento->delete();  // hard delete
        //这里使用了laravel自带的SoftDeletes->Bento的Models

        // soft delete   ->手动
        // $bento->deleted_flag = 1;
        // $bento->save();

        return redirect('/bentos');
    }

    protected function generateBentoCode($guarantee_period)  //自动生成便当code
    {
        $random_num = rand(0, 9999999999);                 //rand：生成十位随机数
        $random_num_length = strlen((string)$random_num);  //(string):强制转化为文字；strlen:取得字符串长度
        $zero_count = 10 - $random_num_length;             //用0补足十位数空缺
        $zero_string = '';
        for ($i = 0; $i < $zero_count; $i++) {             //将补位0依次插入
            $zero_string = $zero_string.'0';
        }
        $random_num = $zero_string.$random_num;
        // get random num end
        $bento_code = 'B'.$random_num.'-'.Carbon::now()->format('Ymd').'-'.str_replace('-', '', $guarantee_period);
                                    //laravel自带class，生成时间->格式format为：Ymd年月日  /  更改格式：'去除部分'，'更换部分'，'更换对象'
        $exist_bento = Bento::where('bento_code', $bento_code)->first();

        return [
            'bento_code' => $bento_code,   //自动生成的便当code
            'exist_bento' => $exist_bento  //确定是否已存在该便当code
        ];
    }

    public function update(Request $request)
    {
        $bento_id = $request->query('bento_id');
        $bento = Bento::find($bento_id);

        if ($bento == null || $bento->user_id != Auth::id()) {
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
                'stock' => $bento->stock,
                'guarantee_period' => $bento->guarantee_period,
            ];
        }

        $has_error = false;

        if ($request->method() === 'POST') {
            $bento_name = $request->post('bento_name');
            $price = $request->post('price');
            $description = $request->post('description');
            $stock = $request->post('stock');
            $guarantee_period = $request->post('guarantee_period');

            $data = [
                'bento_name' => $bento_name,
                'price' => $price,
                'description' => $description,
                'stock' => $stock,
                'guarantee_period' => $guarantee_period,
            ];

            $label_name = [
                'bento_name' => '弁当名',
                'price' => '価格',
                'description' => '説明',
                'stock' => '在庫数',
                'guarantee_period' => '賞味期限',
            ];

            foreach ($data as $key => $value) {

                if($key === 'description'){     //商品说明可以为空，避免报错

                    continue;
                }
                if ($value == '') {
                    $error_message[$key] = '请输入'.$label_name[$key];
                    $has_error = true;
                }
                if ($key === 'price') {            //设定便当价格区间
                    if ($value < 100) {
                        $error_message[$key] = '价格不能低于100';
                        $has_error = true;
                    }
                    if ($value > 2000) {
                        $error_message[$key] = '价格不能高于2000';
                        $has_error = true;
                    }
                }
            }

            if ($has_error) {
                $request->session()->put('bento.update.error_message', $error_message);
                $request->session()->put('bento.update.data', $data);

                return redirect('/bento/update?bento_id='.$bento_id);
            }

            // 将输入的数据修改数据库
            $bento->bento_name = $bento_name;
            $bento->price = $price;
            $bento->description = $description;
            $bento->guarantee_period = $guarantee_period;
            $bento->stock = $stock;
            $bento->save();

            return redirect('/bento/update?bento_id='.$bento_id);
        }

        return view('bento.update', [
            'bento_id' => $bento_id,
            'data' => $data,
            'error_message' => $error_message
        ]);
    }

    public function addFavourite(Request $request)
    {
        $bento_id = $request->post('bento_id');
        $user_id = Auth::id();  //没有通过js的ajax，而是session，所以不用传值

        // 該当弁当が存在するかどうかを確認する
        $bento_exist = Bento::find($bento_id);
        if ($bento_exist == null) {
            // 报错，使用ajax的函数response
            //另外两种返回值：view渲染模板(post)以及redirect重定向(pet)
            return response()->json(['result' => 'fail']);  //datatype是json;result指script.js里的函数形参下的result
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
            $favourite->delete();    //硬删除

            // 给前台反馈
            // 通过Ajax请求的路由，返回response()->json(PHP数组)
            return response()->json(['result' => 'delete']);
        }
    }
}
