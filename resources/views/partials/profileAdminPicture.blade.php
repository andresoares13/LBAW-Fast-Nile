
<form action="/pictureAdminProfile" method="POST" enctype="multipart/form-data" id="profilePictureEdit">
    
    {{ csrf_field() }}
        <label for="file"><div id='profile_image'>
        <img src="{{asset('img/profileAdmin/' . $admin->picture)}}" alt="ProfilePic">
      </div><br><br></label>
        <input type="file" name="image" required="required">
        <input type="hidden" name="admin" value="{{ Auth::guard('admin')->user()->id }}">
        <button type="submit" >Upload</button>
    </form>