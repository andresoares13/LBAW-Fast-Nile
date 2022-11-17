<article id='profile_list'>
  <ul>
    <li>Name: <?=$user->names ?>  </li>
    <li>Address: <?php if ($user->address != ""){echo $user->address;} else {echo "Undefined";} ?>
    <?php if (count($auctioneer) != 0) {?>
    <li>Phone number: {{$auctioneer[0]["phone"]}}</li>
    <?php } ?>
    @if (auth()->user()->id == substr(strrchr(url()->current(),"/"),1))
    <?php if (count($auctioneer) == 0) { ?>
    <li>
        <a href="{{ url('/profile/upgrade/'. strval(auth()->user()->id))}}"><button>Become an auctioneer </button> </a>
    </li>
    <?php } ?>
    <li>
        <a href="{{ url('/profile/edit/'. strval(auth()->user()->id))}}"><button>Edit Profile Information </button> </a>
    </li>
    <li>
        <a href="{{ url('/profile/wallet/'. strval(auth()->user()->id))}}"><button>Add funds</button> </a>
    </li>
    <li>
        <p>
        <input onclick="openDialog('Delete Account')" type="submit" value="Delete Account">
        <div hidden id="dialog1" class="modal">
            <div class="modal-content">
                <p>Are you sure you want to delete your account forever? It is a very long time.</p>
                <div class="bu">
                    <input onclick="closeDialog('Delete Account')" type="button" value="Cancel">
                    <form action="" method="post">
                        <input type="submit" name="Submit" value="Delete">
                    </form>
                </div>
            </div>
        </div>
        </p>
    </li>
    @endif
  </ul>
  <div id='profile_image'>
    <img src="{{asset('img/profile/' . $user->picture)}}" alt="ProfilePic">
    <a href="{{ url('/profile/picture/'. strval(auth()->user()->id))}}"><button>Change profile picture</button></a>
  </div>
  
</article>
