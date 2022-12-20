@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <p class="h1"> <i class="fas fa-home"></i>  Api </h1>
                </div>
                <div class="card-body">

                <ol>
                    <li class="h3">SingUp</li>
                    <p><b>url: </b>http://app-api.atlantis-it.com.au/api/v1/users</p>
                    <p><b>type: </b>POST</p>
                    <p><b>header:</b> - </p>
                    <p><b>body type: </b>form-data</p>
                    <p><b>attributes: </b>first_name :string, last_name :string, email :string, password :string, avatar_location :file (image)</p>
                    <p><b>Example: </b>Create Form with 5 inputs have the same attributes names </p>
                    <p><b>Return: </b>the new user object</p>

                    <li class="h3">Login</li>
                    <p><b>url: </b>http://app-api.atlantis-it.com.au/api/v1/auth/login</p>
                    <p><b>type: </b>POST</p>
                    <p><b>header:</b> - </p>
                    <p><b>body type: </b>json</p>
                    <p><b>attributes: </b>email , password, question_id, answer</p>
                    <p><b>Example: </b>{"email":"admin@admin.com","password":"1234","question_id":0,"answer":"two"}</p>
                    <p><b>Return: </b>message , token</p>

                    <li class="h3">Get my account info</li>
                    <p><b>url: </b>http://app-api.atlantis-it.com.au/api/v1/auth/me</p>
                    <p><b>type: </b>GET</p>
                    <p><b>header:</b> Authorization : Bearer token </p>
                    <p><b>body type: </b> - </p>
                    <p><b>attributes: </b> - </p>
                    <p><b>Example: </b>-</p>
                    <p><b>Return: </b> user object </p>

                    <li class="h3">Logout</li>
                    <p><b>url: </b>http://app-api.atlantis-it.com.au/api/v1/auth/logout</p>
                    <p><b>type: </b>POST</p>
                    <p><b>header:</b> Authorization : Bearer token (you'll get it when login)</p>
                    <p><b>body type: </b> - </p>
                    <p><b>attributes: </b> - </p>
                    <p><b>Example: </b>-</p>
                    <p><b>Return: </b> message </p>

                    <li class="h3">Update a specific user by its id</li>
                    <p><b>url: </b>http://app-api.atlantis-it.com.au/api/v1/auth/users/{id}?_method=PATCH</p>
                    <p><b>parameters: </b>id (of the user you want get his account info)</p>
                    <p><b>type: </b>POST</p>
                    <p><b>header:</b> Authorization : Bearer token </p>
                    <p><b>body type: </b> form-data </p>
                    <p><b>attributes: </b>(put only the changed attributes) first_name :string, last_name :string, email :string, password :string, avatar_location :file (image) </p>
                    <p><b>Example: </b>-</p>
                    <p><b>Return: </b> user new data </p>
                    <div class="alert alert-danger">
                        <ol>
                            <li>this api can change any attribute of user account except "password", just add the changed attributes</li>
                            <li>if you don't want change image of account then you can post api as json file.</li>
                        </ol>
                    </div>

                    <li class="h3">Get 20 usres</li>
                    <p><b>url: </b>http://app-api.atlantis-it.com.au/api/v1/auth/users</p>
                    <p><b>type: </b>Get</p>
                    <p><b>header:</b> -</p>
                    <p><b>body type: </b> - </p>
                    <p><b>attributes: </b> - </p>
                    <p><b>Example: </b>-</p>
                    <p><b>Return: </b> 20 users data, and an url to get the next 20 users and so on, that make performance better (lazy load) than get them all at once</p>
                
                    <li class="h3">Get a specific user by its id</li>
                    <p><b>url: </b>http://app-api.atlantis-it.com.au/api/v1/auth/users/{id}</p>
                    <p><b>parameters: </b>id (of the user you want get his account info), replace {id} in url with the value if id</p>
                    <p><b>type: </b>GET</p>
                    <p><b>header:</b> Authorization : Bearer token </p>
                    <p><b>body type: </b> - </p>
                    <p><b>attributes: </b> - </p>
                    <p><b>Example: </b>-</p>
                    <p><b>Return: </b> user account data </p>

                    <li class="h3">Change Password</li>
                    <p><b>url: </b>http://app-api.atlantis-it.com.au/api/v1/auth/password/change?_method=PATCH</p>
                    <p><b>parameters: </b>-</p>
                    <p><b>type: </b>POST</p>
                    <p><b>header:</b> Authorization : Bearer token </p>
                    <p><b>body type: </b> json or Form-data </p>
                    <p><b>attributes: </b> password </p>
                    <p><b>Example: </b>{"password" : "Aap$227"}</p>
                    <p><b>Return: </b> message </p>

                    <li class="h3">look for user</li>
                    <p><b>url: </b>http://app-api.atlantis-it.com.au/api/v1/search-user/{al}</p>
                    <p><b>parameters: </b>al</p>
                    <p><b>type: </b>Get</p>
                    <p><b>header:</b> Authorization : Bearer token </p>
                    <p><b>body type: </b> - </p>
                    <p><b>attributes: </b> - </p>
                    <p><b>Example: </b>change "al" in the url with any string to search for</p>
                    <p><b>Return: </b> array of identical users </p>

                    <li class="h3">upload Files</li>
                    <p><b>url: </b>http://app-api.atlantis-it.com.au/api/v1/auth/upload-file</p>
                    <p><b>parameters: </b>-</p>
                    <p><b>type: </b>POST</p>
                    <p><b>header:</b> Authorization : Bearer token </p>
                    <p><b>body type: </b> Form-data </p>
                    <p><b>attributes: </b> files[] </p>
                    <p><b>Example: </b> upload any file by "form" html tag  with input name="files[]" and type="file"</p>
                    <p><b>Return: </b> array of identical users </p>
                    
                    <li class="h3">upload Images</li>
                    <p><b>url: </b>http://app-api.atlantis-it.com.au/api/v1/auth/upload-image</p>
                    <p><b>parameters: </b>-</p>
                    <p><b>type: </b>POST</p>
                    <p><b>header:</b> Authorization : Bearer token </p>
                    <p><b>body type: </b> Form-data </p>
                    <p><b>attributes: </b> images[] </p>
                    <p><b>Example: </b> upload any file by "form" html tag  with input name="images[]" and type="file"</p>
                    <p><b>Return: </b> array of identical users </p>

                    <li class="h3">upload Vedios</li>
                    <p><b>url: </b>http://app-api.atlantis-it.com.au/api/v1/auth/upload-vedio</p>
                    <p><b>parameters: </b>-</p>
                    <p><b>type: </b>POST</p>
                    <p><b>header:</b> Authorization : Bearer token </p>
                    <p><b>body type: </b> Form-data </p>
                    <p><b>attributes: </b> vedios[] </p>
                    <p><b>Example: </b> upload any vedio by "form" html tag with input name="vedios[]" and type="file"</p>
                    <p><b>Return: </b> array of identical users </p>
                </ol> 
                </div>
                <p>
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
