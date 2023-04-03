<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>User Sign-up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <style type="text/css">
    .username-available-msg, .username-taken-msg {
      display: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="mt-4 mb-4">User Sign up</h1>
    <div class="username-available-msg alert alert-primary" role="alert">
      Username is available. Please continue to fill out this lovely form.
    </div>
    <div class="username-taken-msg alert alert-danger" role="alert">
      Sorry this username is taken. Please choose a different username.
    </div>
    <form>
      <div class="form-row mt-4">
        <div class="form-group col-md-6">
          <label for="inputUsername">Username</label>
          <input type="text" class="form-control" id="inputUsername" placeholder="Username">
        </div>
        <div class="form-group col-md-6">
          <label for="inputPassword4">Password</label>
          <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
        </div>
      </div>
      <div class="form-group">
        <label for="inputAddress">Address</label>
        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
      </div>
      <div class="form-group">
        <label for="inputAddress2">Address 2</label>
        <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputCity">City</label>
          <input type="text" class="form-control" id="inputCity">
        </div>
        <div class="form-group col-md-4">
          <label for="inputState">State</label>
          <select id="inputState" class="form-control">
            <option selected>Choose...</option>
            <option>...</option>
          </select>
        </div>
        <div class="form-group col-md-2">
          <label for="inputZip">Zip</label>
          <input type="text" class="form-control" id="inputZip">
        </div>
      </div>
     <button type="submit" class="btn btn-primary">Sign in</button>
    </form> 
  </div>
  <!-- Load JS last so that the DOM is available within the script. -->
  <script src="main.js"></script>
</body>
</html>