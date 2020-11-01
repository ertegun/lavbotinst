<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Insta;
use Illuminate\Support\Str;

class MessageController extends Controller
{

    public function create()
    {
        // return view('carcreate');
    }

    public function test()
    {
        // return view('carcreate');
        // return View::make('pages.home');
        $messages = 234;
        return  view('pages.home', compact('messages'));
    }

    public function getMessagesFromDB()
    {
        $messages = Message::all();
        // return view('messageindex', compact('messages'));
        return  view('pages.mdb', compact('messages'));
    }

    public function getInbox()
    {
        $json = Insta::getInbox();
        return response()->json($json);
    }
    public function comments($item_id)
    {
        $minId = '';
        $json = Insta::getComments($item_id, array('min_id' =>  $minId));
        // $comments = json_decode($json);
        // $minId = $json->getNextMinId();

        // $maxId = $json->getNextMaxId();
        // var_dump($maxId);
        // dd($comments);


        /**
         * MediaCommentsResponse.
         *
         * @method Model\Caption getCaption()
         * @method bool getCaptionIsEdited()
         * @method int getCommentCount()
         * @method bool getCommentLikesEnabled()
         * @method Model\Comment[] getComments()
         * @method bool getHasMoreComments()
         * @method bool getHasMoreHeadloadComments()
         * @method string getMediaHeaderDisplay()
         * @method mixed getMessage()
         * @method string getNextMaxId()
         * @method string getNextMinId()
         */
        // dd($json->getNextMinId());
        $allcomm = array();
        try {
            $minId = null;
            do {
                $response = Insta::getComments($item_id, array('min_id' =>  $minId));
                $comments = json_decode($response, true);
                // var_dump($comments['comments']);
                // exit;
                // In this example we're simply printing the IDs of this page's items.
                // foreach ($response->getItems() as $item) {
                //     printf("[%s] https://instagram.com/p/%s/\n", $item->getId(), $item->getCode());
                // }
                foreach ($comments['comments'] as $key => $value) {
                    $allcomm[] = $value;
                }
                var_dump($minId);
                $minId = $response->getNextMinId();

                // Sleep for 5 seconds before requesting the next page. This is just an
                // example of an okay sleep time. It is very important that your scripts
                // always pause between requests that may run very rapidly, otherwise
                // Instagram will throttle you temporarily for abusing their API!
                echo "Sleeping for 5s...\n";
                sleep(5);
            } while ($minId !== null); // Must use "!==" for comparison instead of "!=".
        } catch (\Exception $e) {
            echo 'Something went wrong: ' . $e->getMessage() . "\n";
        }
        var_dump(count($allcomm));

        // return response()->json(count($comments));


    }
    public function getInfoByName($username)
    {
        $json = Insta::getInfoByName($username);
        return response()->json($json);
    }

    public function runBot()
    {
        $json = Insta::getInbox();
        $inbox = json_decode($json);

        $threads = $inbox->inbox->threads;
        $response = array();
        $response['threads_count'] = count($threads);

        foreach ($threads as $key => $value) :
            $mid = $value->thread_id;

            //Kişilerden gelen mesajlar /SOHBETLER
            $json = Insta::getThread($mid); //$ig->direct->getThread($mid);
            $inbox = json_decode($json, true);
            $mesaj = $inbox['thread']['last_permanent_item'];
            $recipients =
                [
                    'users' => [$mesaj['user_id']] // must be an [array] of valid UserPK IDs | 1596158719=ertegunfidan
                ];
            #sohbetteki son mesajları sisteme kaydediyorum
            try {

                $inserted_count = 0;
                echo $item_type = $mesaj['item_type'];
                if ($item_type == 'profile') {
                    $profile_id = $mesaj['profile']['pk'];
                    $result = Insta::follow($profile_id); // $ig->people->follow($profile_id);
                    $sendMsg = Insta::sendText($recipients, 'Takip isteği gönderildi'); // $ig->direct->sendText($recipients, 'Takip isteği gönderildi');
                    continue;
                }

                if ($item_type == 'placeholder') {
                    $text = $mesaj['placeholder']['message'];
                    if (strpos($text, 'has a private account')) {
                        //Takip edilmeyen sayfa,takip edeceğiz
                        $temp_str = explode("@", $text, 2)[1];
                        $user_name = explode(" ", $temp_str, 2)[0]; //Takip edilecek sayfanın adı
                        $userId = Insta::getUserIdForName($user_name); //$ig->people->getUserIdForName($user_name); //takip edilecek sayfanın id si
                        // $ig->people->follow($userId); 
                        //id ile sayfayı takip ediyoruz.
                        $msg = "B001. Ne yazık ki @$user_name sayfasını takip etmediğim için gönderiye şuan ulaşamıyorum. "
                            . "Ama @$user_name hesabına senin için takip isteği gönderdim.Daha sonra tekrar deneyebilir misin?";
                        Insta::sendText($recipients, $msg);  // $ig->direct->sendText($recipients, $msg);
                        // $ig->direct->hideThread($mid); //Tüm konuşmayı siler
                    }

                    if (strpos($text, 'This post is unavailable because it was deleted')) {
                        #siliniş mesaj.işlem yapılmayacak
                    }

                    continue;
                }

                if ($item_type == 'text') {
                    #text mesaj bir işlem yapılmayacak
                    continue;
                }
                if ($mesaj['user_id'] !=  Insta::$my_user_id) { //son mesaj benim değilse sisteme ekle
                    $m = new Message();
                    $m->uid = Str::random(5);
                    $m->user_id = $mesaj['user_id'];
                    $m->item_type = $mesaj['item_type'];
                    $m->message_id = $mid;
                    $m->item_id = $mesaj['item_id'];
                    $m->datetime_str = date('Y-m-d H:i:s');
                    $m->strtotime = strtotime(date('Y-m-d H:i:s'));
                    $m->status = 0;
                    $m->media_share = $mesaj['media_share'];
                    $inserted = $m->save();
                }

                if ($inserted) {
                    try {
                        $recipients =
                            [
                                'users' => [$m->user_id] // must be an [array] of valid UserPK IDs | 1596158719=ertegunfidan
                            ];

                        $serverUrl = 'http://' . $_SERVER['HTTP_HOST'];
                        $post_item_url = " $serverUrl/p/" . $m->uid;
                        if ($m->user_id != Insta::$my_user_id) {
                            $sendMsg = Insta::sendText($recipients, $post_item_url);
                        }

                        Message::where('item_id', $m->item_id)->update(['status' => 1], ['upsert' => true]);
                    } catch (\Throwable $th) {
                        //throw $th;
                    }

                    $response['thread_' . $key] = $mid;
                    echo $json = Insta::hideThread($mid); //$ig->direct->hideThread($mid); //Tüm konuşmayı siler
                }
            } catch (\Throwable $th) {
                // die($th);
            }

        endforeach;
        // return response()->json($json);

        $messages = Message::all();
        return view('messageindex', compact('messages'));
    }

    public function store(Request $request)
    {
        // $car = new Message();
        // $car->carcompany = $request->get('carcompany');
        // $car->model = $request->get('model');
        // $car->price = $request->get('price');
        // $car->save();
        // return redirect('car')->with('success', 'Car has been successfully added');
    }

    public function sendMessage()
    {
        #Eğer rb çalıştığı starda postu gönderemediyse tekrar göndermek çin status 0 olanlar teker teker göndermek için kullanılır
        //  $x = Insta::Login();
        //  dd( $x);

        $m = Message::where('status', 0)->get()[0];

        $recipients =
            [
                'users' => [$m->user_id] // must be an [array] of valid UserPK IDs | 1596158719=ertegunfidan
            ];

        $serverUrl =  $_SERVER['HTTP_HOST'];
        // dd($_SERVER);
       echo  $post_item_url = "http://$serverUrl/p/" . $m->uid;
        // $post_item_url = "http://grikar.ga";
        // dd($post_item_url);


        if ($m->user_id != Insta::$my_user_id) {
            $json = Insta::sendText($recipients, $post_item_url);
            $sendMsg = json_decode($json, true);
            dd($sendMsg);
            if ($sendMsg['status'] == 'OK') {
                # code...
            }
            return response()->json();
        }

        // echo $json = Insta::hideThread($m->message_id); 
        // return response()->json($messages);
    }

    public function allMessages()
    {
        $messages = Message::all();
        return response()->json($messages);
    }



    public function messages($uid)
    {

        // dd($uid);

        $messages = array();
        // $item_id = $request->get('item_id');
        // dd($item_id);

        if ($uid) {
            // $messages = Message::find(['item_id' => $item_id]);
            $messages = Message::where('uid',  $uid)->get();
        }

        // return view('itemDetail', compact('messages'));
        return  view('pages.post', compact('messages'));
        // return response()->json($messages[0]->media_share['video_versions'][0]['url']);
        // return response()->json($messages[0]->media_share['image_versions2']['candidates'][0]['url']);
    }

    public function edit($id)
    {
        $car = Message::find($id);
        return view('caredit', compact('car', 'id'));
    }


    public function update(Request $request, $id)
    {
        // $car = Message::find($id);
        // $car->carcompany = $request->get('carcompany');
        // $car->model = $request->get('model');
        // $car->price = $request->get('price');
        // $car->save();
        // return redirect('car')->with('success', 'Car has been successfully update');
    }


    public function destroy($id)
    {
        // $car = Message::find($id);
        // $car->delete();
        // return redirect('car')->with('success', 'Car has been  deleted');
    }
}
