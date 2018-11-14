<?php

namespace App\Http\Controllers;

use App\Last;
use App\Number;
use App\Process;
use App\ProcessNumber;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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

    public function changeActive($id)
    {
        $process = Process::findOrFail($id);
        $process->active = !$process->active;
        $process->save();
        return Redirect::back()->with("type", "success")->with("message", "Güncellendi");
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


        $c = 0;
        $list = [];
        foreach ($numbers as $number) {
            //$list[] = ["process_id" => $id, "number_id" => $number];
            //ProcessNumber::create(["process_id" => $id, "number_id" => $number]);

            $c += 1;
            $list[] = ["process_id" => $id, "number_id" => $number];

            if($c % 500 == 0){
                ProcessNumber::insert($list);
                $list = [];
            }

            //DB::insert("insert into process_numbers (process_id,number_id,sent) values ($id,$number,0)");
        }

        if(count($list) > 0) ProcessNumber::insert($list);

        $count = $numbers->count();

        //ProcessNumber::insert($list);

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


    public function test()
    {

        echo strtotime(date("Y-m-d H:i:s")) - strtotime(Last::first()->date);

    }

    public function getNumbers(Request $request)
    {

        $count = $request->input("count");

        Last::first()->increment("deneme");

     //   sleep(rand(2, 4));



            Last::first()->update(["date" => date("Y-m-d H:i:s")]);

            $process = Process::where("active", 1)->first();

            if (!$process) return [
                "process" => null,
                "numbers" => []
            ];

            $collection = $process->processNumbers()->where("sent", 0)->orderBy("id", "asc")->limit($count);
            $numbers = $collection->with("number")->get();

            // -1 , mobil cihaza gönderildi , 1 mesaj gönderildi
            $collection->update(["sent" => -1]);

            $list = [];
            foreach ($numbers as $number) {
                $list[] = $number->number;
            }

            // başında 0 olmadan verdiriyorum, mobil tarafında başına 0 koyulacak.
            // data arrayı içinde objeler olarak gönderiliyor.
            $result = [
                "process" => $process,
                "numbers" => $list
            ];

            $result = json_encode($result,JSON_UNESCAPED_UNICODE);

            Cache::forget("getNumbers");
            Cache::put("getNumbers", $result, 1);

            return $result;
        


    }



    public function getNumbers2($count)
    {


       // sleep(rand(2, 4));

        Last::first()->increment("deneme");


      
            Last::first()->update(["date" => date("Y-m-d H:i:s")]);

            $process = Process::where("active", 1)->first();

            if (!$process) return [
                "process" => null,
                "numbers" => []
            ];

            $collection = $process->processNumbers()->where("sent", 0)->orderBy("id", "asc")->limit($count);
            $numbers = $collection->with("number")->get();

            // -1 , mobil cihaza gönderildi , 1 mesaj gönderildi
            $collection->update(["sent" => -1]);

            $list = [];
            foreach ($numbers as $number) {
                $list[] = $number->number;
            }

            // başında 0 olmadan verdiriyorum, mobil tarafında başına 0 koyulacak.
            // data arrayı içinde objeler olarak gönderiliyor.
            $result = [
                "process" => $process,
                "numbers" => $list
            ];

            $result = json_encode($result,JSON_UNESCAPED_UNICODE);


            return $result;
        


        /*
        try {
            $collection = $process->processNumbers()->where("sent", 0)->orderBy("id","asc")->limit($count);

            //$numbers = $collection->get();

            $numbers = $collection->with("number")->get();

            // -1 , mobil cihaza gönderildi , 1 mesaj gönderildi
            $collection->update(["sent" => -1]);



            $list = [];
            foreach($numbers as $number){
                $list[] = $number->number;
            }

            // başında 0 olmadan verdiriyorum, mobil tarafında başına 0 koyulacak.
            // data arrayı içinde objeler olarak gönderiliyor.
            return [
                "process" => $process,
                "numbers" => $list
            ];

        } catch (\Exception $exception) {
            return [
                "process" => null,
                "numbers" => []
            ];
        }
        */


    }
    
    
    public function getNumbers3($count)
    {
        
        /*
          Last::first()->increment("deneme");
          
            $list = [];
            for ($i= 1 ; $i<=10000;$i++) {
                $number = new Number;
                $number->id = $i;
                $number->number = "05428797173";
                
                $list[] = $number ;
            }
            
            
            
            $result = [
                "process" => 1,
                "numbers" => $list
            ];

            
            $result = json_encode($result,JSON_UNESCAPED_UNICODE);

            return $result;
            
            
            */
            
            
            

       // sleep(rand(2, 4));

             Last::first()->increment("deneme");


      
            Last::first()->update(["date" => date("Y-m-d H:i:s")]);

            $process = Process::where("active", 1)->first();

            if (!$process) return [
                "process" => null,
                "numbers" => []
            ];

            $collection = $process->processNumbers()->where("sent", 0)->orderBy("id", "asc")->limit($count);
            $numbers = $collection->with("number")->get();

            // -1 , mobil cihaza gönderildi , 1 mesaj gönderildi
            $collection->update(["sent" => -2]);

            $list = [];
            foreach ($numbers as $number) {
                $list[] = $number->number;
            }

            // başında 0 olmadan verdiriyorum, mobil tarafında başına 0 koyulacak.
            // data arrayı içinde objeler olarak gönderiliyor.
            $result = [
                "process" => $process,
                "numbers" => $list
            ];

            $result = json_encode($result,JSON_UNESCAPED_UNICODE);

            return $result;
        



    }


    public function setNumbers(Request $request)
    {
        // gelen NUMARA ID leri, virgül ile ayarılmış text halinde gelebilir.
        // 1,2,3,4,5 gibi.
        $nums = $request->input("numbers");

       // Number::create(["test" => $nums, "number" => rand(1,1000)]);

        //return ;
        $numbers = explode(",", $nums);

        $process = Process::where("active", 1)->first();

        $process->processNumbers()->whereIn("number_id", $numbers)->update(["sent" => 1]);

        return ["error" => false];
    }
    
    
    public function setNumbers2(Request $request)
    {
        // gelen NUMARA ID leri, virgül ile ayarılmış text halinde gelebilir.
        // 1,2,3,4,5 gibi.
        $nums = $request->input("numbers");

       // Number::create(["test" => $nums, "number" => rand(1,1000)]);

        //return ;
        $numbers = explode(",", $nums);

        $process = Process::where("active", 1)->first();

        $process->processNumbers()->whereIn("number_id", $numbers)->update(["sent" => 2]);

        return ["error" => false];
    }

}
