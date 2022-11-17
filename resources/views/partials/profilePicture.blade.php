
<form action="/pictureProfile" method="POST" enctype="multipart/form-data" id="profilePictureEdit">
    
{{ csrf_field() }}
    <label for="file"><div id='profile_image'>
    <img src="{{asset('img/profile/' . $user->picture)}}" alt="ProfilePic">
  </div><br><br></label>
    <input type="file" name="image" required="required">
    <input type="hidden" name="user" value="{{ Auth::user()->id }}">
    <button type="submit" >Upload</button>
</form>