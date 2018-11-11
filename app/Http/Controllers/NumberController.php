<?php

namespace App\Http\Controllers;

use App\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class NumberController extends Controller
{

    public function index(Request $request)
    {
        if (isset($request->search)) {
            $numbers = Number::where("number", $request->search)->orderBy("id", "desc")->paginate(50);
            return view("number.index", [
                'numbers' => $numbers->appends($request->except('page'))
            ]);
        } else {
            $numbers = Number::orderBy("id", "desc")->paginate(50);
            return view("number.index", [
                'numbers' => $numbers->appends($request->except('page'))
            ]);
        }
    }


    public function create()
    {
        return view("number.create");
    }

    public function destroyAll()
    {
        Number::where("id", ">", 0)->delete();
        return Redirect::back()->with("type", "success")->with("message", "Silindi");
    }

    public function store(Request $request)
    {
        set_time_limit(0);

        $errorCnt = 0;
        $templateCnt = 0;

        $firstCnt = Number::count();


        //inputtan gelen list
        $list = $request->input("list");

        // eğer dosya yüklenmiş ise
        if ($request->hasFile("file")) {
            $list = File::get($request->file("file"));
        }

        $seperated = explode("\n", $list);
        $total = count($seperated);

        if ($total > 0) {
            foreach ($seperated as $number) {
                $number = $this->clear($number);

                if($number == "") continue;

                if (strlen($number) != 10) {
                    $templateCnt++;
                    continue;
                }

                $first2 = substr($number, 0, 2);

                if (!($first2 == "53" or $first2 == "54" or $first2 == "55" or $first2 == "50")) {
                    //return $number;
                    $templateCnt++;
                    continue;
                }

                try {
                 //   Number::create(["number" => "0" . $number]);
                    DB::insert("insert into numbers (number) values ('0' . $number)");
                } catch (\Exception $exception) {
                    $errorCnt++;
                }

            }


        }

        $lastCnt = Number::count();

        $net = $lastCnt - $firstCnt;

        return Redirect::route("number.index")->with("type", "success")->with("message", "$total numaradan, $net tanesi eklendi. Aynı Numara: $errorCnt,  Hatalı Numara: $templateCnt");


    }

    private function clear($number)
    {

        $number = trim($number);
        $number = str_replace("\r\n", "", $number);
        $number = str_replace("\n", "", $number);
        $number = str_replace("\n", "", $number);
        $number = str_replace(" ", "", $number);
        $number = str_replace("+90", "", $number);

        if (strlen($number) < 2) return $number;

        if ($number[0] == "0") {
            $number = substr($number, 1, strlen($number));
        }

        return $number;
    }


    public function destroy($id)
    {
        Number::find($id)->delete();
        return Redirect::back()->with("type", "success")->with("message", "Silindi");
    }


    public function export()
    {
        $date = date("d-m-Y_H-i-s");

        Number::chunk(1000, function ($numbers) use ($date) {
            foreach ($numbers as $number) {
                $data = $number->number;
                file_put_contents(public_path() .  "/data_$date.txt", $data . "\n", FILE_APPEND);
            }
        });

        $headers = array(
            'Content-Type: text/plain',
        );

        return response()->download(public_path() .  "/data_$date.txt", "data_$date.txt", $headers);
    }

}
