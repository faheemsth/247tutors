@extends('layouts/app')
@section('content')
    @if (Auth::check())
        @if (Auth::user()->role_id == '4')
            @include('layouts.studentnav')
        @elseif (Auth::user()->role_id == '3')
            @include('layouts.tutornav')
        @elseif (Auth::user()->role_id == '5' || Auth::user()->role_id == '6'))
            @include('layouts.parentnav')
        @elseif (Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
            @include('layouts.navbar')
        @endif
    @else
        @include('layouts.navbar')
    @endif
    
<style>

.postimg {
  max-width: 100%;
  width: auto;
  height: auto;
}
.postlink {
  color: #08c;
  font-weight: bold;
  text-decoration: none;
}
.hentry {
  max-width: 46em;
  margin: auto;
}
.entry-title {
  grid-area: header;
  
  text-transform: uppercase;
  margin: 1em 0 0.5em;
  line-height: 1;
}
.featured-image {
  grid-area: featimg;
}
.entry-meta {
  grid-area: meta;
  margin-bottom: 2em;
}
.entry-content {
  grid-area: content;
}
.entry-footer {
  grid-area: footer;
  text-align: right;
  border-top: 1px solid #777;
  margin-top: 1em;
}
.author, .date {
  color: #777;
}
.author+.date:before {
    content: " | ";
}
.author {
  a {
    color: #000;
    font-weight: bold;
    text-decoration: none;
  }
}
@media (min-width: 40em) {
  /* .hentry {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-column-gap: 20px;
    grid-template-areas: "header header header header" "meta meta meta meta" "featimg featimg featimg featimg" "content content content content" "footer footer footer footer";
  } */
  .entry-title {
    font-size: 2.5em;
    margin-bottom: 0;
  }
}
@media (min-width: 50em) {
  /* .hentry {
    grid-template-areas: "header header header header" "featimg featimg featimg featimg" "meta content content content" "footer footer footer footer";
  } */
  .author, .date {
    display: block;
    margin: 1em 0;
  }
  .author+.date:before {
    display: none;
  }
  .entry-title {
    font-size: 3m;
    margin-bottom: 0.7em;
  }
}
/* .... */

#app {

  background: white;
  padding-bottom: 12px;
  border: 1px solid #dddfe2;
  border-radius: 4px;
}

/* Feedback */

#app .feedback-info {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #dadde1;
  margin: 10px 12px 0 12px;
  padding: 0 0 10px 0;
  color: #938FA4;
}

#app .feedback-info .feedback-emojis {
  min-width: 100px;
  font-size: 14px;
  display: flex;
  align-items: center;
}

#app .feedback-info .feedback-emojis .icons.laugh-icon {
  background-image: url("https://i.imgur.com/KNd9mL2.png");
  background-repeat: no-repeat;
  background-size: 49px 660px;
  height: 16px;
  width: 16px;
  line-height: 16px;
  margin-left: -2px;
  margin-right: 2px;
  background-position: -17px -475px;
}

#app .feedback-info .feedback-emojis .icons.angry-icon {
  background-image: url("https://i.imgur.com/KNd9mL2.png");
  background-repeat: no-repeat;
  background-size: 49px 660px;
  height: 16px;
  width: 16px;
  line-height: 16px;
  margin-left: -4px;
  margin-right: 2px;
  background-position: -17px -441px;
}

#app .feedback-info .feedback-emojis .icons.wow-icon {
  background-image: url("https://i.imgur.com/KNd9mL2.png");
  background-repeat: no-repeat;
  background-size: 49px 660px;
  height: 16px;
  width: 16px;
  line-height: 16px;
  margin-left: -4px;
  margin-right: 4px;
  background-position: 0 -543px;
}


#app .feedback-info .threads-and-share {
  font-size: 14px;
}

#app .feedback-action {
  display: flex;
  justify-content: space-around;
  align-items: center;
  color: #606770;
  font-weight: 600;
  font-size: 14px;
  height: 32px;
  padding: 4px 12px;
}

#app .feedback-action div {
  cursor: pointer;
}

#app .feedback-action .fb-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  min-height: 32px;
}

#app .feedback-action .fb-wrapper:hover {
  background-color: rgba(29, 33, 41, 0.04);
  border-radius: 2px;
  text-decoration: none;
}

#app .feedback-action .fb-wrapper .fb-icon {
  width: 18px;
  height: 18px;
  display: inline-block;
  background-repeat: no-repeat;
  margin-right: 6px;
  font-size: 18px;
}

#app .feedback-action .fb-wrapper .fb-icon.share {
  background-image: url("https://i.imgur.com/1V94KpF.png");
  background-size: 161px 376px;
  background-position: -61px -249px;
}

#app .comments {
  margin: 0 12px;
  border-top: 1px solid #dadde1;
}

#app .comments .my-comment-wrapper {
  display: flex;
  align-items: center;
  margin-top: 12px;
}

#app .comments .my-comment-wrapper .my-avatar img {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: block;
  margin-right: 6px;
}

#app .comments .my-comment-wrapper .my-comment {
  background-color: #f2f3f5;
  border: 1px solid #ccd0d5;
  border-radius: 17px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: text;
  flex: auto;
  line-height: 16px;
  padding: 7px 12px;
}

#app .my-comment-wrapper .my-comment .my-comment-placeholder input[type=text] {
  /* width: 410px; */
  outline: none;
  border: 0 solid transparent;
  background: transparent;
}

#app .comments .people-comment-wrapper {
  display: flex;
  align-items: flex-start;
  margin-top: 10px;
}

#app .comments .people-comment-wrapper .people-avatar img {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: block;
  margin-right: 6px;
}

#app .comments .people-comment-wrapper .people-comment {
  background: #f2f3f5;
  border-radius: 18px;
  color: #1c1e21;
  line-height: 16px;
  padding: 8px 12px;
  position: relative;
}

#app .people-comment-wrapper .people-comment .people-comment-container {
  color: #1c1e21;
  font-size: 14px;
  display: flex;
  flex-direction: column;
}

#app .people-comment-wrapper .people-comment .people-comment-container .people-name {
  font-weight: 600;
  margin-right: 4px;
}

#app .people-comment-wrapper .people-comment .people-comment-container .people-name a {
  text-decoration: none;
  color: #365899;
}

#app .people-comment-wrapper .people-comment .people-comment-container .people-name:hover {
  text-decoration: underline;
}

#app .people-comment-wrapper .people-comment .people-comment-container .people-name .blue-check {
  margin-left: 4px;
  background-image: url("https://i.imgur.com/xgnUC5P.png");
  background-repeat: no-repeat;
  background-size: 28px 195px;
  background-position: 0 -165px;
  height: 15px;
  vertical-align: -2px;
  width: 15px;
  display: inline-block;
}

#app .people-comment-wrapper .people-comment .people-comment-container .people-sharing img {
  width: 350px;
}

#app .people-comment-wrapper .people-comment .comment-reactions {
  position: absolute;
  bottom: 4px;
  right: -25px;
  z-index: 9999;
  display: flex;
  align-items: center;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.2);
  color: #8d949e;
  font-size: 12px;
  padding: 2px 1px 2px 4px;
}

#app .people-comment-wrapper .people-comment .comment-reactions .icons.like-icon {
  background: #fff;
  border-radius: 12px;
  box-shadow: 2px 0 white;
  overflow: hidden;
  background-image: url("https://i.imgur.com/KNd9mL2.png");
  background-repeat: no-repeat;
  background-size: 49px 660px;
  background-position: 0 -526px;
  cursor: pointer;
  height: 16px;
  width: 16px;
  line-height: 16px;
  display: inline-block;
  margin-left: -2px;
  margin-right: 2px;
}

#app .people-comment-wrapper .people-comment .comment-reactions .number {
  padding: 0 3px 0 2px;
}

#app .like-and-response-wrapper {
  display: flex;
  color: #90949c;
  font-size: 13px;
  line-height: 13px;
  margin: 5px 0 0 50px;
}

#app .like-and-response-wrapper .tiny-dot {
  margin-left: -2px;
  margin-right: 2px;
  color: #8d949e;
}

#app .like-and-response-wrapper .like-comment {
  color: #365899;
  cursor: pointer;
}


</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@if (session('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif

@if (session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif
    <article class="hentry my-5 py-5 px-4 px-md-5 px-lg-2">
       

        <h1 class="entry-title">{{$blog->title}}</h1>
        <div class="featured-image">
          <img class="postimg w-100" src="{{asset($blog->image)}}" alt="">
        </div>
        <div class="entry-meta">
          <p><span class="author">Written by <a class="postlink" href="#">{{optional(App\Models\User::find($blog->author_id))->first_name .' '.optional(App\Models\User::find($blog->author_id))->last_name}}</a></span> <span class="date">
              {{Carbon\Carbon::parse($blog->updated_at)->format('F j, Y \a\t g:i:s A')}}
              </span></p>
        </div>
        <div class="entry-content">
          {!! $blog->content !!}  
        </div>
        <footer class="entry-footer"></footer>
        <div id="app">
       
      
            <div class="feedback-info">
              <div class="feedback-emojis" >
                  {{$blog->is_like}} 
                  Likes
              </div>
              <div class="threads-and-share">
                <div class="threads"> {{ !empty($reply) ? $reply->count() : 0}} comments</div>
              </div>
            </div>
          
            <div class="feedback-action">
                @if(App\Models\Blog::where('is_like_by', Auth::id())->exists())
                    @if(App\Models\Blog::where('is_like_by', Auth::id())->first()->is_like == 1)
                        <a class="fb-wrapper text-decoration-none" href="{{ url('unlike/post/').'/'.$blog->id }}">
                            <i class="fb-icon thumb-down far fa-thumbs-down"></i> Unlike
                        </a>
                    @else
                        <a class="fb-wrapper text-decoration-none" href="{{ url('like/post/').'/'.$blog->id }}">
                            <i class="fb-icon thumb-up far fa-thumbs-up"></i> Like
                        </a>
                    @endif
                @else
                    <a class="fb-wrapper text-decoration-none" href="{{ url('like/post/').'/'.$blog->id }}">
                        <i class="fb-icon thumb-up far fa-thumbs-up"></i> Like
                    </a>
                @endif
              <div class="fb-wrapper">
                <i class="fb-icon response far fa-comment-alt"></i>Comment
              </div>
              <!-- <div class="fb-wrapper">
                <i class="fb-icon share"></i>Share
              </div> -->
            </div>
          
            <div class="comments">
              <div class="my-comment-wrapper">
                <div class="my-avatar">
                    
                    @if (!empty(App\Models\User::find(Auth::id())) && file_exists(public_path(!empty(App\Models\User::find(Auth::id())->image) ? App\Models\User::find(Auth::id())->image : '')))
                        <img src="{{ asset(App\Models\User::find(Auth::id())->image) }}" >
                    @else
                    @if (Auth::check() && App\Models\User::find(Auth::id())->image->gender == 'Male')
                        <img src="{{ asset('assets/images/male.jpg') }}" >
                    @elseif(Auth::check() && App\Models\User::find(Auth::id())->image->gender == 'Female')
                        <img src="{{ asset('assets/images/female.jpg') }}" >
                    @else
                        <img src="{{ asset('assets/images/default.png') }}">
                    @endif
                    @endif
                  
                </div>
                <div class="my-comment">
                  <div class="my-comment-placeholder">
                    <form id="commentForm" action="{{ url('comments/store').'/'.$blog->id }}" method="post">
                        @csrf
                        <input type="text" name="comment_text" id="comment_text" placeholder="Write a comment..." class="w-100">
                    </form>
                  </div>
                </div>
              </div>
              
              
              
              @if(!empty($reply))
              @foreach($reply as $repl)
              <div class="wrapper">
                <div class="people-comment-wrapper">
                  <div class="people-avatar">
                    @if (!empty(App\Models\User::find($repl->user_id)) && file_exists(public_path(!empty(App\Models\User::find($repl->user_id)->image) ? App\Models\User::find($repl->user_id)->image : '')))
                    <img src="{{ asset(App\Models\User::find($repl->user_id)->image) }}" >
                    @else
                    @if (App\Models\User::find($repl->user_id)->image->gender == 'Male')
                    <img src="{{ asset('assets/images/male.jpg') }}" >
                    @elseif(App\Models\User::find($repl->user_id)->image->gender == 'Female')
                    <img src="{{ asset('assets/images/female.jpg') }}" >
                    @else
                    <img src="{{ asset('assets/images/default.png') }}">
                    @endif
                    @endif
                  </div>
                  <div class="people-comment">
                    <div class="people-comment-container">
                      <div class="people-name">
                        <a class="postlink" href="">
                            {{optional(App\Models\User::find($repl->user_id))->first_name .' '. optional(App\Models\User::find($repl->user_id))->last_name}}
                        </a>
                        <i class="blue-check"></i>
                      </div>
                      <div class="people-saying">{{$repl->reply}}</div>
                    </div>
                    
                  </div>
                </div>
                <div class="like-and-response-wrapper">
                  
                  <div class="day-comment">{{Carbon\Carbon::parse($repl->updated_at)->diffForHumans();}}</div>
                </div>
              </div>
              @endforeach
              @endif
              
              
            </div>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        </div>
      </article>

 <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    // Listen for 'Enter' key press in the comment_text input field
    $('#comment_text').keypress(function (e) {
        if (e.which === 13) { // 13 is the key code for 'Enter'
            e.preventDefault(); // Prevent the default form submission
            $('#commentForm').submit(); // Manually submit the form
        }
    });
</script>
 
 @endsection
