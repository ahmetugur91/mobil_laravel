<?php

namespace App\Http\Controllers;

use App\Number;
use App\Process;
use App\ProcessNumber;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProcessController extends Controller
{

    public function index()
    {
        $processes = Process::orderBy("id", "desc")->paginate(50);
        return view("process.index", [
            'processes' => $processes
        ]);
    }


    public function create()
    {
        return view("process.create");
    }


    public function store(Request $request)
    {
        Process::create($request->all());
        return Redirect::route("process.index")->with("type", "success")->with("message", "İşlem oluşturuldu");

    }


    public function destroy($id)
    {
        Process::find($id)->delete();
        return Redirect::back()->with("type", "success")->with("message", "Silindi");

    }


    public function processNumber($id)
    {
        $process = Process::findOrFail($id);

        return view("process.processNumber", compact("process"));
    }

    public function processNumberPost(Request $request, $id)
    {
        set_time_limit(0);

        $type = $request->input("type");
        $amount = $request->input("amount");

        if ($type == "rastgele") {
            $numbers = Number::whereNotIn("id", ProcessNumber::where("process_id", $id)->pluck("number_id"))->limit($amount)->pluck("id");
        }

        if ($type == "enaz") {
            $numbers = Number::whereNotIn("id", ProcessNumber::where("process_id", $id)->pluck("number_id"))->orderBy("sended", "asc")->limit($amount)->pluck("id");
        }

        if ($type == "enfazla") {
            $numbers = Number::whereNotIn("id", ProcessNumber::where("process_id", $id)->pluck("number_id"))->orderBy("sended", "desc")->limit($amount)->pluck("id");
        }

        if ($type == "enson") {
            $numbers = Number::whereNotIn("id", ProcessNumber::where("process_id", $id)->pluck("number_id"))->orderBy("id", "desc")->limit($amount)->pluck("id");
        }

        if ($type == "ilk") {
            $numbers = Number::whereNotIn("id", ProcessNumber::where("process_id", $id)->pluck("number_id"))->orderBy("id", "asc")->limit($amount)->pluck("id");
        }


        $list = [];
        foreach ($numbers as $number) {
            $list[] = ["process_id" => $id, "number_id" => $number];
        }

        $count = count($list);

        ProcessNumber::insert($list);

        return Redirect::back()->with("type", "success")->with("message", "$count adet numara eklendi");

    }


    public function processNumberDeletePost(Request $request, $id)
    {
        set_time_limit(0);

        $type = $request->input("type");
        $amount = $request->input("amount");

        if ($type == "rastgele") {
            $numbers = Number::whereIn("id", ProcessNumber::where("process_id", $id)->pluck("number_id"))->limit($amount)->pluck("id");
        }

        if ($type == "enaz") {
            $numbers = Number::whereIn("id", ProcessNumber::where("process_id", $id)->pluck("number_id"))->orderBy("sended", "asc")->limit($amount)->pluck("id");
        }

        if ($type == "enfazla") {
            $numbers = Number::whereIn("id", ProcessNumber::where("process_id", $id)->pluck("number_id"))->orderBy("sended", "desc")->limit($amount)->pluck("id");
        }

        if ($type == "enson") {
            $numbers = Number::whereIn("id", ProcessNumber::where("process_id", $id)->pluck("number_id"))->orderBy("id", "desc")->limit($amount)->pluck("id");
        }

        if ($type == "ilk") {
            $numbers = Number::whereIn("id", ProcessNumber::where("process_id", $id)->pluck("number_id"))->orderBy("id", "asc")->limit($amount)->pluck("id");
        }

        $count = $numbers->count();

        ProcessNumber::where("process_id", $id)->whereIn("number_id", $numbers)->delete();

        return Redirect::back()->with("type", "danger")->with("message", "$count adet numara silindi");

    }

    public function getNumbers($count)
    {
        $process = Process::where("active", 1)->first();

        if (!$process) return ["data" => []];

        try {
            $collection = $process->processNumbers()->where("sent", 0)->limit($count);

            $numbers = $collection->get();

            // -1 , mobil cihaza gönderildi , 1 mesaj gönderildi
            $collection->update(["sent" => -1]);

            // başında 0 olmadan verdiriyorum, mobil tarafında başına 0 koyulacak.
            // data arrayı içinde objeler olarak gönderiliyor.
            return ["data" => $numbers];

        } catch (\Exception $exception) {
            return ["data" => []];
        }
    }


    public function setNumbers(Request $request)
    {
        // gelen NUMARA ID leri, virgül ile ayarılmış text halinde gelebilir.
        // 1,2,3,4,5 gibi.
        $nums = $request->input("numbers");

        $numbers = explode(",", $nums);

        $process = Process::where("active", 1)->first();

        $process->processNumbers()->whereIn("number_id", $numbers)->update(["sent" => 1]);

        return ["data" => []];
    }

}
