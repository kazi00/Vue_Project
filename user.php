<?php

     // Server connection
     $conn = new mysqli('localhost','root','','new_curd');

     // Get all fetch data
     $data = json_decode(file_get_contents('php://input'));

     // Get action
     $action = 'read';
     if(isset($_GET['action'])){
         $action = $_GET['action'];
     }
     // Get all users data
     if( $action == 'read'){
     $data = $conn -> query("SELECT * FROM user ORDER By id DESC");     
     $all_users = [];
     while( $user = $data -> fetch_assoc() ){
        array_push($all_users, $user);
     }

    echo json_encode($all_users);
    }

     
     /*
     * *Create new user Action
     */

     if( $action == 'create'){

          // Get val
         // $name = $data -> name;
         // $email = $data -> email;
         // $cell = $data -> cell;


         $file_name = $_FILES['photo']['name'];
         $file_tmp_name = $_FILES['photo']['tmp_name'];

         
         //Upload Profile Photo

         move_uploaded_file($file_tmp_name, '../photos/users/' . $file_name);

        //Get values
         $name =  $_POST['name'];
         $email=  $_POST['email'];
         $cell =  $_POST['cell'];
      
         // Sent data
         $conn -> query("INSERT INTO user (name, email, cell, photo) VALUES ('$name','$email','$cell','$file_name')");
         }

     /*
     * *Create Delete user Action
     */

    if( $action == 'delete'){

     // Get User id
      $id = $_GET['id'];

    // Delete user data query
     $conn -> query("DELETE FROM user WHERE id ='$id'");

}
  /*
     * *Single user View Action
     */

    if( $action == 'single'){

        // Get user id
       $id = $_GET['id'];

       // Get single user data
     $data = $conn -> query("SELECT * FROM user WHERE id ='$id'");

     $single_user_data = $data -> fetch_assoc();

     echo json_encode($single_user_data);



   
   }
 /*
     * *Search user Action
     */

    if( $action == 'search'){

      // Get user id
     $search = $_GET['s'];

    // Get search result
    $data = $conn -> query("SELECT * FROM user WHERE name LIKE '%$search%'"); 

    $search_result =[];
    while(  $result = $data -> fetch_assoc()){
      array_push($search_result ,$result);

    }
    echo json_encode($search_result);

    


 
 }
