  <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Bootstrap CSS -->
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>
      @if (session('message'))
      <div class="alert alert-success">
          {{ session('message') }}
      </div>
      @endif
      <div class="container mt-5">
          <div class="row justify-content-center">
              <div class="col-md-6">
                  <div class="card">
                      <div class="card-header">
                          Username : {{$user->username}}
                      </div>
                      <div class="card-body">
                          <form action="{{ route('edit_profile_handle') }}" method="POST" enctype="multipart/form-data">
                              @csrf <!-- Sử dụng trong Laravel để chống CSRF attacks -->
                              <input type="hidden" class="form-control" id="username" name="username" placeholder="Enter name" value="{{ isset($user->username) ? $user->username : '' }}" required>
                              <div class="mb-3">
                                  <label for="name" class="form-label">Name</label>
                                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ isset($user->id) ? $user->name : '' }}" required>
                              </div>
                              @if(!isset($is_admin))
                              <div class="mb-3">
                                  <label for="email" class="form-label">Email</label>
                                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ isset($user->id) ? $user->email : '' }}">
                              </div>
                              <div class="mb-3">
                                  <label for="phone" class="form-label">Phone</label>
                                  <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" value="{{ isset($user->id) ? $user->phone : '' }}">
                              </div>
                              <div class="mb-3">
                                  <label for="address" class="form-label">Address</label>
                                  <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" value="{{ isset($user->id) ? $user->address : '' }}">
                              </div>
                              <div class="mb-3">
                                  <label for="dayofbirth" class="form-label">Day of Birth</label>
                                  <input type="date" class="form-control" id="dayofbirth" name="dayofbirth" value="{{ isset($user->id) ? $user->dayofbirth : '' }}">
                              </div>
                              <div class="mb-3">
                                  <label for="identification" class="form-label">User ID</label>
                                  <input type="text" class="form-control" id="identification" name="identification" placeholder="Enter identification" value="{{ isset($user->id) ? $user->identification : '' }}" required>
                              </div>
                              <div class="mb-3">
                                  <label for="profile_pic">Avatar:</label>
                                  <input type="file" class="form-control-file" id="avt" name="avt" accept="image/*">
                              </div>
                              @endif
                              <button type="submit" class="btn btn-primary me-2">Update</button>
                              <button type="button" class="btn btn-secondary" onclick="window.location.href='cancel-page-url'">Cancel</button>
                          </form>
                      </div>

                  </div>
              </div>
          </div>
      </div>
      <!-- Bootstrap JS -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>

  </html>