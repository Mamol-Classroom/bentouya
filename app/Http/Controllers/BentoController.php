<?php

namespace App\Http\Controllers;

use App\Models\Bento;
use App\Models\Favourite;
use App\Models\BentosImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BentoController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::id();
        $bentos = Bento::where('user_id', $user_id)->get();

        // ใในใ
//        $bento_id = $bentos[0]->id;
//        dump($bentos[0]->get_bento_image_url());exit;

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
            $bento_img = $request->file('bento_img');
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
                'bento_name' => 'ๅผๅฝๅ',
                'price' => 'ไพกๆ?ผ',
                'description' => '่ชฌๆ',
                'stock' => 'ๅจๅบซๆฐ',
                'guarantee_period' => '่ณๅณๆ้',
            ];

            foreach ($data as $key => $value) {
                if ($value == '') {
                    $error_message[$key] = '่ฏท่พๅฅ'.$label_name[$key];
                    $has_error = true;
                }
            }

            if ($has_error) {
                $request->session()->put('bento.error_message', $error_message);
                $request->session()->put('bento.data', $data);

                return redirect('/bento/add');
            }

            // ๅฐ่พๅฅ็ๆฐๆฎๅญๅฅๆฐๆฎๅบ
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

            $bento->user_id = Auth::id();

            $bento->save();

            // ๅฐไธไผ?็ๅพ็ๅญๅจ่ณๆๅกๅจ
            $bento_img_name = $bento->bento_name.'.'.$bento_img->extension();
            //$bento_img->getClientOriginalName();  // ๅๅพไธไผ?็ๆไปถๅๆฅ็ๅๅญ
            //$bento_img->extension();  // ๅๅพไธไผ?็ๆไปถ็ๆฉๅฑๅ
            //$bento_img->store('bento_imgs/'.$bento->id);  // ้ๆบ็ๆๆไปถๅ
            $bento_img->storeAs('public/bento_imgs/'.$bento->id, $bento_img_name);

            // ๅฐๅพ็็ๆฐๆฎๅญๅฅๆฐๆฎๅบ
            $bento_image = new BentosImage();
            $bento_image->bento_id = $bento->id;
            $bento_image->image_url = 'bento_imgs/'.$bento->id.'/'.$bento_img_name;
            $bento_image->save();

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
            // ่ทณ่ฝฌๅฐ404 Not Found
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
                'bento_name' => 'ๅผๅฝๅ',
                'price' => 'ไพกๆ?ผ',
                'description' => '่ชฌๆ',
                'stock' => 'ๅจๅบซๆฐ',
                'guarantee_period' => '่ณๅณๆ้',
            ];

            foreach ($data as $key => $value) {
                if ($key === 'description') {
                    continue;
                }
                if ($value == '') {
                    $error_message[$key] = '่ฏท่พๅฅ'.$label_name[$key];
                    $has_error = true;
                }
                if ($key === 'price') {
                    if ($value < 100) {
                        $error_message[$key] = 'ไปทๆ?ผไธ่ฝไฝไบ100';
                        $has_error = true;
                    }
                    if ($value > 2000) {
                        $error_message[$key] = 'ไปทๆ?ผไธ่ฝ้ซไบ2000';
                        $has_error = true;
                    }
                }
            }

            if ($has_error) {
                $request->session()->put('bento.update.error_message', $error_message);
                $request->session()->put('bento.update.data', $data);

                return redirect('/bento/update?bento_id='.$bento_id);
            }

            // ๅฐ่พๅฅ็ๆฐๆฎไฟฎๆนๆฐๆฎๅบ
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

        // ่ฉฒๅฝๅผๅฝใๅญๅจใใใใฉใใใ็ขบ่ชใใ
        $bento_exist = Bento::find($bento_id);
        if ($bento_exist == null) {
            // ๆฅ้
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

            // ็ปๅๅฐๅ้ฆ
            // ้่ฟAjax่ฏทๆฑ็่ทฏ็ฑ๏ผ่ฟๅresponse()->json(PHPๆฐ็ป)
            return response()->json(['result' => 'add']);
        } else {
            $favourite->delete();

            // ็ปๅๅฐๅ้ฆ
            // ้่ฟAjax่ฏทๆฑ็่ทฏ็ฑ๏ผ่ฟๅresponse()->json(PHPๆฐ็ป)
            return response()->json(['result' => 'delete']);
        }
    }
}
