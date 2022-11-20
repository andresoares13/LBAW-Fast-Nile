<h1 id="profileTitle">
        Admin Profile
    </h1>
    <br>
<article id='profile_list'>
  <ul>
    <li>Name: <?=$admin->names ?>  </li>
    @if (auth()->guard('admin')->user()->id == substr(strrchr(url()->current(),"/"),1))
    <li>
        <a href="{{ url('/profileAdmin/edit/'. strval(auth()->guard('admin')->user()->id))}}"><button>Edit Profile Information </button> </a>
    </li>
    <li>
        <a href="{{route('register')}}"><button>Create New User </button> </a>
    </li>
    @endif

  </ul>
  <div id='profile_image'>
    <img src="{{asset('img/profileAdmin/' . $admin->picture)}}" alt="ProfilePic">
    @if (auth()->guard('admin')->user()->id == substr(strrchr(url()->current(),"/"),1))
    <a href="{{ url('/profileAdmin/picture/'. strval(auth()->guard('admin')->user()->id))}}"><button>Change profile picture</button></a>
    @endif

  </div>
  
</article>
