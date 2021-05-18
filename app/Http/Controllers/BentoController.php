<?php

namespace App\Http\Controllers;
use App\Models\Bento;
use App\Models\Favourite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Models\BentosImage;
class BentoController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::id();
        $bentos = Bento::where('user_id', $user_id)->get();

        return view('bento.index', ['bentos' => $bentos]);
    }

    public function detail(Request $request, $bento_id)
    {
        //$bento_id = $request->query('id');
        $bento = Bento::find($bento_id);
        $bento_image_url = $bento->get_bento_image_url();

        return view('bento.detail', [
            'bento_id' => $bento->id,
            'bento_name' => $bento->bento_name,
            'price' => $bento->price,
            'bento_code' => $bento->bento_code,
            'guarantee_period' => $bento->guarantee_period,
            'description' => $bento->description,
            'bento_stock' => $bento->stock,
            'bento_image_url' => $bento_image_url
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
            $bento_image = $request->file('bento_image');
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

            foreach ($data as $key => $value) {
                if ($value == '') {
                    $error_message[$key] = '请输入'.$label_name[$key];
                    $has_error = true;
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

            $bento_code_data = $this->generateBentoCode($guarantee_period);
            $bento_code = $bento_code_data['bento_code'];
            $exist_bento = $bento_code_data['exist_bento'];

            while ($exist_bento != null) {
                $bento_code_data = $this->generateBentoCode($guarantee_period);
                $bento_code = $bento_code_data['bento_code'];
                $exist_bento = $bento_code_data['exist_bento'];
            }
            $bento->bento_code = $bento_code;
            //$bento->deleted_flag = 0;

            $bento->user_id = Auth::id();

            $bento->save();

          /*  服了
                if($request->hasFile('bento_image')){
                $bentos_image = new BentosImage();
                $bentos_image->bento_id = $bento->user_id;
                $filePath = $bento_image->store('public');
                $bentos_image->image_url = str_replace('public/', '', $filePath);
                $bentos_image->save();
            }
            */

            $request->session()->flash('bento.add', $bento);

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

    public function delete(Request $request)
    {
        $bento_id = $request->post('bento_id');
        $bento = Bento::find($bento_id);

        if ($bento == null || $bento->user_id != Auth::id()) {
            throw new NotFoundHttpException();
        }

        $bento->delete();  // hard delete

        // soft delete
//        $bento->deleted_flag = 1;
//        $bento->save();

        return redirect('/bentos');
    }

    protected function generateBentoCode($guarantee_period)
    {
        $random_num = rand(0, 9999999999);
        $random_num_length = strlen((string)$random_num);
        $zero_count = 10 - $random_num_length;
        $zero_string = '';
        for ($i = 0; $i < $zero_count; $i++) {
            $zero_string = $zero_string.'0';
        }
        $random_num = $zero_string.$random_num;
        // get random num end
        $bento_code = 'B'.$random_num.'-'.Carbon::now()->format('Ymd').'-'.str_replace('-', '', $guarantee_period);

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
                if ($key === 'description') {
                    continue;
                }
                if ($value == '') {
                    $error_message[$key] = '请输入'.$label_name[$key];
                    $has_error = true;
                }
                if ($key === 'price') {
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

    public function favourite_list()
    {
        //ログインしているユーザーIDの取得
        $user_id = Auth::id();
        $bento_id_list[]= '';
        //ログインしているユーザーIDが注目したデーターの取得(Array)
        $favourites = Favourite::where('user_id',$user_id)->get();
        //Favouriteから弁当IDを取得して、$bento_id_listに追加
        foreach ($favourites as $favourite){
            //該当弁当IDの取得
            $bento_id = $favourite->bento_id;
            $bento_id_list[] = $bento_id;
        }

        //Bentosテーブルから、弁当IDリストに基づいて弁当情報の取得
        $bentos = Bento::whereIn('id',$bento_id_list)->get();
        return view('bento.favourite_list',compact('bentos'));
    }

}
