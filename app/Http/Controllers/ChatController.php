<?php

namespace App\Http\Controllers;

use App\Events\NewTrade;
use App\Events\GroupChat;
use App\Models\Chat;
use App\Models\Group;
use App\Models\GroupChat as GroupChating;
use App\Models\Notification;
use App\Models\TutorSubjectOffer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    public function Studentchat()
    {

           if(Auth::user()->role_id != 4){
                return  back();
            }


        $tutors = [];

        $chatsUsers = Chat::where('sender_id', Auth::id())->pluck('reciver_id')->unique();

        $c_users = User::whereIn('id', $chatsUsers)->where('id', '!=', Auth::id())->get();
        $j = 0;
        foreach ($c_users as $i => $user) {

            $tutors[$i]['id'] = $user->id;
            $tutors[$i]['username'] = $user->username;
            $tutors[$i]['image'] = $user->image;
            $tutors[$i]['facebook_link'] = $user->facebook_link;

            $j++;
        }

        $chatsUsers = Chat::where('reciver_id', Auth::id())->pluck('sender_id')->unique();

        foreach (User::whereIn('id', $chatsUsers)->where('id', '!=', Auth::id())->get() as $i => $user) {

            $tutors[$i]['id'] = $user->id;
            $tutors[$i]['username'] = $user->username;
            $tutors[$i]['image'] = $user->image;

            $j++;
        }

        // dd($tutors);

        return view('pages.chat.index', compact('tutors'));
    }



        public function Parentchat()
    {

           if(Auth::user()->role_id != 5){
                return  back();
            }


        $tutors = [];

        $chatsUsers = Chat::where('sender_id', Auth::id())->pluck('reciver_id')->unique();

        $c_users = User::whereIn('id', $chatsUsers)->where('id', '!=', Auth::id())->get();
        $j = 0;
        foreach ($c_users as $i => $user) {

            $tutors[$i]['id'] = $user->id;
            $tutors[$i]['username'] = $user->username;
            $tutors[$i]['image'] = $user->image;
            $tutors[$i]['facebook_link'] = $user->facebook_link;

            $j++;
        }

        $chatsUsers = Chat::where('reciver_id', Auth::id())->pluck('sender_id')->unique();

        foreach (User::whereIn('id', $chatsUsers)->where('id', '!=', Auth::id())->get() as $i => $user) {

            $tutors[$i]['id'] = $user->id;
            $tutors[$i]['username'] = $user->username;
            $tutors[$i]['image'] = $user->image;

            $j++;
        }

        // dd($tutors);

        return view('pages.chat.index', compact('tutors'));
    }


            public function Organizationchat()
    {

           if(Auth::user()->role_id != 6){
                return  back();
            }


        $tutors = [];

        $chatsUsers = Chat::where('sender_id', Auth::id())->pluck('reciver_id')->unique();

        $c_users = User::whereIn('id', $chatsUsers)->where('id', '!=', Auth::id())->get();
        $j = 0;
        foreach ($c_users as $i => $user) {

            $tutors[$i]['id'] = $user->id;
            $tutors[$i]['username'] = $user->username;
            $tutors[$i]['image'] = $user->image;
            $tutors[$i]['facebook_link'] = $user->facebook_link;

            $j++;
        }

        $chatsUsers = Chat::where('reciver_id', Auth::id())->pluck('sender_id')->unique();

        foreach (User::whereIn('id', $chatsUsers)->where('id', '!=', Auth::id())->get() as $i => $user) {

            $tutors[$i]['id'] = $user->id;
            $tutors[$i]['username'] = $user->username;
            $tutors[$i]['image'] = $user->image;

            $j++;
        }

        // dd($tutors);

        return view('pages.chat.index', compact('tutors'));
    }

        public function Tutorchat()
    {

           if(Auth::user()->role_id != 3){
                return  back();
            }


        $tutors = [];

        $chatsUsers = Chat::where('sender_id', Auth::id())->pluck('reciver_id')->unique();

        $c_users = User::whereIn('id', $chatsUsers)->where('id', '!=', Auth::id())->get();
        $j = 0;
        foreach ($c_users as $i => $user) {

            $tutors[$i]['id'] = $user->id;
            $tutors[$i]['username'] = $user->username;
            $tutors[$i]['image'] = $user->image;
            $tutors[$i]['facebook_link'] = $user->facebook_link;

            $j++;
        }

        $chatsUsers = Chat::where('reciver_id', Auth::id())->pluck('sender_id')->unique();

        foreach (User::whereIn('id', $chatsUsers)->where('id', '!=', Auth::id())->get() as $i => $user) {

            $tutors[$i]['id'] = $user->id;
            $tutors[$i]['username'] = $user->username;
            $tutors[$i]['image'] = $user->image;

            $j++;
        }

        // dd($tutors);

        return view('pages.chat.index', compact('tutors'));
    }

    public function index($id)
    {

        Chat::where('sender_id', $id)->update(['status' => 1,]);

        $senderId = $id;
        $receiverId = Auth::id();
        $chats = Chat::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                ->where('reciver_id', $receiverId);
        })
            ->orWhere(function ($query) use ($senderId, $receiverId) {
                $query->where('sender_id', $receiverId)
                    ->where('reciver_id', $senderId);
            })
            ->get();
        return view('pages.dashboard.welcome', compact('chats', 'id'));
    }

    public function singlechat($id)
    {

        if (Auth::user()->role_id == '3' && User::find($id)->role_id == '3') {
            return back()->with('error', 'Sorry You Cannot Chat with Tutor');
        }
        Chat::where('sender_id', $id)->update(['status' => 1,]);
        $subject = TutorSubjectOffer::where('tutor_id', $id);
        $senderId = $id;
        $receiverId = Auth::id();
        $chats = Chat::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                ->where('reciver_id', $receiverId);
        })
            ->orWhere(function ($query) use ($senderId, $receiverId) {
                $query->where('sender_id', $receiverId)
                    ->where('reciver_id', $senderId);
            })
            ->get();
        return view('pages.chat.singlechat', compact('chats', 'id', 'subject'));
    }
    public function send_message(Request $request)
    {
        // event(new NewTrade($request->reciver_id, $request->message));

        // $user = User::where(function($query) use ($request) {
        //         $query->where('id', Auth::id());
        //             //   ->where('first_name', 'like', "%" . $request->message . "%")
        //             //   ->orWhere('last_name', 'like', "%" . $request->message . "%");
        //     })
        //     ->first();

        // if (empty($user)) {
        $chat = new Chat();
        $chat->reciver_id = $request->reciver_id;
        $chat->sender_id = Auth::id();
        $chat->message = $request->message;
        $chat->save();

        return response()->json(['status' => 'true']);
        // }
        // else {
        //     return response()->json(['status' => 'false']);
        // }
    }

    public function get_message(Request $request)
    {

        $senderId = $request->id;
        $receiverId = Auth::id();
        $chats = Chat::with(['sender', 'reciver'])->where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                ->where('reciver_id', $receiverId);
        })
            ->orWhere(function ($query) use ($senderId, $receiverId) {
                $query->where('sender_id', $receiverId)
                    ->where('reciver_id', $senderId);
            })
            ->get();
        return response()->json(['chats' => $chats]);
    }


    public function chat_with_students()
    {
        $chats = GroupChating::All();
        $groups = Group::All();
        return view('pages.dashboard.group_chats2', compact('chats', 'groups'));
    }
    public function chat_send_to_student(Request $request)
    {
        if (!empty($request->group)) {
            // event(new GroupChat($request->group,Auth::id(),$request->message));
            $chat = new GroupChating();
            $chat->sender_id = Auth::id();
            $chat->group_id = $request->group;
            $chat->message = $request->message;
            $chat->save();
            return $chat;
        }
    }

    public function create_group(Request $request)
    {

        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        $user = new Group();


        $user->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'user_id' => Auth::id(),
            'image' => 'images/' . $imageName,
        ]);
        return back();
    }

    public function get_chat(Request $request)
    {
        $chats = GroupChating::where('group_id', $request->id)->get();
        $html = '';

        if (!empty($chats)) {
            foreach ($chats as $chat) {
                if ($chat->sender_id == Auth::id()) {
                    $html .= '
                    <li class="me">
                        <div class="entete">
                            <h3>10:12AM</h3>
                            <h2>' . User::find($chat->sender_id)->first_name . ' ' . User::find($chat->sender_id)->last_name . '</h2>
                            <span class="status blue"></span>
                        </div>

                        <div class="message">
                            ' . $chat->message . '
                        </div>
                    </li>';
                } else {
                    $check_sender = GroupChating::where('sender_id', Auth::id())->first();
                    if (!empty($check_sender) || $chats[0]->sender_id == Auth::user()->parent_id) {
                        $html .= '
                        <li class="you">
                            <div class="entete">
                                <span class="status green"></span>
                                <h2>' . User::find($chat->sender_id)->first_name . ' ' . User::find($chat->sender_id)->last_name . '</h2>
                                <h3>10:12AM</h3>
                            </div>

                            <div class="message">
                                ' . $chat->message . '
                            </div>
                        </li>';
                    }
                }
            }
        }
        return $html;
    }
    public function get_notification()
    {
        $notifications = Notification::where('is_read', 0)->get();
        $notificationCount = Notification::with('Notifier')->where('is_read', 0)->whereHas('Notifier', function ($query) {
            $query->whereNotNull('id');
        })->count();
        $html = '';

        if (!empty($notifications)) {
            foreach ($notifications as $notification) {

                $checkUser = User::find($notification->user_id);
                if (!empty($checkUser)) {
                    if ($notification->user_type == 3) {
                        $url = url('tutorProfile') . '/' . $notification->user_id . '?NoteId=' . $notification->id;
                    } elseif ($notification->user_type == 4 && $notification->title == 'Comptaint') {
                        $url = 'Complaintlogs';
                    }
                    $html .= '<a href="' . $url . '" class="list-group-item" data-chat-user="' . optional(User::find($notification->user_id))->username . '">
                        <figure class="user--online">
                            <img src="' . asset(optional(User::find($notification->user_id))->image) . '" class="rounded-circle" alt="">
                        </figure><span><span class="name">' .  optional(User::find($notification->user_id))->username . '</span>  <span class="username">' . $notification->title . '</span> </span>
                    </a>';
                }
            }
        }

        return response()->json(['html' => $html, 'count' => $notificationCount]);
    }
}
